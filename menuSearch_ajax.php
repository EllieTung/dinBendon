<?php
session_start();
require("config.php");
connectToDb();
    $result = "";
    $vendor=$_GET["button"];
    $sql=mysql_query("SELECT id,menu,price FROM menu WHERE vendor='$vendor'");
    while($x=mysql_fetch_row($sql)){
        for($j=1;$j<3;$j++){
            echo "$x[$j]";
        }
        echo'/';
    }
?>
