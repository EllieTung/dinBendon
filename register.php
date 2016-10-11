<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<link rel="stylesheet" href="jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="jquery-1.9.1.min.js"></script>
<script src="jquery.mobile-1.3.2/jquery.mobile-1.3.2.min.js"></script>
<!-- -----利用ajax確認帳號是否重複----- -->
<script type="text/javascript">
        $(document).ready(init);
        
        function init() {
        	$("#username").blur(checkUserNameAvailable);	
        }
        
		function checkUserNameAvailable(){
			jQuery.ajax({
			url: "check_availability.php",
			data:'username='+$("#username").val(),
			type: "POST",
			success:function(data){
			$("#user-availability-status").html(data);
			if ($("span.status-not-available").length>0) {				
				$("#username").css({"border":"solid #ff0000"});	
			}
			else {
				$("#username").css({"border":"solid #00ff00"});
			}
			
			},
			error:function (){}
			});
		}
        
</script>
</head>
<body>
	<div data-role="page">
	    <div data-role="header"><h1>會員資料</h1></div>
		<div data-role="content">
        	<form method="post" action="register_finish.php">
			    <div data-role="fieldcontain">
				    <label for="name">姓名:</label>
				     <input type="text" name="name" id="name" placeholder="請輸入姓名" required><br>
		
			        <br><label for="username">帳號:</label>
				     <input type="text" name="username" id="username" placeholder="請輸入帳號"required><span id="user-availability-status"></span><br>
		
			        <br><label for="password">密碼:</label>
				     <input type="password" name="password" id="password" placeholder="請輸入密碼" required><br>
			        
			        <br><label for="password2">再次輸入密碼:</label>
				     <input type="password" name="password2" id="password2" placeholder="請再次輸入密碼"required><br>
			         
			        <br><label for="birthday">生日:</label>
				     <input type="text" name="birthday" id="birthday" placeholder="YYYY-mm-dd" required pattern="^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|1\d|2\d|3[0-1]$"><br>
			        
			        <br><label for="cellphone">手機號碼:</label>
				     <input type="text" name="cellphone" id="cellphone" placeholder="09xxxxxxxx" required pattern="09\d{8}"><br>
			        
			        <br><label for="email">郵箱:</label>
				    <input type="text" name="email" id="email" placeholder="請輸入郵箱" required pattern="\w+([-.]\w+)*@\w+([-.]\w+)+"><br>
			        
			   </div>
			        <fieldset data-role="controlgroup">
        				 <label for="class">班級:</label>
        				 <select name="class" id="class" data-native-menu="false">
        				    <option value="-1" data-placeholder="true">請選擇:</option>
        				    <option value="mesa01">mesa01</option>
        				    <option value="mesa02">mesa02</option>
        				    <option value="mesa03">mesa03</option>
        				    <option value="mesa05">mesa05</option>
        			 	 </select>
			        </fieldset>
			   
			    <div class="ui-grid-c">
			        <div class="ui-block-a">&nbsp</div>
			        <div class="ui-block-b">&nbsp</div>
			        <div class="ui-block-c"><input type="reset" value="重新輸入"></div>
			        <div class="ui-block-d"><input type="submit" name="btnRegi" value="註冊"></div>
			    </div>
			    
			</form>
		</div>
		
	</div>
	
</body>
</html>
