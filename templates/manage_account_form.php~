<!-- Include navigation bar-->
<?php include 'navigation.php';?>

<!-- Display success message upon change of account info -->
<?php if (isset($success)): ?>
	<?php if ($success == "captain"): ?>
		<h1>Congrats, you are now a captain!</h1>
	<?php elseif ($success == "password"): ?>
		<h1>You successfully changed your password.</h1>
	<?php elseif ($success == "email"): ?>
		<h1>You successfully changed your e-mail.</h1>
	<?php endif ?>
	
<?php endif ?>

<!-- Check if the user is not a captain -->
<?php if ($_SESSION["captain"] == 0): ?>

<h3 style="margin:0 0 20px 0;"> Become a Captain. </h3>
<form action="become_captain.php" method="post">
    <fieldset>
	<div class="boxed-captain">
		    <div class="form-group">
		        <input class="form-control" name="captainpassword" placeholder="Captain Password" type="password"/>
		    </div>
		    <div class="form-group">
		        <button type="submit" class="btn btn-default">Submit</button>
		    </div>
		</div>
    </fieldset>
</form>

<?php endif ?>

<div class = "divider">
	<div class = "fixed-account">
		<h3 style="margin:0 0 20px 0;"> Change password. </h3>
		<form action="change_password.php" method="post">
			<fieldset>
			<div class="boxed-account">
					<div class="form-group">
					<input class="form-control" name="cur_password" placeholder="Current Password" type="password"/>
					</div>
					<div class="form-group">
					<input class="form-control" name="new_password1" placeholder="New Password" type="password"/>
					</div>
					<div class ="form-group">
					<input class ="form-control" name="new_password2" placeholder="Confirm Password" type="password"/>
					</div>
					<div class="form-group">
					<button type="submit" class="btn btn-default">Reset Password</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	
	<div class = "flexed-account">
		<h3 style="margin:0 0 20px 0;"> Change e-mail. </h3>
		<form action="change_email.php" method="post">
			<fieldset>
				<div class="boxed-account">
					<div class="form-group">
					<input class="form-control" name="new_email1" placeholder="New E-mail" />
					</div>
					<div class ="form-group">
					<input class ="form-control" name="new_email2" placeholder="Repeat New E-mail" />
					</div>
					<div class="form-group">
					<button type="submit" class="btn btn-default">Reset E-mail</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<div>
    or <a href="index.php">go back</a> 
</div>

