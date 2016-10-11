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
                                <li><a style="background-color:	#FFA500"href="#">Order Record</a></li>
                                <li><a style="background-color:	#8FBC8F"href="vendorRecommend.php">Menu</a></li>
                                <li><a style="background-color:	#DDA0DD"href="bulletins-1.php">Bulletin</a></li>
                                <!-- need add something else --> 
                            </ul>
                        </div>
            <script>
                 $(document).ready(init);
            function init() {
            	$("#class").change(letterChange);
            }
            function letterChange() {
            	// var s = $("#letter option:selected").val();
            	var s = $("#class option:selected").text();
            	$.get('searchHistory_ajax.php?class=' + s, letterChangeDataBack)
            }
            function letterChangeDataBack(data) {
            	$("#name").html(data);
            }
            </script>
<!-------------------管理者可以看到的頁面 ---------------------->
<?php
if($_SESSION['entered']==false) {
    echo "<h3 align='center'>Please login first!</h3><br>";
    echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}

if($_SESSION['username']=="BendonManager"){
	echo "<form method='post' action=''>
		<select name='class' id='class'>
			<option value='mesa01'>mesa01</option>
			<option value='mesa02'>mesa02</option>
			<option value='mesa03'>mesa03</option>
			<option value='mesa05'>mesa05</option>
		</select>&nbsp;|&nbsp; 
		<select name='name' id='name'>
			<option value='0'>A01</option>
			<option value='1'>B02</option>
			<option value='2'>C03</option>
		</select> 
		<input type='submit' name='btnSearch' value='查詢' />";
              if(isset($_POST["btnSearch"])){
                  $name = $_POST["name"];
                  $_SESSION['currentName']=$name;
                  $result=mysql_query("SELECT `date`,`name`, `expenditure`, `deposit` FROM `dailyRecord` WHERE name='$name'");
                  $total_records=mysql_num_fields($result);
                  echo "<br><table align='center' border=3>";
                  echo "<tr><th>日期</th><th>姓名</th><th>支出</th><th>存入</th></tr>";
                while($x=mysql_fetch_row($result)){
                    echo "<tr>";
                    for($j=0;$j<$total_records;$j++)
                        echo "<td> $x[$j]</td>";
                        echo "</tr>";
                    }
                 echo "</table><br> 
                 <form method='post' action=''>
                 儲值 <input type='text' name='chargeMoney'>元&nbsp
                 <input type='submit' name='btnCharge'value='確定'>
                 </form>
                 </div>";
              }
              if(isset($_POST["btnCharge"])){
                     $name = $_SESSION["currentName"];
                     $chargeMoney=$_POST['chargeMoney'];
                     $date=dateToday();
                     $record=mysql_query("INSERT INTO dailyRecord(date,vendor,menu,name,expenditure,deposit) values
                                              ('$date','0','0','$name','0','$chargeMoney')");
                     $getAccount=mysql_query("SELECT `account` FROM `memberInfo` WHERE name='$name'");
                     $row=mysql_fetch_row($getAccount);
                     $account = $row[0]+$chargeMoney;
                     $changeAccount=mysql_query("UPDATE memberInfo SET account=$account WHERE name='$name'");
                     unset($_SESSION["currentName"]);
                     if($record=true && $changeAccount=true){
                         echo "<br><h1>儲值成功!</h1><br>";
                         echo '<meta http-equiv=REFRESH CONTENT=2;url=searchHistory.php>';
                     }
                 }
}
?>
      <!--回來繼續寫儲值送出的帳戶餘額變更 還有計算每天的便當數量跟金額   -->
         
<!-------------------一般使用者看到的頁面----------------------  -->
<?php if($_SESSION['username']!=="BendonManager"){ 
   echo "<form method='post' action=''>
       <input type='submit' name='btnSearch' value='查詢' />"; 
       if(isset($_POST["btnSearch"])){
                  $username = $_SESSION["username"];
                  $findName=mysql_query("SELECT `name`FROM `memberInfo` WHERE username='$username'");
                  $getName=mysql_fetch_row($findName);
                  $name=$getName[0];
                  $result=mysql_query("SELECT `date`,`name`,`menu`, `expenditure`, `deposit` FROM `dailyRecord` WHERE name='$name'");
                  $total_records=mysql_num_fields($result);
                  echo "<br><table align='center' border=3>";
                  echo "<tr><th>日期</th><th>姓名</th><th>便當</th><th>支出</th><th>存入</th></tr>";
                while($x=mysql_fetch_row($result)){
                    echo "<tr>";
                    for($j=0;$j<$total_records;$j++)
                        echo "<td> $x[$j]</td>";
                        echo "</tr>";
                    }
                 echo "</table></div>";
              };
}
?>
         </div></div></div>
        <div class="footer">
                <div class="footerImage"></div>
        </div>
    </body>
</html>