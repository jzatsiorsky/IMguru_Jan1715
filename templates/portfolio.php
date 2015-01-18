<!- Include navigation bar>
<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Home </h1>

<!- Print out the ten most recent game results for the scores ticker>
<h4>Recent results from around the league.</h4>
<div class=" container-fluid" id="ticker" style="min-width: 1000px;">
	<!- For loop to print out most recent results first >
	<?php for ($length = count($results), $i = $length - 1; $i >= 0; $i--): ?>
	<?php
		if ((int) $results[$i]["team1score"] > (int) $results[$i]["team2score"])
		{
			$team1 = "<b>" . $results[$i]["team1"] . "</b>";
			$team2 = $results[$i]["team2"];
			$score1 = "<b>" . $results[$i]["team1score"] . "</b>";
			$score2 = $results[$i]["team2score"];
		}
		// team 2 beat team 1
		else if((int) $results[$i]["team1score"] < (int) $results[$i]["team2score"])
		{
			$team1 = $results[$i]["team1"];
			$team2 = "<b>" . $results[$i]["team2"] . "</b>";
			$score1 = $results[$i]["team1score"];
			$score2 = "<b>" . $results[$i]["team2score"] . "</b>";
		}
		// in case of tie
		else
		{
			$team1 = $results[$i]["team1"];
			$team2 = $results[$i]["team2"];
			$score1 = $results[$i]["team1score"];
			$score2 = $results[$i]["team2score"];
		}
	?>
			
	<div class="ticker">
		<p class="ticker_sport"> <?= $results[$i]["sport"] ?></p>
		<hr class="ticker_break">
		<p class="ticker_team">  <?= $team1 ?><span class="ticker_score"> <?= $score1 ?></span></p>
		<p class="ticker_team"> <?= $team2 ?><span class="ticker_score"> <?= $score2 ?></span></p>
	</div>

	<?php endfor ?>

</div>

<br>


<?php if ($_SESSION["ref"] == 0): ?>
	<!-- Print out the announcements -->
	<div class="popout" style="visibility: hidden;" id="popout_announcements">
		<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Message</th>
			</tr>
		</thead>
		<?php foreach ($announcements as $announcement): ?>
			<?php 
				$date = date_create($announcement["time"]);
				$date = date_format($date, "M jS"); 
			?>
			<tr><td> <?= $date ?></td><td> <?= $announcement["announcementtext"] ?> </td></tr>
		<?php endforeach ?>
		</table>
	</div>

<?php if (count($announcements) != 0): ?>
	<div id="announcements">
		<h3 style="color: black;">Announcements</h3>
		<button id ="popout_button" class="button" onclick="showPopOut();" style="margin-right:20px;">View</button> <button id ="delete_announcements" class="button">Delete</button>
	</div>
<?php endif ?>
	
	
<?php endif ?>

<div id="tablebody">
<div>
	<h3>Your upcoming games</h3>
</div>

<?php if (count($rows) != 0): ?>
<div id="clearDiv">
	<button id ="clear_schedule_button" class="button" onclick="clearSchedule();" style="width: 150px;">Clear My Games</button>
</div>

<br><br>
<?php endif ?>

<?php if (empty($rows)): ?>
	<h4><a href="/games.php" class="link">Click here</a> to sign up for games. </h4>		
<?php else: ?>

<div class="container-fluid" style="overflow-x: hidden;">
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Sport</th>
            <?php if ($_SESSION["ref"] == 0): ?>
                <th>Opponent</th>
            <?php else: ?>
            	<th>Team 1</th>
            	<th>Team 2</th>
           	<?php endif ?>
                <th>Time</th>
                <th>Location</th>
            </tr>
        </thead>
        
        
			
			
			    <?php foreach ($rows as $row): ?>

				<!- determine the opponent >
				<?php 
				if ($_SESSION["ref"] == 0) {
					if ($row["team1"] == $_SESSION["house"])
						$opponent = $row["team2"];
					else
						$opponent = $row["team1"];
				}
				?>

				

			    <tr class="home" url="/game_page.php?gameid=<?= $row["gameid"] ?>">
			        <td><?= date_format(date_create($row["date"]), "D m/d") ?></td>
			        <td><?= $row["sport"] ?></td>
			    <?php if ($_SESSION["ref"] == 0): ?>
			        <td><?= $opponent ?></td>
			    <?php else: ?>
			    	<td><?= $row["team1"] ?></td>
			    	<td><?= $row["team2"] ?></td>
			    <?php endif ?>
			        <td><?= date_format(date_create($row["time"]), "g:i a") ?></td>
			        <td><?= $row["location"] ?></td>
			    </tr>

			    
			    <?php endforeach ?>
		
	    		</table>
			<?php endif ?>
		</div>

<script>
// http://stackoverflow.com/questions/1460958/html-table-row-like-a-link
	

	$('body').on('mousedown', 'tr[url]', function(e){
	    var click = e.which;
	    var url = $(this).attr('url');
	    if(url){
	        if(click == 1){
	            window.location.href = url;
	        }
	        else if(click == 2){
	            window.open(url, '_blank');
	            window.focus();
	        }
	        return true;
	    }
	});
	<?php if ($_SESSION["ref"] == 0): ?>
		function showPopOut() {
			var button = document.getElementById('popout_button');
			document.getElementById('popout_announcements').style.visibility = "visible";
			button.innerHTML = "Close";
			button.removeEventListener("click", showPopOut);
			button.addEventListener("click", closePopOut);
		}

		function closePopOut() {
			var button = document.getElementById('popout_button');
			document.getElementById('popout_announcements').style.visibility = "hidden";
			button.innerHTML = "View";
			button.removeEventListener("click", closePopOut);
			button.addEventListener("click", showPopOut);
		}
	<?php endif ?>

	// button to clear myGames is pressed
	function clearSchedule() {
		var confirmHTML = '<span>Are you sure?</span>' +
		'<button class="button" style="margin-right:10px; margin-left: 10px;" id="yesClear" onclick="yesClear();">Yes</button>' + 
		'<button class="button" id="noClear" onclick="noClear();">No</button>'; 

		$("#clearDiv").html(confirmHTML);
    }

    function yesClear() {

    	$.ajax({
	        url: 'clear_schedule.php',
	        method: 'GET',
	        async: true
    	});
    	var html = '<br><h3><a href="/games.php" class="link">Click here</a> to sign up for games.</h3>';
    	$("#tablebody").html(html);
    }

    function noClear() {
    	var html = '<button id ="clear_schedule_button" class="button" onclick="clearSchedule();" style="width: 150px;">Clear My Games</button>';
    	$("#clearDiv").html(html);
    }

    $("#delete_announcements").click(function() {
    	closePopOut();
    	$.ajax({
	        url: 'clear_announcements.php',
	        method: 'GET',
	        async: true
    	});
    	$("#announcements").hide();
    	// delete
    });

    $("#button").click(function() {
    	showPopOut();
    });

			
		

</script>


