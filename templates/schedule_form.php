<?php include 'navigation.php';?>
<head>
    <script src="/js/jquery-2.1.1.js"></script> 
    <script src="/js/scripts.js"></script> 

	<!-- http://keith-wood.name/datepick.HTML -->
	<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css"> 
	<script type="text/javascript" src="js/jquery.plugin.js"></script> 
	<script type="text/javascript" src="js/jquery.datepick.js"></script>
	<script>
		$(function() {
			$('#popupDatepicker').datepick();
		});
	</script>

	<!-- http://timepicker.co/ -->
	<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css"> 
	<script type="text/javascript" src="js/jquery.timepicker.js"></script>
	
	<script>
	$(document).ready(function(){
		$('input.timepicker').timepicker({minHour: 10, maxHour: 22, dynamic: false});
	});
	</script>

</head>
<?php if ($_SESSION["ref"] == 0): ?>
<h1 style="margin:0 0 20px 0;"> Schedule a new game for <?=$_SESSION["house"]?> </h1>
<?php else: ?>
<h1 style="margin:0 0 20px 0;"> Schedule a new game </h1>
<?php endif ?>
<form action="schedule_game.php" method="post">
    <div class = "boxed">
        <fieldset>
            <div class = "form-group" style="clear:both;">
                <select class = "form-control" name = "sport">
                <option value = "" >Select sport</option>
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
                <option value = "Squash">Squash</option>
                <option value = "Tennis">Tennis</option>
                <option value = "A Volleyball">A Volleyball</option>
                <option value = "B Volleyball">B Volleyball</option>
                <option value = "Special Event">Special Event</option>
                </select>
            </div>
        <?php if ($_SESSION["ref"] == 0): ?>
            <div class= "form-group" style="clear:both;">
				<select class="form-control" name="opponent">
				<option value = "">Select Your Opponent </option>
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
		<?php else: ?>
			<div class= "form-group" style="clear:both;">
				<select class="form-control" name="team1">
				<option value = "">Team 1 </option>
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
			<div class= "form-group" style="clear:both;">
				<select class="form-control" name="team2">
				<option value = "">Team 2 </option>
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
		<?php endif ?>
            <div class = "form-group">
				<input class="form-control" type="text" id="popupDatepicker" class="is-pickdate" name="date" autocomplete="off" placeholder="Date">
			</div>
           <div class="form-group">
				<input class="timepicker form-control" id="time" name="time" autocomplete="off" placeholder="Time">
			</div>
            <div class="form-group" style="clear:both;">
				<select class="form-control schedule " name="location">
				<option value = "">Select Location</option>
                <?php
                    foreach($venues as $venue)
                    {
                        print("<option value = '{$venue}'>{$venue}</option>");
                    }
                ?>
				</select>
			</div>
			<div class="form-group">
			<input class="form-control schedule" name="location_details" placeholder="Location Details" type="text">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-default">Schedule game</button>
			</div>
        </fieldset>
    </div>
</form>
