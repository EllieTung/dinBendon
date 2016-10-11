
<?php
session_start();
require("config.php");
if(!empty($_POST["username"])) {
    if (connectToDb()==true) {        
        $result = mysql_query("SELECT count(*) FROM memberInfo WHERE username='" . $_POST["username"] . "'");
        $row = mysql_fetch_row($result);
        $user_count = $row[0];
        if($user_count>0) echo "<span class='status-not-available'> Username Not Available.</span>";
        else echo "<span class='status-available'></span>";
        //else echo "<span class='status-available'> Username Available.</span>";
    }
}

?>
