<?php
session_start();
require("config.php");
//unset($_SESSION['entered']);
connectToDb();
$status="";
    $name="";
    $failLogin="";
//-------------1.若有cookie用cookie來確認帳密及登入
    if(isset($_COOKIE['info']["username"])){
        if(isset($_COOKIE['info']['password'])){
            $username=$_COOKIE['info']["username"];
            $password=$_COOKIE['info']['password'];
            if (loginToDb($username,$password)==true) {
                
                $getName=mysql_query("SELECT name From memberInfo where username ='$username'");
                $name = mysql_fetch_row($getName);
                $status="hasLogin";
            }
        }
    }
    else{
// -----------------2.cookie原本沒資料,輸入帳密登入成功,並設置cookie
        if(isset($_POST["btnLogin"])){
            $username = $_POST['username'];
            $passwordFormer = $_POST['password'];
            $password=md5($passwordFormer);
            if (loginToDb($username,$password)==true) {
                $getName=mysql_query("SELECT name From memberInfo where username ='$username'");
                $name = mysql_fetch_row($getName);
                if($_POST["rememberMe"]){
                if(trim($username!="")){
                    setcookie("info[username]", "$username",time()+60*60*24*30);
                    setcookie("info[password]", "$password",time()+60*60*24*30);
                }
            }
            $status="hasLogin";
            }
            else {
                $failLogin="1";   
            }
        }
    }

