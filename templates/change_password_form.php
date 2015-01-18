<!- Include navigation bar>
<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Change password. </h1>
<form action="change_password.php" method="post">
    <fieldset>
	<div class="boxed">
		    <div class="form-group">
		        <input class="form-control" name="cur_password" placeholder="Current Password" type="password"/>
		    </div>
		    <div class="form-group">
		        <input class="form-control" name="new_password1" placeholder="New Password" type="password"/>
		    </div>
		    <div class ="form-group">
		        <input class ="form-control" name="new_password2" placeholder="Repeat New Password" type="password"/>
		    </div>
		    <div class="form-group">
		        <button type="submit" class="btn btn-default">Reset Password</button>
		    </div>
		</div>
    </fieldset>
</form>
<div>
    or <a href="index.php">go back</a> 
</div>
