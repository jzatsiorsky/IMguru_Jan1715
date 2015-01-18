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

<h1 style="color: black;"><?= $_SESSION["name"] ?>'s Profile </h1>


<div id="photo">
</div>
<br>
<input type="hidden" role="uploadcare-uploader"
  data-crop="200x200"
  data-images-only="true"
  name="upload"
 />

<?php if ($_SESSION["ref"] ==0): ?>
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
					<div>
						<p style="color:white;">Note: This changes where e-mails are sent. <br>It does <strong>not</strong> change your login information.</p>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<div>
    or <a href="index.php">go back</a> 
</div>


<script>


// default profile picture
var defaultURL = "http://www.ucarecdn.com/6d29ef92-786d-43be-aefd-6a80fe4d4812/-/resize/200x200/";

$(document).ready(function() {
	// current url of profile picture
	var url = "<?= $url ?>";

	// if no profile picture set, show default
	if (url == "") {
		var photoHTML = "<img src='" + defaultURL + "' style='border-radius:100px;'/>";
		$("#photo").html(photoHTML);
	}
	// else show current profile picture
	else {
		var photoHTML = "<img src='" + url + "' style='border-radius:100px;'>";
		$("#photo").html(photoHTML);
	}
});

var widget = uploadcare.Widget('[role=uploadcare-uploader]');

widget.onUploadComplete(function(info) {
  // add the photo to the database
  url = info.cdnUrl;
  $.ajax({
		type: "POST",
		url: "add_photo.php/",
		data: {  url: url }
	})
  	changePicture(url);
	// change the div to show the new photo
	var photoHTML = "<img src='" + url + "' style='border-radius: 100px;'/>";
	$("#photo").html(photoHTML);
});

</script>






