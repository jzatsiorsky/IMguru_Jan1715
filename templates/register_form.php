<h1 style="margin:0 0 20px 0;"> Register for an account. </h1>
<form action="register.php" method="post">
	<div class="boxed">
		<fieldset>
		    <div class="form-group">
		        <input autofocus class="form-control" name="email" placeholder="Username" type="text" autocomplete="off"/>
		        <label style="color: white;">@</label>
		        <select class="form-control" name="school">
		        	<option value="college">college</option>
		        	<option value="fas">fas</option>
		        	<option value="g">g</option>
		        </select>
		        <label style="color:white;">.harvard.edu</label>
		    </div>
			<div id="names">
			 	<div class="form-group" style="display:inline-block;">
						<input autofocus class="form-control" name="first_name" placeholder="First Name" type="text" autocomplete="off"/>
				</div>
				<div class="form-group" style="display:inline-block;">
						<input autofocus class="form-control" name="last_name" placeholder="Last Name" type="text" autocomplete="off"/>
				</div>
			</div>
			<div class="form-group" style="clear:both;">
				<select class="form-control" name="house">
				<option value = "">Select House </option>
				<option value = "Adams">Adams </option>
				<option value = "Cabot">Cabot </option>
				<option value = "Currier">Currier </option>
				<option value = "Dudley">Dudley </option>
				<option value = "Dunster">Dunster </option>
				<option value = "Eliot">Eliot </option>
				<option value = "Kirkland">Kirkland </option>
				<option value = "Leverett">Leverett </option>
				<option value = "Lowell">Lowell </option>
				<option value = "Mather">Mather </option>
				<option value = "Pforzheimer">Pforzheimer </option>
				<option value = "Quincy">Quincy </option>
				<option value = "Winthrop">Winthrop </option>
				</select>
			</div>
			<! radio button html adapted from w3schools.com >
			<div class="form-group">
				 <input class="form-control" name="password" placeholder="Password" type="password"/>
			</div>
			<div class ="form-group">
				<input class ="form-control" name="confirmation" placeholder="Confirm Password" type="password"/>
			</div>
			<div class="form-group">
				<button type="submit" class="button-login">Register</button>
			</div>
		</fieldset>
	</div>
</form>
<div>
	or <a href="login.php">log in</a> 
</div>
