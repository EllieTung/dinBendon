<?php
session_start();
require("config.php");
connectToDb();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="css/main_Ellie.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="js/jquery.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    </head>
    <body>
        <div class="header">
                <h1 align="center"><b style="color:red">B</b><b style="color:#FFA500">e</b><b style="color:#0000CD">n</b>
                <b style="color:#2E8B57">D</b><b style="color:	#87CEEB">o</b><b style="color:#FF69B4">n</b></h1>
        </div>
        <div class="body-content">
            <div class="two-columns clearfix">
                <div class="main mobile-collapse">
                    <div class="nav">
                        <ul class="clearfix">
                            <li><a style="background-color:	#87CEFA"href="index.php">home</a></li>
                            <li><a style="background-color:	#FFA500"href="searchHistory.php">Order Record</a></li>
                            <li><a style="background-color:	#8FBC8F"href="vendorRecommend.php">Menu</a></li>
                            <li><a style="background-color:	#DDA0DD"href="bulletins-1.php">Bulletin</a></li>
                            <!-- need add something else --> 
                        </ul>
                    </div>
            <h3 align="center"><br>
            <?php
            if($_SESSION['entered']==false){
                echo "Please login first!<br>";
                echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
            }
            else{
                if(isset($_POST['btnOrder'])){
                    if(!isset($_POST["bendonTsai"])){
                        echo "please select BenDon<br>";
                        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
                    }
                    else{
                    $date = dateToday();
                    $name=getMemberInfo("name");
                    $piece=explode(",",$_POST["bendonTsai"]);
                    $menu=$piece[0];
                    $price=$piece[1];
                    $account=getMemberInfo("account");
                      if($account<$price){
                        echo"您的餘額不足，請至櫃檯充值";
                        }else{
                        $record=mysql_query("INSERT INTO dailyRecord(date,vendor,menu,name,expenditure,deposit) values
                                                  ('$date','0','$menu','$name','$price','0')");
                        $account=$account-$price;
                        mysql_query("UPDATE memberInfo SET account=$account WHERE name='$name'");
                        echo "Hi~".$name.",您今天訂了".$menu.",您的戶頭還有" .$account."元";}
                        }
                    }
                }
            ?>
            </h3></div>
          </div>
        </div>
        <div class="footer">
                <div class="footerImage"></div>
        </div>
    </body>
</html>