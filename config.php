<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$dbname = 'Bendon';
//------------0.設定基本連線資料庫參數	
	
	
    

//-------------------------------資料庫連線及登入狀況確認------------------------------------------
	
function connectToDb() {
	global $dbhost, $dbuser, $dbpass,$dbname;  
	$link = mysql_connect ( $dbhost, $dbuser, $dbpass );
	$result = mysql_query ( "set names utf8", $link );
	$linkdb = mysql_select_db ( $dbname, $link );
	$passed = false;
	    if(!$link) {
                echo "fail @ connect to DB";
                $passed = false;
                goto loginDB_return;
        }
        if(!$linkdb) {
                echo "fail @ use DB";;
                $passed = false;
                goto loginDB_return;
        }
        else {
                $passed = true;
        }
        loginDB_return:
        
        return $passed;
}
function loginToDb($username, $password) {
    $sql = "SELECT username, password FROM memberInfo where username = '$username'";
    $result = mysql_query($sql);
    $row = mysql_fetch_row($result);
    
    if($username != null && $password != null && $row[0]==$username && $row[1]==$password) {
        $_SESSION['entered'] = true;
        $_SESSION['username']=$username;
    }
    else{
        $_SESSION['entered'] = false;
    }
    return $_SESSION['entered'];
}


function getMemberInfo($wantedInfo) {
        $memberInfo = "";
        if($_SESSION['entered']==true) {
                $username = $_SESSION['username'];
                $sql = "SELECT ".$wantedInfo. " FROM memberInfo WHERE username='$username'";
                $result = mysql_query($sql);
                $row = mysql_fetch_row($result);
                return $row[0];
        }
}

function dateToday(){
    date_default_timezone_set('Asia/Taipei');
    $date = date("Y-m-d");
    return $date;
}

?>