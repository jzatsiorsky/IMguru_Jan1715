<!-- Include navigation bar-->
<?php include 'navigation.php';?>

<h3 style="margin:0 0 20px 0;"> Make an announcement</h3>

<div class="container-fluid">
<form action = "announcement.php" method="post">
	<fieldset>
		<div class="form-group">
			<textarea class="form-control" rows="3" style="resize:none; width: 30%;text-align:left;" name="announcement" id="announcement"></textarea>
		</div>
		<div class="form-group">
			<label for="announcementTo1">To </label>
			<select class="form-control" name="announcementTo1">
				<option value="allPlayers">All players</option>
				<option value="allCaptains">All captains</option>
			</select>
			<label for="announcementTo1"> in </label>
			<select class="form-control" name="announcementTo2">
				<option value="allHouses">All houses</option>
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
			<label id="announcementPlus" for="announcementTo2" style="font-size: 18px;">
				<button type="button" class="btn btn-default" aria-label="Left Align" onclick ="addHouse();">
  					<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
				</button>
			</label>
			<label style="display:none;" for="announcementTo3" id="hiddenLabel"> and </label>
			<select style="display:none;" class="form-control" name="announcementTo3" id="hiddenSelect">
				<option value = "">Select House</option>
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
			<label id="announcementMinus" for="announcementTo3" style="display: none;">
				<button type="button" class="btn btn-default" aria-label="Left Align" onclick ="removeHouse();">
  					<span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
				</button>
			</label>

			

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

<script>
function loader() {
	document.getElementById('announcementLoader').innerHTML = "";
	if (document.getElementById('announcement').value == "") {
		event.preventDefault();
		document.getElementById('announcementLoader').innerHTML = "<p class='bg-warning'> You cannot send an empty announcement.</p>";
	}
	else if (document.getElementById('hiddenSelect').style.display == "inline" && document.getElementById('hiddenSelect').selectedIndex == 0) {
		event.preventDefault();
		document.getElementById('announcementLoader').innerHTML = "<p class='bg-warning'> Select an option for the second dropdown.</p>";
	}
	else {
		document.getElementById('announcementLoader').innerHTML = "<img src='img/ajax-loader.gif'><p>Generating e-mails...</p>";
	}
}

function addHouse(){
	document.getElementById('hiddenSelect').style.display = "inline";
	document.getElementById('hiddenLabel').style.display = "inline";
	document.getElementById('announcementMinus').style.display = "inline";
	document.getElementById('announcementPlus').style.display = "none";
}

function removeHouse() {
	document.getElementById('hiddenSelect').style.display = "none";
	// set the hidden select element to empty value
	document.getElementById('hiddenSelect').selectedIndex = 0;
	document.getElementById('hiddenLabel').style.display = "none";
	document.getElementById('announcementMinus').style.display = "none";
	document.getElementById('announcementPlus').style.display = "inline";


}







</script>
