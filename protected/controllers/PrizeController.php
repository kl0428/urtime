<?php

/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-6-18
 * Time: 上午10:07
 */
class PrizeController extends Controller
{
    public function actionIndex()
    {
        /* echo "ok";
         exit();*/
        Yii::import("application.extensions.Excel.*");

        $submits = [
            1 => "{\"award_id\":3,\"user_id\":191801986751,\"create_time\":\"2015-06-23 23:58:40\"}",
            2 => "{\"award_id\":9,\"user_id\":191801994779,\"create_time\":\"2015-06-23 23:55:23\"}",
            3 => "{\"award_id\":3,\"user_id\":191801993837,\"create_time\":\"2015-06-23 21:45:59\"}",
            4 => "{\"award_id\":9,\"user_id\":191801990037,\"create_time\":\"2015-06-23 21:27:51\"}",
            5 => "{\"award_id\":3,\"user_id\":191800235275,\"create_time\":\"2015-06-23 21:02:43\"}",
            6 => "{\"award_id\":9,\"user_id\":191801993267,\"create_time\":\"2015-06-23 20:38:19\"}",
            7 => "{\"award_id\":9,\"user_id\":191801962425,\"create_time\":\"2015-06-23 19:25:37\"}",
            8 => "{\"award_id\":2,\"user_id\":191801968415,\"create_time\":\"2015-06-23 18:16:11\"}",
            9 => "{\"award_id\":2,\"user_id\":191801968415,\"create_time\":\"2015-06-23 18:14:51\"}",
            10 => "{\"award_id\":2,\"user_id\":191800184164,\"create_time\":\"2015-06-23 17:04:00\"}",
            11 => "{\"award_id\":2,\"user_id\":191801227759,\"create_time\":\"2015-06-23 16:15:29\"}",
            12 => "{\"award_id\":2,\"user_id\":191801986751,\"create_time\":\"2015-06-23 16:02:27\"}",
            13 => "{\"award_id\":2,\"user_id\":191800310308,\"create_time\":\"2015-06-23 16:01:04\"}",
            14 => "{\"award_id\":9,\"user_id\":191801984385,\"create_time\":\"2015-06-23 15:30:19\"}",
            15 => "{\"award_id\":2,\"user_id\":191801574221,\"create_time\":\"2015-06-23 14:56:47\"}",
            16 => "{\"award_id\":2,\"user_id\":191801636403,\"create_time\":\"2015-06-23 14:37:21\"}",
            17 => "{\"award_id\":2,\"user_id\":191800310308,\"create_time\":\"2015-06-23 14:30:04\"}",
            18 => "{\"award_id\":9,\"user_id\":191801964059,\"create_time\":\"2015-06-23 13:55:29\"}",
            19 => "{\"award_id\":2,\"user_id\":191801228342,\"create_time\":\"2015-06-23 10:26:20\"}",
            20 => "{\"award_id\":9,\"user_id\":191801986382,\"create_time\":\"2015-06-23 08:57:15\"}",
            21 => "{\"award_id\":9,\"user_id\":191801980385,\"create_time\":\"2015-06-22 22:22:46\"}",
            22 => "{\"award_id\":9,\"user_id\":191801985691,\"create_time\":\"2015-06-22 21:30:15\"}",
            23 => "{\"award_id\":9,\"user_id\":191801980791,\"create_time\":\"2015-06-22 16:59:33\"}",
            24 => "{\"award_id\":2,\"user_id\":191800740350,\"create_time\":\"2015-06-22 16:52:57\"}",
            25 => "{\"award_id\":2,\"user_id\":191801983185,\"create_time\":\"2015-06-22 16:32:06\"}",
            26 => "{\"award_id\":3,\"user_id\":191801983185,\"create_time\":\"2015-06-22 16:31:42\"}",
            27 => "{\"award_id\":2,\"user_id\":191801982095,\"create_time\":\"2015-06-22 16:20:12\"}",
            28 => "{\"award_id\":2,\"user_id\":191800740350,\"create_time\":\"2015-06-22 16:09:24\"}",
            29 => "{\"award_id\":2,\"user_id\":191800105795,\"create_time\":\"2015-06-22 14:27:09\"}",
            30 => "{\"award_id\":3,\"user_id\":191800105795,\"create_time\":\"2015-06-22 12:49:05\"}",
            31 => "{\"award_id\":2,\"user_id\":191800341694,\"create_time\":\"2015-06-22 11:24:28\"}",
            32 => "{\"award_id\":2,\"user_id\":191800105795,\"create_time\":\"2015-06-22 11:15:23\"}",
            33 => "{\"award_id\":2,\"user_id\":191801968415,\"create_time\":\"2015-06-22 10:41:10\"}",
            34 => "{\"award_id\":3,\"user_id\":191801968415,\"create_time\":\"2015-06-22 10:40:08\"}",
            35 => "{\"award_id\":2,\"user_id\":191801968415,\"create_time\":\"2015-06-22 10:38:17\"}",
            36 => "{\"award_id\":2,\"user_id\":191800310308,\"create_time\":\"2015-06-22 09:13:57\"}",
            37 => "{\"award_id\":2,\"user_id\":191801968415,\"create_time\":\"2015-06-21 22:37:36\"}",
            38 => "{\"award_id\":2,\"user_id\":191801017957,\"create_time\":\"2015-06-21 22:04:38\"}",
            39 => "{\"award_id\":2,\"user_id\":191800341694,\"create_time\":\"2015-06-21 20:23:18\"}",
            40 => "{\"award_id\":3,\"user_id\":191800095511,\"create_time\":\"2015-06-21 18:56:44\"}",
            41 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-21 18:56:00\"}",
            42 => "{\"award_id\":2,\"user_id\":191800341694,\"create_time\":\"2015-06-21 18:50:43\"}",
            43 => "{\"award_id\":2,\"user_id\":191801968415,\"create_time\":\"2015-06-21 16:16:24\"}",
            44 => "{\"award_id\":2,\"user_id\":191801712085,\"create_time\":\"2015-06-21 15:42:13\"}",
            45 => "{\"award_id\":2,\"user_id\":191801960861,\"create_time\":\"2015-06-21 13:01:18\"}",
            46 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-21 11:52:50\"}",
            47 => "{\"award_id\":9,\"user_id\":191801922512,\"create_time\":\"2015-06-21 10:55:37\"}",
            48 => "{\"award_id\":2,\"user_id\":191800073915,\"create_time\":\"2015-06-21 10:35:12\"}",
            49 => "{\"award_id\":3,\"user_id\":191800073915,\"create_time\":\"2015-06-21 10:11:51\"}",
            50 => "{\"award_id\":9,\"user_id\":191801968032,\"create_time\":\"2015-06-21 09:30:12\"}",
            51 => "{\"award_id\":3,\"user_id\":191801067753,\"create_time\":\"2015-06-20 22:13:50\"}",
            52 => "{\"award_id\":3,\"user_id\":191801067753,\"create_time\":\"2015-06-20 21:10:18\"}",
            53 => "{\"award_id\":3,\"user_id\":191800341694,\"create_time\":\"2015-06-20 19:47:25\"}",
            54 => "{\"award_id\":2,\"user_id\":191800106014,\"create_time\":\"2015-06-20 15:19:13\"}",
            55 => "{\"award_id\":2,\"user_id\":191801967989,\"create_time\":\"2015-06-20 14:29:16\"}",
            56 => "{\"award_id\":2,\"user_id\":191801017957,\"create_time\":\"2015-06-20 13:34:23\"}",
            57 => "{\"award_id\":2,\"user_id\":191801228342,\"create_time\":\"2015-06-20 13:33:33\"}",
            58 => "{\"award_id\":2,\"user_id\":191800073915,\"create_time\":\"2015-06-20 13:29:12\"}",
            59 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-20 13:15:45\"}",
            60 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-20 13:15:38\"}",
            61 => "{\"award_id\":2,\"user_id\":191801017957,\"create_time\":\"2015-06-20 10:27:18\"}",
            62 => "{\"award_id\":2,\"user_id\":191801017957,\"create_time\":\"2015-06-20 09:55:00\"}",
            63 => "{\"award_id\":2,\"user_id\":191800299463,\"create_time\":\"2015-06-20 09:27:50\"}",
            64 => "{\"award_id\":2,\"user_id\":191800521498,\"create_time\":\"2015-06-19 23:48:49\"}",
            65 => "{\"award_id\":2,\"user_id\":191801228342,\"create_time\":\"2015-06-19 23:05:46\"}",
            66 => "{\"award_id\":2,\"user_id\":191801227759,\"create_time\":\"2015-06-19 20:57:09\"}",
            67 => "{\"award_id\":2,\"user_id\":191801749203,\"create_time\":\"2015-06-19 15:57:57\"}",
            68 => "{\"award_id\":3,\"user_id\":191801228342,\"create_time\":\"2015-06-19 14:44:34\"}",
            69 => "{\"award_id\":2,\"user_id\":191800087977,\"create_time\":\"2015-06-18 23:35:45\"}",
            70 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-18 22:47:58\"}",
            71 => "{\"award_id\":3,\"user_id\":191800106014,\"create_time\":\"2015-06-18 21:43:34\"}",
            72 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-17 20:35:25\"}",
            73 => "{\"award_id\":2,\"user_id\":191800106014,\"create_time\":\"2015-06-17 18:25:04\"}",
            74 => "{\"award_id\":2,\"user_id\":191800106014,\"create_time\":\"2015-06-17 18:24:08\"}",
            75 => "{\"award_id\":2,\"user_id\":191800087977,\"create_time\":\"2015-06-17 16:44:08\"}",
            76 => "{\"award_id\":2,\"user_id\":191800141885,\"create_time\":\"2015-06-17 16:05:43\"}",
            77 => "{\"award_id\":2,\"user_id\":191800044211,\"create_time\":\"2015-06-17 14:48:26\"}",
            78 => "{\"award_id\":2,\"user_id\":191801228342,\"create_time\":\"2015-06-17 11:54:05\"}",
            79 => "{\"award_id\":2,\"user_id\":191801456290,\"create_time\":\"2015-06-17 11:28:51\"}",
            80 => "{\"award_id\":2,\"user_id\":191801658615,\"create_time\":\"2015-06-17 10:42:36\"}",
            81 => "{\"award_id\":2,\"user_id\":191801658615,\"create_time\":\"2015-06-17 10:41:43\"}",
            82 => "{\"award_id\":3,\"user_id\":191800732024,\"create_time\":\"2015-06-16 14:49:03\"}",
            83 => "{\"award_id\":3,\"user_id\":191800521498,\"create_time\":\"2015-06-16 14:20:27\"}",
            84 => "{\"award_id\":2,\"user_id\":191800007009,\"create_time\":\"2015-06-16 14:05:21\"}",
            85 => "{\"award_id\":2,\"user_id\":191801749559,\"create_time\":\"2015-06-16 00:04:43\"}",
            86 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-15 23:21:18\"}",
            87 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-15 22:54:12\"}",
            88 => "{\"award_id\":3,\"user_id\":191801228342,\"create_time\":\"2015-06-15 21:38:28\"}",
            89 => "{\"award_id\":2,\"user_id\":191801918904,\"create_time\":\"2015-06-15 18:57:47\"}",
            90 => "{\"award_id\":9,\"user_id\":191801917683,\"create_time\":\"2015-06-15 14:58:24\"}",
            91 => "{\"award_id\":3,\"user_id\":191800521498,\"create_time\":\"2015-06-14 21:07:40\"}",
            92 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-14 20:49:47\"}",
            93 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-14 20:48:49\"}",
            94 => "{\"award_id\":2,\"user_id\":191801893455,\"create_time\":\"2015-06-14 19:48:47\"}",
            95 => "{\"award_id\":2,\"user_id\":191801120440,\"create_time\":\"2015-06-14 19:30:06\"}",
            96 => "{\"award_id\":9,\"user_id\":191801911766,\"create_time\":\"2015-06-14 19:20:49\"}",
            97 => "{\"award_id\":2,\"user_id\":191801120440,\"create_time\":\"2015-06-14 18:53:19\"}",
            98 => "{\"award_id\":3,\"user_id\":191801572231,\"create_time\":\"2015-06-14 18:25:53\"}",
            99 => "{\"award_id\":2,\"user_id\":191801477887,\"create_time\":\"2015-06-14 13:32:26\"}",
            100 => "{\"award_id\":2,\"user_id\":191800090746,\"create_time\":\"2015-06-14 12:55:40\"}",
            101 => "{\"award_id\":9,\"user_id\":191801906641,\"create_time\":\"2015-06-14 10:37:36\"}",
            102 => "{\"award_id\":2,\"user_id\":191801570187,\"create_time\":\"2015-06-14 10:13:54\"}",
            103 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-14 10:12:17\"}",
            104 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-14 08:30:52\"}",
            105 => "{\"award_id\":3,\"user_id\":191801893455,\"create_time\":\"2015-06-13 22:37:11\"}",
            106 => "{\"award_id\":2,\"user_id\":191800191041,\"create_time\":\"2015-06-13 22:16:37\"}",
            107 => "{\"award_id\":2,\"user_id\":191800104589,\"create_time\":\"2015-06-13 21:29:59\"}",
            108 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-13 19:58:47\"}",
            109 => "{\"award_id\":3,\"user_id\":191801424988,\"create_time\":\"2015-06-13 13:31:24\"}",
            110 => "{\"award_id\":3,\"user_id\":191801103380,\"create_time\":\"2015-06-13 09:16:46\"}",
            111 => "{\"award_id\":2,\"user_id\":191800698513,\"create_time\":\"2015-06-13 00:06:39\"}",
            112 => "{\"award_id\":9,\"user_id\":191801878435,\"create_time\":\"2015-06-12 22:44:18\"}",
            113 => "{\"award_id\":2,\"user_id\":191800524602,\"create_time\":\"2015-06-12 19:38:21\"}",
            114 => "{\"award_id\":3,\"user_id\":191800073915,\"create_time\":\"2015-06-12 19:06:40\"}",
            115 => "{\"award_id\":2,\"user_id\":191800073915,\"create_time\":\"2015-06-12 19:05:02\"}",
            116 => "{\"award_id\":9,\"user_id\":191801891316,\"create_time\":\"2015-06-12 16:48:36\"}",
            117 => "{\"award_id\":2,\"user_id\":191801696922,\"create_time\":\"2015-06-12 15:02:32\"}",
            118 => "{\"award_id\":2,\"user_id\":191801305795,\"create_time\":\"2015-06-12 12:18:11\"}",
            119 => "{\"award_id\":2,\"user_id\":191800170281,\"create_time\":\"2015-06-12 11:34:01\"}",
            120 => "{\"award_id\":3,\"user_id\":191801570187,\"create_time\":\"2015-06-12 01:59:39\"}",
            121 => "{\"award_id\":2,\"user_id\":191801554748,\"create_time\":\"2015-06-11 22:46:46\"}",
            122 => "{\"award_id\":2,\"user_id\":191800095511,\"create_time\":\"2015-06-11 19:15:02\"}",
            123 => "{\"award_id\":2,\"user_id\":191801094457,\"create_time\":\"2015-06-11 17:25:25\"}",
            124 => "{\"award_id\":3,\"user_id\":191801094457,\"create_time\":\"2015-06-11 15:19:28\"}",
            125 => "{\"award_id\":2,\"user_id\":191801094457,\"create_time\":\"2015-06-11 12:30:52\"}",
            126 => "{\"award_id\":2,\"user_id\":191800148385,\"create_time\":\"2015-06-11 00:14:00\"}",
            127 => "{\"award_id\":3,\"user_id\":191800095511,\"create_time\":\"2015-06-10 23:44:39\"}",
            128 => "{\"award_id\":2,\"user_id\":191801067753,\"create_time\":\"2015-06-10 21:59:04\"}",
            129 => "{\"award_id\":2,\"user_id\":191801017957,\"create_time\":\"2015-06-10 19:46:17\"}",
            130 => "{\"award_id\":2,\"user_id\":191801658615,\"create_time\":\"2015-06-10 19:30:23\"}",
            131 => "{\"award_id\":2,\"user_id\":191801409001,\"create_time\":\"2015-06-10 19:19:15\"}",
            132 => "{\"award_id\":2,\"user_id\":191800148385,\"create_time\":\"2015-06-10 15:11:09\"}",
            133 => "{\"award_id\":2,\"user_id\":191801017957,\"create_time\":\"2015-06-10 13:27:48\"}",
            134 => "{\"award_id\":2,\"user_id\":191801409001,\"create_time\":\"2015-06-10 13:20:49\"}",
            135 => "{\"award_id\":2,\"user_id\":191801580719,\"create_time\":\"2015-06-10 12:36:27\"}",
            136 => "{\"award_id\":2,\"user_id\":191800148385,\"create_time\":\"2015-06-10 11:56:27\"}",

        ];


        $prize = ['1' => ['desc' => '20元现金券', 'rand' => 56, 'amount' => 20, 'reset' => 3],
            '2' => ['desc' => '小米手环', 'rand' => 10, 'amount' => null, 'reset' => 2],
            '3' => ['desc' => '小米体重秤', 'rand' => 3, 'amount' => null, 'reset' => 5],
            '4' => ['desc' => '小米小蚁智能摄像机', 'rand' => 1, 'amount' => null, 'reset' => 4],
            '5' => ['desc' => 'apple watch sport38mm', 'rand' => 1, 'amount' => null, 'reset' => 1],
            '6' => ['desc' => '30积分', 'rand' => 532, 'amount' => 30, 'reset' => 3],
            '7' => ['desc' => '10元红包', 'rand' => 50, 'amount' => 10, 'reset' => 5],
            '8' => ['desc' => '5元现金券', 'rand' => 150, 'amount' => 5, 'reset' => 2],
            '9' => ['desc' => '小米随身wifi', 'rand' => 15, 'amount' => null, 'reset' => 4],
            '10' => ['desc' => '小米百变随身杯', 'rand' => 3, 'amount' => null, 'reset' => 1],
        ];
        $data = [];
        foreach ($submits as $k => $v) {
            $vl = (array)json_decode($v);
            $data[$k]['user_id'] = $vl['user_id'];
            $data[$k]['award_id'] = $vl['award_id'];
            $data[$k]['award_name'] = $prize[$vl['award_id']]['desc'];
            $data[$k]['create_time'] = $vl['create_time'];
            //echo $vl['user_id'].'   '. $vl['award_id'].'     ' . $prize[$vl['award_id']]['desc'] . '      ' .$vl['create_time'] ."    "."<br/>" ;
            //echo $vl['user_id']."<br/>";
//            echo $vl['award_id']."<br/>";
//            echo $prize[$vl['award_id']]['desc']."<br/>";
            echo $vl['create_time'] . "<br/>";

        }


        //var_dump($data);
        exit();

        $excel = new PHPExcel();
        $excel->getActiveSheet()->setCellValue('A1', 'user_id');
        $excel->getActiveSheet()->setCellValue('B1', 'award_id');
        $excel->getActiveSheet()->setCellValue('C1', 'award_name');
        $excel->getActiveSheet()->setCellValue('D1', 'create_time');


        $outputFileName = "推荐活动实物中奖查询导出后文件.xls";
        if ($data) {
            $i = 2;
            foreach ($data as $key => $value) {
                $excel->getActiveSheet()->setCellValue('A' . $i, $value['user_id']);
                $excel->getActiveSheet()->setCellValue('B' . $i, $value['award_id']);
                $excel->getActiveSheet()->setCellValue('C' . $i, $value['award_name']);
                $excel->getActiveSheet()->setCellValue('D' . $i, $value['create_time']);
                $i++;
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type: application/vnd.ms-excel;");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=" . $outputFileName);
        header("Content-Transfer-Encoding:binary");
        $objWriter->save("php://output");
        var_dump($data);
    }

    public function actionDragonBoat()
    {
        $bless = [
            1 => '爸，父亲节快乐，多注意身体！感谢您的养育之恩，您辛苦了！',
            2 => '也许我总令您操心，惹您生气，但在今天-在父亲节来临之际，让我对您说：爸爸，其实我很爱您！',
            3 => '爸爸，您对我的教诲是我无尽的财富，谢谢您！父亲节来临之际，祝您节日快乐！',
            4 => '老爸，父亲节快乐！虽然我没能在您身边，也希望您能快快乐乐度过每一分每一秒。我爱您！'
        ];

        $dragonboat = [
             1=>"{\"name\":\"\\u95eb\\u6eaa\",\"gender\":\"\\u7537\",\"mobile\":\"13699175751\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
             2=>"{\"name\":\"\\u848b\\u5c0f\\u84c9\",\"gender\":\"\\u5973\",\"mobile\":\"13611303144\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
             3=>"{\"name\":\"\\u6587\\u6cbb\\u658c\",\"gender\":\"\\u7537\",\"mobile\":\"13907825458\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5357\\u4eac\"}",
             4=>"{\"name\":\"\\u9ec4\\u53cc\\u6c5f\",\"gender\":\"\\u7537\",\"mobile\":\"13751585515\",\"health\":\"\\u65e0\\u4e0d\\u826f\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
             5=>"{\"name\":\"\\u9648\\u4e91\",\"gender\":\"\\u5973\",\"mobile\":\"13852959019\",\"health\":\"\\u597d\",\"city\":\"\\u5357\\u4eac\"}",
             6=>"{\"name\":\"\\u53f6\\u5fc3\\u7bea\",\"gender\":\"\\u5973\",\"mobile\":\"13913816305\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5357\\u4eac\"}",
             7=>"{\"name\":\"\\u738b\\u857e\",\"gender\":\"\\u5973\",\"mobile\":\"15076206636\",\"health\":\"\\u8fd8\\u53ef\\u4ee5\",\"city\":\"\\u5317\\u4eac\"}",
             8=>"{\"name\":\"\\u6731\\u658c\",\"gender\":\"\\u7537\",\"mobile\":\"18251537285\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5357\\u4eac\"}",
             9=>"{\"name\":\"\\u5b8b\\u5143\\u8f89\",\"gender\":\"\\u7537\",\"mobile\":\"13813977275\",\"health\":\"\\u5065\\u5eb7\\uff0c\\u5929\\u5929\\u9a91\\u8f66\",\"city\":\"\\u5357\\u4eac\"}",
            10=>"{\"name\":\"\\u9648\\u6797\",\"gender\":\"\\u5973\",\"mobile\":\"18951820810\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5357\\u4eac\"}",
            11=>"{\"name\":\"\\u97e9\\u767b\\u5b9d\",\"gender\":\"\\u7537\",\"mobile\":\"15201610328\",\"health\":\"\\u975e\\u5e38\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            12=>"{\"name\":\"\\u6587\\u71d5\\u59ae\",\"gender\":\"\\u5973\",\"mobile\":\"15201617081\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            13=>"{\"name\":\"\\u94b1\\u8363\\u8212\",\"gender\":\"\\u5973\",\"mobile\":\"15117097285\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            14=>"{\"name\":\"\\u8881\\u91ce\",\"gender\":\"\\u7537\",\"mobile\":\"13911574172\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            15=>"{\"name\":\"\\u738b\\u6cf0\",\"gender\":\"\\u7537\",\"mobile\":\"13611292491\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            16=>"{\"name\":\"\\u4f55\\u5fb7\\u91d1\",\"gender\":\"\\u7537\",\"mobile\":\"13527883548\",\"health\":\"\\u975e\\u5e38\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            17=>"{\"name\":\"\\u5f20\\u9e4f\",\"gender\":\"\\u7537\",\"mobile\":\"18001053914\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            18=>"{\"name\":\"\\u5218\\u6cc9\\u6e05\",\"gender\":\"\\u7537\",\"mobile\":\"13537593348\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            19=>"{\"name\":\"\\u5218\\u4f1f\\u4f1f\",\"gender\":\"\\u7537\",\"mobile\":\"13015502819\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            20=>"{\"name\":\"\\u4efb\\u6770\",\"gender\":\"\\u7537\",\"mobile\":\"18610195629\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            21=>"{\"name\":\"\\u5b59\\u5a1f\",\"gender\":\"\\u5973\",\"mobile\":\"13466707086\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            22=>"{\"name\":\"\\u7530\\u6000\\u5efa\",\"gender\":\"\\u7537\",\"mobile\":\"15210061290\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            23=>"{\"name\":\"\\u9ad8\\u6c38\\u6587\",\"gender\":\"\\u7537\",\"mobile\":\"18009359912\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            24=>"{\"name\":\"\\u674e\\u5f6d\",\"gender\":\"\\u7537\",\"mobile\":\"15962739845\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            25=>"{\"name\":\"\\u674e\\u536b\\u6218\",\"gender\":\"\\u7537\",\"mobile\":\"13965858619\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            26=>"{\"name\":\"\\u80e1\\u4e9a\\u9f99\",\"gender\":\"\\u7537\",\"mobile\":\"13965747361\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            27=>"{\"name\":\"\\u82cf\\u6770\",\"gender\":\"\\u7537\",\"mobile\":\"15135549236\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            28=>"{\"name\":\"\\u6768\\u5b89\",\"gender\":\"\\u7537\",\"mobile\":\"15903227422\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            29=>"{\"name\":\"\\u5d14\\u5723\\u8273\",\"gender\":\"\\u5973\",\"mobile\":\"18053426509\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            30=>"{\"name\":\"\\u738b\\u4f1f\\u660e\",\"gender\":\"\\u7537\",\"mobile\":\"15210043653\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            31=>"{\"name\":\"\\u51af\\u70ab\\u6995\",\"gender\":\"\\u7537\",\"mobile\":\"18071236372\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            32=>"{\"name\":\"\\u674e\\u9759\\u4eea\",\"gender\":\"\\u5973\",\"mobile\":\"13724680260\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            33=>"{\"name\":\"\\u53f6\\u4e3d\\u840d\",\"gender\":\"\\u5973\",\"mobile\":\"13827930103\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            34=>"{\"name\":\"\\u738b\\u7389\\u82b3\",\"gender\":\"\\u5973\",\"mobile\":\"13685340857\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            35=>"{\"name\":\"\\u738b\\u5229\\u6c11\",\"gender\":\"\\u7537\",\"mobile\":\"18680853805\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            36=>"{\"name\":\"\\u5f20\\u7545\",\"gender\":\"\\u7537\",\"mobile\":\"18857498693\",\"health\":\"\\u975e\\u5e38\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            37=>"{\"name\":\"\\u6c60\\u670b\\u521a\",\"gender\":\"\\u7537\",\"mobile\":\"18799722535\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            38=>"{\"name\":\"\\u8d75\\u4e60\\u5b8f\",\"gender\":\"\\u7537\",\"mobile\":\"18610660093\",\"health\":\"\\u5efa\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            39=>"{\"name\":\"\\u738b\\u715c\\u709c\",\"gender\":\"\\u7537\",\"mobile\":\"13718739639\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            40=>"{\"name\":\"\\u674e\\u6587\\u6d9b\",\"gender\":\"\\u7537\",\"mobile\":\"15275123023\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            41=>"{\"name\":\"\\u73ed\\u7ae0\",\"gender\":\"\\u7537\",\"mobile\":\"15948309661\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            42=>"{\"name\":\"\\u6768\\u6d9b\",\"gender\":\"\\u7537\",\"mobile\":\"18600033529\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            43=>"{\"name\":\"\\u97e9\\u9510\",\"gender\":\"\\u7537\",\"mobile\":\"13651186832\",\"health\":\"\\u826f\",\"city\":\"\\u5317\\u4eac\"}",
            44=>"{\"name\":\"\\u5f20\\u7ea2\\u7965\",\"gender\":\"\\u7537\",\"mobile\":\"13914567845\",\"health\":\"\\u8eab\\u4f53\\u5065\\u5eb7\\uff0c\\u4e00\\u76f4\\u7231\\u597d\\u5355\\u8f66\\u9a91\\u884c\",\"city\":\"\\u5317\\u4eac\"}",
            45=>"{\"name\":\"\\u59ec\\u84c9\",\"gender\":\"\\u5973\",\"mobile\":\"18311378237\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            46=>"{\"name\":\"\\u8c22\\u4f1f\\u4f1f\",\"gender\":\"\\u5973\",\"mobile\":\"15120077426\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            47=>"{\"name\":\"\\u5289\\u8f1d\",\"gender\":\"\\u7537\",\"mobile\":\"13841909610\",\"health\":\"\\u7279\\u5225\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            48=>"{\"name\":\"\\u5468\\u6c99\\u6c99\",\"gender\":\"\\u5973\",\"mobile\":\"18368060622\",\"health\":\"\\u8d2b\\u8840\\uff0c165\\u5398\\u7c73\\uff0c93\\u65a4\\uff0c\\u4f46\\u662f\\u8eab\\u4f53\\u7d20\\u8d28\\u4e0d\",\"city\":\"\\u5317\\u4eac\"}",
            49=>"{\"name\":\"\\u5f20\\u8d85\",\"gender\":\"\\u7537\",\"mobile\":\"13735533173\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            50=>"{\"name\":\"\\u6c6a\\u540d\\u7acb\",\"gender\":\"\\u7537\",\"mobile\":\"13810571416\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            51=>"{\"name\":\"\\u9ec4\\u5029\\u5029\",\"gender\":\"\\u7537\",\"mobile\":\"13521877387\",\"health\":\"\\u826f\\u597d\\uff08\\u62a5\\u540d\\u6d4b\\u8bd5\\uff0c\\u8bf7\\u52ff\\u8ba9\\u6211\\u53c2\\u52a0\\uff09\",\"city\":\"\\u5317\\u4eac\"}",
            52=>"{\"name\":\"\\u590f\\u660c\\u9f99\",\"gender\":\"\\u7537\",\"mobile\":\"18783197914\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            53=>"{\"name\":\"\\u7f57\\u4e66\\u6c5f\",\"gender\":\"\\u7537\",\"mobile\":\"18784991454\",\"health\":\"165\",\"city\":\"\\u5317\\u4eac\"}",
            54=>"{\"name\":\"\\u5f20\\u96ea\\u6885\",\"gender\":\"\\u5973\",\"mobile\":\"15161319221\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            55=>"{\"name\":\"\\u90b9\\u5c0f\\u59d0\",\"gender\":\"\\u5973\",\"mobile\":\"13713890742\",\"health\":\"\\u6211\\u8981\\u62a5\\u540d\\u6df1\\u5733\\u7ad9\\u7684\\u6d3b\\u52a8\\uff0c\\u4f60\\u4eec\\u6ca1\\u6709\\u6df1\\u5733\\u7b5b\\u9009\\u9879\",\"city\":\"\\u5317\\u4eac\"}",
            56=>"{\"name\":\"\\u95eb\\u82b3\",\"gender\":\"\\u5973\",\"mobile\":\"13716305510\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            57=>"{\"name\":\"\\u66fe\\u7167\\u4e3d\",\"gender\":\"\\u5973\",\"mobile\":\"13621307889\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            58=>"{\"name\":\"\\u8d75\\u5a34\",\"gender\":\"\\u5973\",\"mobile\":\"15156690640\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            59=>"{\"name\":\"\\u67f4\\u6d69\\u68ee\",\"gender\":\"\\u7537\",\"mobile\":\"18614042116\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            60=>"{\"name\":\"\\u5355\\u946b\",\"gender\":\"\\u7537\",\"mobile\":\"18612251872\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            61=>"{\"name\":\"\\u8d75\\u6770\\u743c\",\"gender\":\"\\u5973\",\"mobile\":\"13312092176\",\"health\":\"\\u8eab\\u4f53\\u5065\\u5eb7\\u826f\\u597d\\uff0c\\u4e14\\u70ed\\u7231\\u8fd0\\u52a8\\uff01\",\"city\":\"\\u5317\\u4eac\"}",
            62=>"{\"name\":\"\\u8463\\u8587\",\"gender\":\"\\u5973\",\"mobile\":\"13426382317\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            63=>"{\"name\":\"\\u5f20\\u683c\",\"gender\":\"\\u5973\",\"mobile\":\"13923378120\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            64=>"{\"name\":\"\\u9ec4\\u6d69\",\"gender\":\"\\u7537\",\"mobile\":\"18623525731\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            65=>"{\"name\":\"\\u9648\\u8363\\u4f1f\",\"gender\":\"\\u7537\",\"mobile\":\"13906553555\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            66=>"{\"name\":\"\\u5218\\u8273\\u4e3d\",\"gender\":\"\\u5973\",\"mobile\":\"18811313711\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            67=>"{\"name\":\"\\u5434\\u660e\\u534e\",\"gender\":\"\\u5973\",\"mobile\":\"18610897191\",\"health\":\"\\u4e9a\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            68=>"{\"name\":\"\\u8c2d\\u767b\\u5148\",\"gender\":\"\\u7537\",\"mobile\":\"18666719993\",\"health\":\"\\u826f\",\"city\":\"\\u5317\\u4eac\"}",
            69=>"{\"name\":\"\\u6556\\u8ba1\\u73cd\",\"gender\":\"\\u5973\",\"mobile\":\"15600033360\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            70=>"{\"name\":\"\\u674e\\u7433\",\"gender\":\"\\u5973\",\"mobile\":\"13651214244\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            71=>"{\"name\":\"\\u5f20\\u91ca\\u4e49\",\"gender\":\"\\u7537\",\"mobile\":\"15650708680\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            72=>"{\"name\":\"\\u738b\\u6c38\\u9e4f\",\"gender\":\"\\u7537\",\"mobile\":\"15001125728\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            73=>"{\"name\":\"\\u5f20\\u6653\\u82ac\",\"gender\":\"\\u5973\",\"mobile\":\"18736034997\",\"health\":\"\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            74=>"{\"name\":\"\\u5f20\\u65b0\\u96e8\",\"gender\":\"\\u5973\",\"mobile\":\"13581580271\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            75=>"{\"name\":\"\\u82d7\\u5b8f\\u535a\",\"gender\":\"\\u7537\",\"mobile\":\"18618293669\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            76=>"{\"name\":\"\\u6842\\u5f6c\",\"gender\":\"\\u5973\",\"mobile\":\"18515055054\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            77=>"{\"name\":\"\\u5218\\u901a\",\"gender\":\"\\u7537\",\"mobile\":\"15600009301\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            78=>"{\"name\":\"\\u738b\\u5229\",\"gender\":\"\\u7537\",\"mobile\":\"18053764348\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            79=>"{\"name\":\"\\u848b\\u5fb7\\u7965\",\"gender\":\"\\u7537\",\"mobile\":\"18614048386\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            80=>"{\"name\":\"\\u53f2\\u5b87\\u6668\",\"gender\":\"\\u7537\",\"mobile\":\"13613666392\",\"health\":\"\\u5f88\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            81=>"{\"name\":\"\\u6881\\u6653\\u534e\",\"gender\":\"\\u7537\",\"mobile\":\"18600575362\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            82=>"{\"name\":\"\\u9648\\u667a\\u80dc\",\"gender\":\"\\u7537\",\"mobile\":\"18606517059\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            83=>"{\"name\":\"\\u66f9\\u5927\\u57ce\",\"gender\":\"\\u7537\",\"mobile\":\"15550771066\",\"health\":\"\\u975e\\u5e38\\u5065\\u5eb7\\uff0c\\u9a91\\u884c5\\u5e74\\uff0c\",\"city\":\"\\u5317\\u4eac\"}",
            84=>"{\"name\":\"\\u9ec4\\u51e4\\u829d\",\"gender\":\"\\u5973\",\"mobile\":\"18756195916\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            85=>"{\"name\":\"\\u4e25\\u6d77\\u94a2\",\"gender\":\"\\u7537\",\"mobile\":\"13361861323\",\"health\":\"\\u5065\\u5eb7\",\"city\":\"\\u5317\\u4eac\"}",
            86=>"{\"name\":\"\\u674e\\u5fd7\\u5f3a\",\"gender\":\"\\u7537\",\"mobile\":\"13513595020\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            87=>"{\"name\":\"\\u674e\\u8fd0\\u534e\",\"gender\":\"\\u7537\",\"mobile\":\"15101135290\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            88=>"{\"name\":\"\\u5b54\\u7d20\\u73cd\",\"gender\":\"\\u5973\",\"mobile\":\"13522624742\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            89=>"{\"name\":\"\\u674e\\u7aef\\u9633\",\"gender\":\"\\u7537\",\"mobile\":\"15201433798\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            90=>"{\"name\":\"\\u5f20\\u5fd7\\u5f3a\",\"gender\":\"\\u7537\",\"mobile\":\"13784564731\",\"health\":\"\\u826f\\u597d\",\"city\":\"\\u5317\\u4eac\"}",
            91=>"{\"name\":\"\\u6d4b\\u8bd5\\u6570\\u636e\",\"gender\":\"\\u5973\",\"mobile\":\"18611111111\",\"health\":\"\\u4e0d\\u9519\",\"city\":\"\\u5317\\u4eac\"}",
            92=>"{\"name\":\"\\u6d4b\\u8bd5\\u6570\\u636e\",\"gender\":\"\\u7537\",\"mobile\":\"18645222221\",\"health\":\"\\u4e0d\\u9519\",\"city\":\"\\u5317\\u4eac\"}",

        ];


        $data = [];
        foreach ($dragonboat as $k => $v) {
            $vl = (array)json_decode($v);
            $data[$k]['name'] = $vl['name'];
            $data[$k]['gender'] = $vl['gender'];
            $data[$k]['mobile'] = $vl['mobile'];
            $data[$k]['health'] = $vl['health'];
            $data[$k]['city'] = $bless[$vl['city']];
//             echo $vl['name'].'   '. $vl['gender'].'     ' . $vl['mobile'] .'   ' .$vl['health'].'  '.$vl['city'].'    ' ."<br/>" ;
//            echo $vl['name']."<br/>";
//            echo $vl['gender']."<br/>";
//            echo $vl['mobile'] ."<br/>";
//            echo $vl['health']."<br/>";
            echo $vl['city']."<br/>";
//            echo $vl['create_time'] . "<br/>";

        }
    }
}