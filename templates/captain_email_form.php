<!-- Include navigation bar-->
<?php include 'navigation.php';?>

<h3 style="margin:0 0 20px 0;"> Email all of your house's players for a sport's league!</h3>

<div class="container-fluid">
<form action = "captain_email.php" method="post">
	<fieldset>
		<div class="form-group">
			<textarea class="form-control" rows="3" style="resize:none; width: 30%;text-align:left;" name="announcement" id="announcement"></textarea>
		</div>
		<div class="form-group">
			<label for="sport">To all &nbsp</label>
			<select class="form-control" name="sport">
				<option value="">Choose a sport</option>
				<?php foreach($lists as $list): ?>
					<option value="<?= $list ?>"><?= $list ?></option> 
				<?php endforeach ?>
			</select>
			<label for="sport"> &nbsp players in <?= $_SESSION["house"] ?> </label>
		</div>
		<div class="form-group">
			<button id = "submit" class="form-control" type="submit" onclick = "loader();">Send</button>
		</div>
	</fieldset>
</form>
</div>


<div id="announcementLoader">
	<?php if (isset($success)): ?>
		<p class="bg-success">Success!</p>
	<?php endif ?>
</div>


<br>
<div>
    or <a href="index.php">go back</a> 
</div>

