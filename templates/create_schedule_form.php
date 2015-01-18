<head>
	<script src="/js/jquery-2.1.1.js"></script> 
    <script src="/js/scripts.js"></script> 
	<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css"> 
	<script type="text/javascript" src="js/jquery.plugin.js"></script> 
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
	<script>
		$(function() {
			$('#popupDatepicker').datepick();
		});
	</script>
	<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css"> 
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
	<script>
	$(document).ready(function(){
		$('input.timepicker').timepicker({
			defaultTime: new Date(0,0,0,18,0,0), 
			minHour: 10, 
			maxHour: 22, 
			dynamic: false, 
			timeFormat: 'h:mm a',
			forceRoundTime: true
		});
	});
	</script>

</head>
<!-- Include navigation bar-->
<?php include 'navigation.php';?>

<h1 style="margin:0 0 20px 0;"> Generate a schedule. </h1>
<form action="create_schedule.php" method="post">
	<div class="boxed" style="width: 50%;">
		<fieldset>
			<h4 style="color: white;"> Choose sport. </h4>
			<div class="form-group" style="clear:both;">
				<select class="form-control" name="sport">
				<option value = "">Select Sport </option>
				<option value = "A Basketball">A Basketball</option>
		        <option value = "B Basketball">B Basketball</option>
		        <option value = "C Basketball">C Basketball</option>
		        <option value = "A Crew - Men">A Crew - Men</option>
		        <option value = "B Crew - Men">B Crew - Men</option>
		        <option value = "A Crew - Women">A Crew - Women</option>
		        <option value = "B Crew - Women">B Crew - Women</option>
		        <option value = "Flag Football">Flag Football</option>
		        <option value = "Ice Hockey">Ice Hockey</option>
		        <option value = "Soccer">Soccer</option>
		        <option value = "Softball">Softball</option>
		        <option value = "Tennis">Tennis</option>
		        <option value = "A Volleyball">A Volleyball</option>
		        <option value = "B Volleyball">B Volleyball</option>
				</select>
			</div>
			<h4 style="color: white;"> Confirm teams competing in this league. </h4>
			<div class="form-group">
				 <label style="color:white;"> Adams <input type="checkbox" class="form-control" name="Adams" checked="yes"/></label><br>
				 <label style="color:white;"> Cabot <input type="checkbox" class="form-control" name="Cabot" checked="yes"/></label><br>
				 <label style="color:white;"> Currier <input type="checkbox" class="form-control" name="Currier" checked="yes"/></label><br>
				 <label style="color:white;"> Dudley <input type="checkbox" class="form-control" name="Dudley" checked="yes"/></label><br>
				 <label style="color:white;"> Dunster <input type="checkbox" class="form-control" name="Dunster" checked="yes"/></label><br>
				 <label style="color:white;"> Eliot <input type="checkbox" class="form-control" name="Eliot" checked="yes"/></label><br>
				 <label style="color:white;"> Kirkland <input type="checkbox" class="form-control" name="Kirkland" checked="yes"/></label><br>
				 <label style="color:white;"> Leverett <input type="checkbox" class="form-control" name="Leverett" checked="yes"/></label><br>
				 <label style="color:white;"> Lowell <input type="checkbox" class="form-control" name="Lowell" checked="yes"/></label><br>
				  <label style="color:white;"> Mather <input type="checkbox" class="form-control" name="Mather" checked="yes"/></label><br>
				  <label style="color:white;"> Pforzheimer <input type="checkbox" class="form-control" name="Pforzheimer" checked="yes"/></label><br>
				 <label style="color:white;"> Quincy <input type="checkbox" class="form-control" name="Quincy" checked="yes"/></label><br>
				 <label style="color:white;"> Winthrop <input type="checkbox" class="form-control" name="Winthrop" checked="yes"/></label><br>
			</div>
			<h4 style="color: white;"> Enter number of weeks in season. </h4>
			<div class="form-group">
				<input type="number" class="form-control" name="gamesPerSeason" min="1" max="13" autocomplete="off">
			</div>
			<h4 style="color: white;"> Select the start week of the season. </h4>
			<div class = "form-group">
				<input class="form-control" type="text" id="popupDatepicker" class="is-pickdate" name="startDate" autocomplete="off" placeholder="Date">
			</div>
			<h4 style="color: white;"> Choose the days, times, and venues for the games. </h4>
			<div class="form-group">
			<?php for ($i = 0; $i < 6; $i++): ?>
				<label style="color:white; font-size: 18px;"><?= $i+1 ?>. </label>
				<select class="form-control" name=<?= "day" . ($i + 1)?> >
				<?php if ($i < 3): ?>
					<option value = "Monday" selected="selected">Monday</option>
					<option value = "Tuesday">Tuesday</option>
				<?php else: ?>
					<option value = "Monday">Monday</option>
					<option value = "Tuesday" selected="selected">Tuesday</option>
				<?php endif ?>
					<option value = "Wednesday">Wednesday</option>
					<option value = "Thursday">Thursday</option>
					<option value = "Friday">Friday</option>
					<option value = "Saturday">Saturday</option>
					<option value = "Sunday">Sunday</option>
				</select>
				<input class="timepicker form-control" id="time" name=<?= "time" . ($i + 1)?> autocomplete="off">
				<select class="form-control schedule " name=<?= "location" . ($i + 1)?>>
				<option value = "">Select Location</option>
                <?php
                    foreach($venues as $venue)
                    {
                        print("<option value = '{$venue}'>{$venue}</option>");
                    }
                ?>
				</select>
				<br>
			<?php endfor ?>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-default">Generate Schedule</button>
			</div>
		</fieldset>
	</div>
</form>
<div>
	or <a href="login.php">log in</a> 
</div>
