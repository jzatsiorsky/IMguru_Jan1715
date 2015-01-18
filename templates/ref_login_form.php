<h1 style="margin:0 0 20px 0;"> Referees: Log in. </h1>
<form action="referee.php" method="post">
	<div class="boxed container-fluid">
		<fieldset>
		    <div class="form-group">
		        <input autofocus id="login_form_username" class="form-control" name="username" placeholder="Username" type="text" autocomplete="off">
		        <label style="color:white;">@</label>
		        <select class="form-control" name="school" id="login_form_school">
		        	<option value="college">college</option>
		        	<option value="fas">fas</option>
		        	<option value="g">g</option>
		        </select>
		        <label style="color:white;">.harvard.edu</label>

		    </div>
		    <div class="form-group">
		        <input id="login_form_password" class="form-control" name="password" placeholder="Password" type="password"/>
		    </div>
		    <div class="form-group">
		        <button type="submit" class="btn btn-default" id="login_button">Log In</button>
		    </div>
		    <div id="login_form_empty_field" style="height:20px;">
		    </div>

		</fieldset>
		<div class="tiptext"><p style="color:white;">Need help logging in?</p>
			<div class="description"> 
			<p>Your username is what comes before the '@' in your Harvard e-mail address.</p>
			
			<p>If you need to recover your password, <a href="/recover_password.php">click here. </a></p>
		</div>
	</div>
</div>

</form>
<div>
    <a href="ref_register.php">Register</a> for a referee account.
</div>
<div>
    <a href="login.php">Log in</a> as a player.
</div>



<script>
// Scroll over help text
	$(".tiptext").mouseover(function() {
	    $(this).children(".description").show();
	}).mouseout(function() {
	    $(this).children(".description").hide();
	});

// User should submit all forms
$( "form" ).submit(function( event ) {
  if ($("#login_form_password").val() == "" || $("#login_form_username").val() == "")
  {
  		 event.preventDefault();
		$("#login_form_empty_field").html('<p style="color:white; text-decoration: underline;">Please submit all fields.</p>');
  }
  // client-side check of username/password
  /*
  else
  {
  	var username = $("#login_form_username").val();
  	var password = $("#login_form_password").val();
  	var school = $("#login_form_school").val();

  	var parameters = {
  		username: username,
  		password: password,
  		school: school
  	}
 	var result = $.getJSON("client_side_login.php", parameters)
	result.done(function(data) {
		// don't allow form to submit if the username or password is incorrect
		if (data == "1")
		{
			$("#login_form_empty_field").html('<p style="color:white; text-decoration: underline;">Incorrect username or password.</p>');
		}
		else
			$("form").unbind(event);
			$("#login_button").trigger('click');
	});
  }
  */
});
</script>