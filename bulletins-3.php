<?php
require('bulletins_config.php');

function goback(){   // 輸出表頭以返回主頁面的函式
  header( 'Location: http://'.  $_SERVER['HTTP_HOST'] .
		  'bulletins-1.php');
  exit();
}
$msg ="";       // 訊息字串變數

// 若 GET 參數無 op 及 mdate, 即返回主頁面
if(empty($_GET['op']) || empty($_GET['memoDate']))  goback();

switch($_GET['op']){  // 依據 op 參數決定要執行的動作
  case 'del':  // 刪除資料
    if(empty($_GET['id']))  goback();
	
	$st = $db->prepare('DELETE FROM memo WHERE id= ?;');
	$st->bindValue(1, $_GET['id'], PDO::PARAM_INT);
    $result = $st->execute();
	
	if(!$result)  goback();   // 若執行失敗即回主頁面
    
	$msg="刪除成功";
	echo '<meta http-equiv=REFRESH CONTENT=1;url=bulletins-1.php>';
	break;
  case 'ins':  // 新增資料
    if ( empty($_GET['memo']) )	  goback();
        
    $st = $db->prepare('INSERT INTO memo (memo, memoDate) 
                      VALUES (?, ?);');
	$st->bindValue(1, $_GET['memo'], PDO::PARAM_STR);
	$st->bindValue(2, $_GET['memoDate'], PDO::PARAM_STR);
    $result = $st->execute();
  
    if(!$result)  goback();   // 若執行失敗即回主頁面
  
    $msg="新增成功";
    echo '<meta http-equiv=REFRESH CONTENT=1;url=bulletins-1.php>';
    break;
  case 'upd':  // 更新資料
    if( empty($_GET['memo']) )    goback();
    
    $st = $db->prepare('UPDATE memo SET memo = ? 
	                    WHERE id =?;');
	$st->bindValue(1, $_GET['memo'], PDO::PARAM_STR);
	$st->bindValue(2, $_GET['id'], PDO::PARAM_INT);
    $result = $st->execute();
  
    if(!$result)  goback();   // 若執行失敗即回主頁面
  
    $msg="更新成功";
    echo '<meta http-equiv=REFRESH CONTENT=1;url=bulletins-1.php>';
	break;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>每周行事曆</title>
  <meta charset="UTF-8">
</head>
<body>
  <p><?php echo $msg; ?></p>
</body>
</html>