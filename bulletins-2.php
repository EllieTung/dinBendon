<?php
require('bulletins_config.php');

function goback(){   // 輸出表頭以返回主頁面的函式
  header( 'Location: http://'. $_SERVER['HTTP_HOST'].
  		  'bulletins-1.php');
  exit();
}

// 檢查是否有 $_GET['op'] 參數
// 新增時需有日期資料, 編輯時需有備忘錄 id 
if(empty($_GET['op']) ||
   (($_GET['op']=='new') && empty($_GET['memoDate']) ) ||
   (($_GET['op']=='edt') && empty($_GET['id']   ) ) )
  goback();
// 編輯現有資料
if($_GET['op']=='edt'){
  // 取得指定 id 的備忘錄資料
  $id = $_GET['id'];
  $st = $db->prepare('SELECT * FROM memo WHERE id = ?;');
  $st->bindValue(1, $id, PDO::PARAM_INT);
  $st->execute();
  $row=$st->fetch();  
  if(empty($row))     // 若沒有資料即返回
    goback();

  // 設定稍後用於 HTML 表單中的變數	
  $op = "upd";
  $memo = $row['memo'];
  $memoDate = $row['memoDate'];
  $submit = "儲存";
}
else { // 新增資料, 不需執行查詢
  // 設定稍後用於 HTML 表單中的變數
  $op = "ins";
  $id = ""; 
  $memo = "";
  $memoDate = $_GET['memoDate'];
  $submit = "新增";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>每周行事曆</title>
  <meta charset="UTF-8">
</head>
<body>
<form method="get"  action="bulletins-3.php">
<!--  利用隱藏欄位設定要送出的表單參數 -->
<input type="hidden" name="op" value="<?php echo $op; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">
待辦日期：<input type="text" readonly name="memoDate" 
                  value="<?php echo $memoDate; ?>"><br>
待辦事項：<input type="text" name="memo" 
                  value="<?php echo $memo; ?>" required><br>
<input type="submit" name="submit" 
       value="<?php echo $submit; ?>">
</form>
</body>
</html>