//------如果按了logout
if(isset($_POST["btnLogout"])){
    setcookie("info[username]", "Guest",time() - 3600);
    setcookie("info[password]", "",time() - 3600);
    unset($_SESSION['entered']);
    $status="";
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/main_Ellie.css">
        <link rel="stylesheet" href="css/responsive_Ellie.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script>
        
        setTimeout(countDown,1000);
        function countDown(){
        var current=new Date();
        var currentmilliSecond=current.getTime();
        var currentSecond=Math.floor((currentmilliSecond+28800000)/1000);
        var secondFromMidNight = currentSecond % 86400;
        var X=38400-secondFromMidNight;
        var Hour=Math.floor(X/3600);
        var Y=X%3600;
        var min=Math.floor(Y/60);
        var sec=Y%60;
        if(sec<0){
            document.getElementById('countDownTimer').style.visibility="hidden";
        }
        document.getElementById('countDownTimer').innerHTML=Hour+":"+min+":"+sec;
        setTimeout(countDown,1000);
        }
        </script>
	    </head>
    <body>
<!-- -----------------------------------------------------------標題-------------------------------------------------------------------- -->
        <div class="header">
                <h1 align="center"><b style="color:red">B</b><b style="color:#FFA500">e</b><b style="color:#0000CD">n</b>
                <b style="color:#2E8B57">D</b><b style="color:	#87CEEB">o</b><b style="color:#FF69B4">n</b></h1>
        </div>
        <div class="body-content">
                <div class="two-columns clearfix">
                    <div class="main mobile-collapse">
<!-- --------------------------------------------------包在body-content的側邊巡覽列------------------------------------------------------ -->
                        <div class="nav">
                            <ul class="clearfix">
                                <li><a style="background-color:	#87CEFA"href="#">home</a></li>
                                <li><a style="background-color:	#FFA500"href="searchHistory.php">Order Record</a></li>
                                <li><a style="background-color:	#8FBC8F"href="vendorRecommend.php">Menu</a></li>
                                <li><a style="background-color:	#DDA0DD"href="bulletins-1.php">Bulletin</a></li>
                            </ul>
                        </div>
                        <div class="one-helf-l mobile-collapse">
                           <div id="photoBendon">
 <!-- ---------------------------------------------------------------相片輪播區--------------------------------------------------------- -->
                              <div id="myCarousel" class="carousel slide" data-ride="carousel">
 
                                  <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                    <li data-target="#myCarousel" data-slide-to="3"></li>
                                  </ol>
                         <!-- --------------------------------相片輪播來源------------------------ -->
                                  <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                      <img src="./image/bendon_1.jpg" alt="Chania">
                                      <div class="carousel-caption">
                                        <p font-type:>捧著鐵餐盒搭火車,讓您彷彿坐上時光機回到60的純樸年代...</p>
                                      </div>
                                    </div>
                                    <div class="item">
                                      <img src="./image/bendon_2.jpg">
                                      <div class="carousel-caption">
                                         <p font-type:>...</p>
                                      </div>
                                    </div>
                                    <div class="item">
                                      <img src="./image/bendon_3.jpg">
                                    </div>
                                  </div>
                         <!-- ------------------  --------------左右控制------------------------------ -->
                                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>
                           </div>  
                        </div>
                            <div class="one-helf-r mobile-collapse">
 <!-- ---------------------------------------------------------------每日時間--------------------------------------------------------- -->
                                <div id="timer">
                                    <?php date_default_timezone_set('Asia/Taipei');
                                          echo date("Y-m-d l");?>
                                <br>
                                </div>
                                <div id="countDownTimer">
                                </div>
 <!-- ---------------------------------------------------------------每日菜單--------------------------------------------------------- -->
                                <div id="questionnaire">
                                    <?php 
                                    $date=dateToday();
                                    $result=mysql_query("SELECT vendor FROM dailyRecord Where date='$date'");
                                    if( mysql_num_rows($result) < 1){
                                        $vendorCount=mysql_query("SELECT COUNT(vendor) FROM vendor WHERE vendor IS NOT NULL");
                                        $row=mysql_fetch_row($vendorCount);
                                        $vendorNumber=$row[0];
                                        $todayVendorNumber=rand("1",$vendorNumber);
                                        $result=mysql_query("SELECT vendor FROM vendor WHERE v_ID='$todayVendorNumber'");
                                        $row=mysql_fetch_row($result);
                                        $todayVendor=$row[0];
                                        $writeInRecord=mysql_query("INSERT INTO dailyRecord(date,vendor,menu,name,expenditure,deposit)VALUES
                                        ('$date','$todayVendor','0','0','0','0')");
                                    }
                                    else{
                                        $row=mysql_fetch_row($result);
                                        $todayVendor=$row[0];
                                    }
                                    
                                    ?><?php
                                    //訂餐時間截止
                                    $hourRightNow=idate(H);
                                    $minRightNow=idate(i);
            // ------>------->------>---這裡改截止時間
                                    if($hourRightNow>10 && $minRightNow>40){
                                        echo"本日時間截止";
                                    }else{ ?>
                                    
                                    本日為<b><font color="blue"><?php echo $todayVendor;?></font></b>
                                    <form name="formB" method="post" action="orderBendon.php">
                                        <lengend>請選擇:</lengend><br>
                                        <?php 
                                        $result=mysql_query("SELECT menu,price FROM menu WHERE vendor='$todayVendor'");
                                        while($row=mysql_fetch_row($result)){ ?>
                                        &nbsp&nbsp<input type="radio" name="bendonTsai" value="<?php echo "$row[0],$row[1]" ;?>" >
                                        <?php echo "$row[0]  $row[1]";?>元<br>   
                                        <?php };?>
                                        <input type="submit" name="btnOrder" value="確定">
                                        <?php };?>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                        <div class="side hide-mobile">
 <!-- ---------------------------------------------------------------會員登入區--------------------------------------------------------- -->
                            <form name="form" method="post" action="">
                                
                                <?php if ($failLogin == "1"): ?>
                                <font color="red">Fail to login. Pleae login again</font><br>
                                <?php endif; ?>
                                <?php if ($status == ""){ ?>
                                會員登入<br>
                                &nbsp Username:<br><input type="text" name="username" /><br>
                                &nbsp Password:<br><input type="password" name="password" /><br>
                                <input type="checkbox" name="rememberMe"/>記住我<br>
                                <input type="submit" name="btnLogin" value="login" />&nbsp;&nbsp;
                                <a href="register.php">register</a>
                                <?php } else{
                                if($_SESSION["username"]!="BendonManager"){
                                  $account=getMemberInfo('account');
                                  echo "Hello! $name[0] <br>您的帳戶餘額為
                                  <font color='red'><b>$account</b>元<br></font>
                                  <input type='submit' name='btnLogout' value='logout' />&nbsp;&nbsp;
                                  <a href='update.php'>Modify</a>"; 
                                }
                                else{
                                  $date=dateToday();
                                  $getBendonNumber=mysql_query("SELECT COUNT(name) FROM `dailyRecord` WHERE date='$date' and menu <>'0'");
                                  $bendonNumber=mysql_fetch_row($getBendonNumber);
                                  $bendonType=mysql_query("SELECT menu,COUNT(*) Amount FROM `dailyRecord`Where date='$date'and menu <>'0'GROUP BY menu ");
                                  $bendonTypeCount=mysql_num_fields($bendonType);
                                  echo "Hello!<br>今天要訂 <font color='red'>$bendonNumber[0]</font> 個便當喲";
                                  echo "<br><table id='order' border=3>";
                                  while($x=mysql_fetch_row($bendonType)){
                                    echo"<tr>";
                                    for($j=0;$j<$bendonTypeCount;$j++)
                                    
                                    echo "<td> $x[$j]</td>";
                                  }
                                  echo"</tr></table>";
                                  $getVendorInfo=mysql_query("SELECT phone from vendor where vendor='$todayVendor'");
                                  $vendorInfo=mysql_fetch_row($getVendorInfo);
                                  echo $todayVendor."<br>";
                                  echo "電話: $vendorInfo[0]";
                                  
                                  echo "<br><input type='submit' name='btnLogout' value='logout' />";
                                }   
                                } 
                                ?>
                            </form>
                        </div>
                    </div>
            </div>
 <!-- ---------------------------------------------------------------腳區--------------------------------------------------------- -->
            <div class="footer">
                <div class="footerImage"></div>
            </div>
        </div>
    </body>
</html>