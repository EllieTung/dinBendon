<?php
session_start();
require("bulletins_config.php");
if($_SESSION['entered']==false){
echo "<h3>Please login first!<br></h3>";
echo '<meta http-equiv=REFRESH CONTENT=1.5;url=index.php>';
}
?>
<!DOCTYPE html>
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
                                <li><a style="background-color:	#DDA0DD"href="#">Chatroom</a></li> 
                            </ul>
                        </div>
                        <div class="chatRoom">
                    <?php
                    if(!empty($_GET['goto'])){  // 算出日期是星期幾 
                      $dayDiff=date("w", strtotime($_GET['goto'])); 
                      // 取得周日的日期
                      $sunday = strtotime($_GET['goto'])-$dayDiff*86400;
                    }
                    else {
                      $dayDiff = date("w"); 
                      // 取得周日的日期
                      $sunday = time()-$dayDiff*86400;
                    }
                    ?>
                    <table>
                    <tr>
                    <td colspan="2">
                    <div class="left">
                      <a href="bulletins-1.php?goto=<?php // 輸出連結中的日期參數
                                  echo date("Y-m-d", $sunday-86400*7); ?>">&nbsp<<</a>
                    </div>
                    <div class="right">
                      <a href="bulletins-1.php?goto=<?php // 輸出連結中的日期參數
                                  echo date("Y-m-d", $sunday+86400*7); ?>">>>&nbsp</a>
                      </div>
                    <div class="year" id="year"><b><?php echo date("Y", $sunday); ?></b></div>
                    </tr>
                    <?php
                    // 預備用來查詢每日備忘事項的查詢敘述 
                    $st = $db->prepare('SELECT * FROM memo WHERE memoDate = ?;');
                    $week = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                    // 用迴圈查詢及輸出 7 天的備忘事項
                    for($i=0;$i<7;$i++) {
                      echo '<tr><td class="day" id="d'.$i.'">';
                      $day= $sunday+$i*86400;
                      echo date("m-d",$day)."({$week[$i]})</td><td>";
                     // 用日期當參數進行查詢
                      $st->execute( [date("Y-m-d",$day)] );
                     $result = $st->fetchAll();  
                     // 取得查詢結果
                      foreach($result as $row){
                        // 輸出備忘內容
                    	echo htmlspecialchars($row['memo']) . "\n&nbsp;"; 
                    	// 輸出刪除, 編輯連結
                        echo '<a href="bulletins-3.php?op=del&id='.
                    	     $row['id'].'&memoDate='.date("Y-m-d",$day).'">Delete</a>';
                        echo "\n&nbsp;".
                             '<a href="bulletins-2.php?op=edt&id='. $row['id']. 
                    		 '">Edit</a><br>'."\n";
                     }
                      // 輸出新增備忘的連結
                      echo '<div class="right"><a href="bulletins-2.php?op=add&memoDate=' . 
                           date("Y-m-d",$day) . '">Add&nbsp</a></div>';
                      echo '</td></tr>';
                     }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
            <div class="footerImage"></div>
    </div>    
    </body>
</html>