  <?php 
 header("Content-type:text/html;charset=utf-8");

    // 模拟提交数据函数
    function postCurl($url,$data){
        $curl= curl_init();  // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
       // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
       // 对认证证书来源的检查
       // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 1); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作

        curl_close($curl);
        list($header, $body) = explode("\r\n\r\n", $tmpInfo);  
        $str = $header;  
        preg_match_all('/Set-Cookie:(.*?);/',$str,$cookie); //正则匹配  
        $str_cookie=implode(';', $cookie[1]);
        return $str_cookie;

    }

  //模拟登录
  function login_post($url, $cookie, $post) {
  	$curl = curl_init();//初始化curl模块
  	curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址

    curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

  	//curl_setopt($curl, CURLOPT_HEADER, 0);//是否显示头信息
  	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);//是否自动显示返回的信息
  	curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中
  	curl_setopt($curl, CURLOPT_POST, 1);//post方式提交
  	curl_setopt($curl, CURLOPT_POSTFIELDS, $post);//要提交的信息
  	$result = curl_exec($curl);//执行cURL

  	curl_close($curl);//关闭cURL资源，并且释放系统资源
    return $result;
  }
  //登录成功后获取数据
  function get_content($url, $cookie=null,$data=null) {

  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HEADER, 0 ); // 过滤HTTP头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

    if (!empty($data)){
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); //读取cookie
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  	$result = curl_exec($ch); //执行cURL抓取页面内容

    $result=mb_convert_encoding($result,'UTF-8','gbk');

        $result=explode("\n",$result);
        array_shift($result);
        array_pop($result);
  	curl_close($ch);
  	return $result;
  }
  //设置post的数据
 //
  function http_request($url,$cookie,$data = null){
  	$curl = curl_init();
  	curl_setopt($curl, CURLOPT_URL, $url);
  	curl_setopt($curl, CURLVERIFYPEER, FALSE);
  	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
  	if (!empty($data)){
  		curl_setopt($curl, CURLOPT_POST, 1);
  		//curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  	}
  	//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie); //读取cookie
   // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  	//curl_setopt($curl,CURLOPT_COOKIE,$cookie.';');
  	$output = curl_exec($curl);
/*    $result=explode("\n",$output);
        array_shift($result);
        array_pop($result);
  
  	curl_close($curl);*/

  	return $output;
  }

         // 模拟提交数据函数
       // 模拟提交数据函数
    function getCurl($url, $cookie,$data=null){
        $ch =curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER,false);
        curl_setopt($ch,CURLOPT_COOKIE,$cookie.';');
        if (!empty($data)){
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
           curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
         // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        $curl_info= curl_getinfo($ch);

        if(curl_errno($ch)){
            return 'curl_error:'.$curl_error($ch); 
        }
        return $result;
        $result=mb_convert_encoding($result,'UTF-8','gbk');
        $result=explode("\n",$result);
        array_shift($result);
        array_pop($result);
        return $result;
    }
    /***************login********************/
       //模拟登录
    $url = "http://dm.hsuncloud.com/login/doLogin.htm";
     $data ="phone=15885074721&password=123456jw";

       $cookie = postCurl($url, $data); 


$cookie = '_wcf_="/3NrnOEKjiR/6l75FIL51MgfHEHlR1L1hHgPmHnp8wDJnlYSzuVdq2W0xEeFhY5xk6S9zEFSh155wuve4Ze83W5ss6Lj0vZa5xA4w+nRM78HhEa5pfsZZAhD+pTqPbkYfS2+Sk7m4TSAeARXZQ/8ndk8fr/nkzHRzHvyxd3M2gQ="; ila="+G4Lv/gtmD0="; i="aTxtLyiQ/R8="; _wcfl_=0CpYiIjYHUxCXwoV9pB7NWu8gnvvOmD4; _ct_="kUfElRFSsJ/MVvHJndMQfQ=="; _ccode_=VYEJZX';

    /***************test code********************/
   //选择海事
      // $data0 = "cid=40000018918";
      // $url0 = "http://dm.hsuncloud.com/user/doSelect.htm";
      // $result = getCurl($url0, $cookie,$data0);
        //
     //  $urlc =  "http://dm.hsuncloud.com/admin/index.htm#/dayRecordList";
      //  $result = getCurl($urlc, $cookie);

        $urld = "http://dm.hsuncloud.com/admin/report/reportDetailData.htm";
       $datad  = "eids=1&eids=2&eids=3&eids=4&eids=5&sort=dep&startDate=2017-12-01&endDate=2017-12-31";
        $result = getCurl($urld, $cookie,$datad);
        $arr_data = json_decode($result);
    print_r($arr_data);
       /***************old version********************/
      //设置cookie保存路径 
 /*       $url = "http://www.hsuncloud.com/Account/LogOn";
        $data ="MobileNumber=18200163564&Password=sqsqsq123";
        $cookie = postCurl($url,$data); 


        $startime = '2018-01-01';
         $endtime = '2018-01-31';
        $url2 = "http://www.hsuncloud.com/AttendanceManage/AttRecord?Keyword=&DepartmentID=&startdate=".$startime."&enddate=".$endtime;
       getCurl($url2, $cookie);
        $url3 = "http://www.hsuncloud.com/AttendanceManage/AttRecord/Export?Keyword=&DepartmentID=&startdate=".$startime."&enddate=".$endtime;
        
      
        $result = getCurl($url3, $cookie);
        print_r($result);

        @ unlink($cookie);   
        exit;*/

    /***************new version********************/

/*  $post = array (
  		'phone' => '15885074721',
  		'password' => '123456jw',
    );*/

  //);
  //$data1 = "eids=1&sort=dep&startDate=2018-05-01&endDate=2018-05-31";

  //登录地址 
  //设置cookie保存路径 
 // $cookie = dirname(__FILE__) . '/cookie_oschina.txt'; 
	
  //登录后要获取信息的地址
   //$url2 = "http://dm.hsuncloud.com/admin/company/companyInfo.htm"; 


    //跳转到海事
    $url1 = "http://dm.hsuncloud.com/launchpad.htm";
    $result = getCurl($url1, $cookie);

   //选择海事
       $data0 = "cid=40000018918";
       $url0 = "http://dm.hsuncloud.com/user/doSelect.htm";
       
      

     $url7 = "http://dm.hsuncloud.com/admin/index.htm#/report";
     

      $url8  ='http://dm.hsuncloud.com/admin/report/reportDetailData.htm';
      $data8  ="eids=1&eids=2&eids=3&eids=4&eids=5&sort=dep&startDate=2018-05-01&endDate=2018-05-31";
      


      $url9 = "http://dm.hsuncloud.com/admin/report/reportDetailDataDownload.htm";
      $data9 = "startDate=2018-05-01&endDate=2018-05-31&sort=dep&eids=1&eids=2&eids=3&eids=4&eids=5&eids=6&eids=7&eids=8&eids=9&eids=10&eids=11&eids=12&eids=13&eids=14&eids=15&eids=16&eids=17&eids=18&eids=19&eids=20&eids=21&eids=22&eids=23&eids=24&eids=25&eids=26&eids=27&eids=28&eids=29&eids=30&eids=31&eids=32&eids=33&eids=34&eids=35&eids=36&eids=37&eids=38&eids=39&eids=40&eids=41&filterAttend=true&showLeave=true";

      $url6 = "http://dm.hsuncloud.com/admin/report/reportTaskProgress.htm";
      $data6 = "key=report-40000018918-1";


      $result = getCurl($url0, $cookie,$data0);
   
      $result = getCurl($url7, $cookie);
      $result = getCurl($url8, $cookie,$data8);
      $result = getCurl($url9, $cookie,$data9);
      $result = getCurl($url6, $cookie,$data6);
      print_r($result);
      exit;
  /*       $data8 = array(
              'eids'=>1,
              'eids'=>2,
              'eids'=>3,
              'eids'=>4,
              'eids'=>5,
              'eids'=>6,
              'startDate'=>'2017-01-01',
             'endDate'=>'2017-01-31'
         );*/

      //$url1 = "http://dm.hsuncloud.com/admin/contacts/contacts.htm?dataMode=all";
       // $result = get_content($url8, $cookie,$data8);
       //  print_r($result);
        //$result2 = get_content($url1, $cookie);
       // $result = get_content($url3, $cookie);
    /*    $url9 = "http://dm.hsuncloud.com/admin/report/reportDetailDataDownload.htm";
       
        $data9 = array(

          'showLeave'=>true,
          'filterAttend'=>true,
          'sort'=>'dep',
          'startDate'=>'2018-05-01',
          'endDate'=>'2018-05-31'
     );
    $result = get_content($url9, $cookie,$data9);
    print_r($result);

     $url6 = "http://dm.hsuncloud.com/admin/report/reportTaskProgress.htm";
      $key = array(
        'key'=>'report-40000018918-1'
      );

      $result = get_content($url6, $cookie ,$key);
     print_r($result);
     exit;

       $url5 = "http://dm.hsuncloud.com/admin/permissionData.htm";
      $e = http_request($url5, $cookie);


      $url7 = "http://dm.hsuncloud.com/admin/contacts/contacts.htm?dataMode=all";
       $e = http_request($url7, $cookie);
       print_r($e);
       exit();

    $url1 = "http://dm.hsuncloud.com/admin/privilegeData.htm";
    $data1 = array(
          "privilegesJson"=>["ATTENDANCE_REPORT_READ","ATTENDANCE_REPORT_DOWNLOAD"],
          "hasEmp"=>true,
          "convert"=>true
    );
      $result = http_request($url1, $cookie,$data1);

      $url2="http://dm.hsuncloud.com/admin/attendance/getDefaultManageEids.htm";
          $data2 = array(
          "privilegeJson"=>"ATTENDANCE_REPORT_READ",
          "filterAttend"=>true,
          "showLeave"=>true
    );

      $result = get_content($url2, $cookie,$data2);
   

    $url3="http://dm.hsuncloud.com/admin/attendance/arShowConfig.htm";
    $result = get_content($url3, $cookie);
  //获取登录页的信息
         //$startime = '2018-05-5';
        // $endtime = '2018-05-18';
       // $url2 = "http://www.hsuncloud.com/AttendanceManage/AttRecord?Keyword=&DepartmentID=&startdate=".$startime."&enddate=".$endtime;

       // $url3 = "http://www.hsuncloud.com/AttendanceManage/AttRecord/Export?Keyword=&DepartmentID=&startdate=".$startime."&enddate=".$endtime;

         //$url4 = "http://www.hsuncloud.com/AttendanceManage/AttDailyReport/ExportDailyList?&startdate=".$startime."&enddate=".$endtime;
        //选择海事


   //删除cookie文件

   @ unlink($cookie); */

      ?>