<body data-role="page"/>    
<?php
session_start();
require("config.php");

connectToDb();

    $name = $_POST['name'];
    $username = $_POST['username'];
    $passwordFormer = $_POST['password'];
    $password=md5($passwordFormer);
    $password2 = $_POST['password2'];
    $birthday = $_POST['birthday'];
    $cellphone = $_POST['cellphone'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    
function registerUserToDb($name,$username,$password,$birthday,$cellphone,$email,$class) {
        
        $passed = false;
        $sql = "insert into memberInfo (name, username, password,account, birthday,cellphone,email, class) values 
                          ('$name','$username','$password','0','$birthday','$cellphone','$email','$class')";

        if(mysql_query($sql))
        {
                $passed = true;
                $_SESSION['username'] = $username;                
        }
        else
        {
                $passed = false;                
        }       

        return $passed; 
}

if($name != null && $username != null && $password != null && 
   $password2 != null && $passwordFormer == $password2 && $birthday != null
   && $cellphone != null && $email != null){
       if (registerUserToDb($name,$username,$password,$birthday,$cellphone,$email,$class)==true) {
            echo "<div align='center'><h1>register success! please login again</h1></div>";
            echo '<meta http-equiv=REFRESH CONTENT=3;url=index.php>';
        }
        else {
            echo "<div align='center'><h1>register fail! please try again</h1></div>";
            echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
        }
        
}
else
{
        echo "<div align='center'><h1>please fulfill in correct format!</h1></div>";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=register.php>';
}
?>