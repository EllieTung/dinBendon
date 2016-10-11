<?php
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Taipei');   // 設定時區

try{
  // 開啟資料庫
  $db = new PDO("mysql:host=localhost;dbname=Bendon;port=3306", "root", "");
} catch (PDOException $e) {
  if ($e->getCode() == '1045')  // 連線失敗
	die("連線失敗");            // 即結束程式
}
?>