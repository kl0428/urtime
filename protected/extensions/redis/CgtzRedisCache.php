<?php
/**
 * CRedisCache class file
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CRedisCache implements a cache application component based on {@link http://redis.io/ redis}.
 *
 * CRedisCache needs to be configured with {@link hostname}, {@link port} and {@link database} of the server
 * to connect to. By default CRedisCache assumes there is a redis server running on localhost at
 * port 6379 and uses the database number 0.
 *
 * CRedisCache also supports {@link http://redis.io/commands/auth the AUTH command} of redis.
 * When the server needs authentication, you can set the {@link password} property to
 * authenticate with the server after connect.
 *
 * See {@link CCache} manual for common cache operations that are supported by CRedisCache.
 *
 * To use CRedisCache as the cache application component, configure the application as follows,
 * <pre>
 * array(
 *     'components'=>array(
 *         'cache'=>array(
 *             'class'=>'CRedisCache',
 *             'hostname'=>'localhost',
 *             'port'=>6379,
 *             'database'=>0,
 *         ),
 *     ),
 * )
 * </pre>
 *
 * The minimum required redis version is 2.0.0.
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @package system.caching
 * @since 1.1.14
 */
class CgtzRedisCache extends CCache
{
    /**
     * @var string hostname to use for connecting to the redis server. Defaults to 'localhost'.
     */
    public $hostname='localhost';
    /**
     * @var int the port to use for connecting to the redis server. Default port is 6379.
     */
    public $port=6379;
    /**
     * @var string the password to use to authenticate with the redis server. If not set, no AUTH command will be sent.
     */
    public $password;
    /**
     * @var int the redis database to use. This is an integer value starting from 0. Defaults to 0.
     */
    public $database=0;
    /**
     * @var float timeout to use for connection to redis. If not set the timeout set in php.ini will be used: ini_get("default_socket_timeout")
     */
    public $timeout=null;
    /**
     * @var resource redis socket connection
     */
    private $_cache;
    public $servers;

    /**
     * Establishes a connection to the redis server.
     * It does nothing if the connection has already been established.
     * @throws CException if connecting fails
     */
    public function init()
    {
        parent::init();
        $this->connect();
    }
    public function getRedis()
    {
        if($this->_cache!==null)
            return $this->_cache;
        else
        {
            $extension='redis';
            if(!extension_loaded($extension))
                throw new CException(Yii::t('yii',"CgtzRedis requires PHP {extension} extension to be loaded.",
                    array('{extension}'=>$extension)));
            return $this->_cache=new Redis();
        }
    }
    protected function connect()
    {
        $this->_cache= $this->getRedis();
        if ($this->_cache)
        {
            $this->_cache->pconnect($this->hostname,$this->port,$this->timeout,"x");

            if($this->password!==null)
                $this->_cache->auth($this->password);
            //$this->_cache->select($this->database);

        }
        else
            throw new CException('Failed to connect to redis:');
    }

    /**
     * Executes a redis command.
     * For a list of available commands and their parameters see {@link http://redis.io/commands}.
     *
     * @param string $name the name of the command
     * @param array $params list of parameters for the command
     * @return array|bool|null|string Dependend on the executed command this method
     * will return different data types:
     * <ul>
     *   <li><code>true</code> for commands that return "status reply".</li>
     *   <li><code>string</code> for commands that return "integer reply"
     *       as the value is in the range of a signed 64 bit integer.</li>
     *   <li><code>string</code> or <code>null</code> for commands that return "bulk reply".</li>
     *   <li><code>array</code> for commands that return "Multi-bulk replies".</li>
     * </ul>
     * See {@link http://redis.io/topics/protocol redis protocol description}
     * for details on the mentioned reply types.
     * @trows CException for commands that return {@link http://redis.io/topics/protocol#error-reply error reply}.
     */

    /**
     * Retrieves a value from cache with a specified key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key a unique key identifying the cached value
     * @return string|boolean the value stored in cache, false if the value is not in the cache or expired.
     */
    protected function getValue($key)
    {
        //var_dump($this->_cache->get($key));exit();
        return $this->_cache->get($key);
    }

    /**
     * Retrieves multiple values from cache with the specified keys.
     * @param array $keys a list of keys identifying the cached values
     * @return array a list of cached values indexed by the keys
     */
    /*
    protected function getValues($keys)
    {
        foreach($keys as $key=>$value)
        {
            $k[] = $value;
        }
        var_dump($k);
        return $this->_cache->mget($k);
    }
*/
    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function setValue($key,$value,$expire)
    {

        if ($expire==0)
            return (bool)$this->_cache->set($key,$value);
        return (bool)$this->_cache->setex($key,$expire,$value);
    }

    /**
     * Stores a value identified by a key into cache if the cache does not contain this key.
     * This is the implementation of the method declared in the parent class.
     *
     * @param string $key the key identifying the value to be cached
     * @param string $value the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function addValue($key,$value,$expire)
    {
        if ($expire == 0)
            return (bool)$this->_cache->setex($key,$value);

        if($this->_cache->setex($key,$value))
        {
            $this->_cache->expire($key,$expire);
            return true;
        }
        else
            return false;
    }

    /**
     * Deletes a value with the specified key from cache
     * This is the implementation of the method declared in the parent class.
     * @param string $key the key of the value to be deleted
     * @return boolean if no error happens during deletion
     */
    protected function deleteValue($key)
    {
        return (bool)$this->_cache->del($key);

    }
    public function __call($method, $args) {
        $this->beforePerform($args);
        return call_user_func_array(array($this->_cache, $method), $args);
    }

    private function beforePerform($args){
        if ($args) {
            if (is_string($args[0])) {
                $this->_cache->sadd('statistical.redis.key.set', $args[0]);
            }
        }
    }
}
