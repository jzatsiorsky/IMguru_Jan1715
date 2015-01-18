<h1 style="margin:0 0 20px 0;"> Recover Password. </h1>
<form action="recover_password.php" method="post">
	<div class="boxed container-fluid">
		<fieldset>
		    <div class="form-group">
		        <input autofocus class="form-control" name="username" placeholder="Username" type="text" autocomplete="off">
		        <label style="color:white;">@</label>
		        <select class="form-control" name="school" id="login_form_school">
		        	<option value="college">college</option>
		        	<option value="fas">fas</option>
		        	<option value="g">g</option>
		        </select>
		        <label style="color:white;">.harvard.edu</label>

		    </div>

		    <div class="form-group">
		        <button type="submit" class="btn btn-default">Recover Password</button>
		    </div>

		</fieldset>
		<div class="tiptext"><p style="color:white;">Need help?</p>
			<div class="description"> 
			<p>Your username is what comes before the @college.harvard.edu in your e-mail address.</p>
			
		</div>
	</div>
</div>

</form>
<div>
    Remember? <a href="login.php">Log in.</a>
</div>



<script>
	$(".tiptext").mouseover(function() {
	    $(this).children(".description").show();
	}).mouseout(function() {
	    $(this).children(".description").hide();
	});
</script>
