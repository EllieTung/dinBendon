<?php
session_start();
require("config.php");
connectToDb();
    $result = "";
    if (!isset($_GET["class"]))
    	die("please choose class.");


    $class = $_GET["class"];
    $sql=mysql_query("select name from memberInfo where class='$class'");
    //$sql=mysql_query("select name from memberInfo where class='mesa05'");
    
    while($row=mysql_fetch_row($sql)){
        //$result.=$row[0]."<br>";
        $result.=sprintf("<option value='%s'>%s</option>",$row[0],$row[0]);
    }
    echo $result;
?>
