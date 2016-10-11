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
                            <li><a style="background-color:	#8FBC8F"href="#">Menu</a></li>
                            <li><a style="background-color:	#DDA0DD"href="bulletins-1.php">Bulletin</a></li>
                            <!-- need add something else --> 
                        </ul>
                    </div>
                    Current Vendor:
                    <?php
                    $sql=mysql_query("SELECT * FROM vendor");
                    $sql_ColumnCountResults = mysql_query("SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'vendor'");
                    $ColumnCount=mysql_fetch_row($sql_ColumnCountResults);
                    echo"<form method='get' action=''>";
                    echo "<table>";
                    
                    while($vendorInfo=mysql_fetch_row($sql)){
                        echo"<tr>";
                        for($colIndex=0;$colIndex<$ColumnCount[0];$colIndex++){
                            echo "<td>" .$vendorInfo[$colIndex] ."</td>";
                        }
                        echo"<td><input type='button' name='$vendorInfo[1]' value='查詢'></td>";
                        echo "</tr>";
                    }
                     echo "</table></form>";
                    ?>
                    <script>
                         $(document).ready(init);
                    function init() {
                    	$(":button").click(menuSearch);
                    }
                    function menuSearch() {
                    	// var s = $("#letter option:selected").val();
                    // 	var s = $("input").attr('name');
                        var s = $(this).attr('name');
                    	$.get('menuSearch_ajax.php?button=' + s, menuSearchBack)
                    }
                    function menuSearchBack(data) {
                        alert(data);
                    }
                    </script>
                </div>
            </div>
        </div>
        
        
        <div class="footer">
                <div class="footerImage"></div>
        </div>
    </body>
</html>