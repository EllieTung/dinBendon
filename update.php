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
        <link rel="stylesheet" href="css/responsive_Ellie.css">
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
                            <li><a style="background-color:	#DDA0DD"href="chatRoom.php">Chatroom</a></li>
                            <!-- need add something else --> 
                        </ul>
                    </div>
                    <div class="main">
                    <?php
                        $date = dateToday();
                        $name=getMemberInfo("name");
                        echo "<h4>Hi ! $name.</h4>";
                    ?>
                    
                    <form method="post" action="">
                        Want to change:<br>
                                       <label><input type="checkbox" id="password" value="password">Password&nbsp</label><br>
                                       <label><input type="checkbox" id="cellphone" value="cellphone">Cellphone</label><br>
                                       <label><input type="checkbox" id="birthday" value="birthday">Birthday</label><br>
                                       <label><input type="checkbox" id="email" value="email">Email&nbsp&nbsp&nbsp&nbsp</label><br>
                                       <label><input type="checkbox" id="class" value="class">Class&nbsp&nbsp&nbsp&nbsp</label>
                                       <input type="submit" name="btnModi" value="確認修改">
                                      
                    </form>
                    <script>
                    $("#password").change(function() {
                            if(this.checked) {
                                $("#password").replaceWith("<input type='text' name='password'autofocus='autofocus'>");
                            }
                        });
                        
                    $("#cellphone").change(function() {
                            if(this.checked) {
                                $("#cellphone").replaceWith("<input type='text' name='cellphone'autofocus='autofocus' pattern='09\d{8}'>");
                            }
                        });
                    $("#birthday").change(function() {
                            if(this.checked) {
                                $("#birthday").replaceWith("<input type='text' name='birthday'autofocus='autofocus'pattern='^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1\d|2\d|3[0-1]$'>");
                            }
                        });
                    $("#email").change(function() {
                            if(this.checked) {
                                $("#email").replaceWith("<input type='text' name='email'autofocus='autofocus' pattern='\w+([-.]\w+)*@\w+([-.]\w+)+'>");
                            }
                        });
                    $("#class").change(function() {
                            if(this.checked) {
                                $("#class").replaceWith("please contact XXXXX--");
                            }
                        });
                    </script>
                    </div>   
                        	
                    <?php
                    $date = dateToday();
                    $name=getMemberInfo("name");
                    if(!empty($_POST["password"])){
                    $pass=$_POST["password"];
                    $password=md5($pass);
                    $sql=mysql_query("UPDATE memberInfo SET password='$password' WHERE name='$name'");
                    if($sql){echo "<span>password changed!<br></span>";}
                    }
                    else{};
                    if(!empty($_POST["cellphone"])){
                    $cellphone=$_POST["cellphone"];
                    $sql=mysql_query("UPDATE memberInfo SET cellphone='$cellphone' WHERE name='$name'");
                    if($sql){echo "<span>cellphone changed!<br></span>";}
                    }
                    else{};
                    if(!empty($_POST["birthday"])){
                    $birthday=$_POST["birthday"];
                    $sql=mysql_query("UPDATE memberInfo SET birthday='$birthday' WHERE name='$name'");
                    if($sql){echo "<span>birthday changed!<br></span>";}
                    }
                    else{};
                    if(!empty($_POST["email"])){
                    $email=$_POST["email"];
                    $sql=mysql_query("UPDATE memberInfo SET email='$email' WHERE name='$name'");
                    if($sql){echo "<span>email changed!<br></span>";}
                    }
                    else{};
                    ?>
          </div>
        </div>
        <div class="footer">
                <div class="footerImage"></div>
        </div>
    </body>
</html>
