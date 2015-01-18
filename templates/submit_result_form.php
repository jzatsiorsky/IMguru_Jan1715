<!- Include navigation bar>
<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Submit a Result. </h1>
<form action="submit_result.php" method="post">
    <fieldset>
	<div class="boxed">
		    <div class="form-group">
			<p class="result_score"> Game: </p>
			<select id="chooseGame" name="gameid" class="form-control">
				<option value="">Select game</option>
				<?php foreach ($games as $game): ?>
				<option value="<?= $game["gameid"] ?>"> <?= date_format(date_create($game["date"]),"m/d") . " " . $game["sport"] . ", " . $game["team1"] . " vs. " . $game["team2"] ?></option>
				<?php endforeach ?>
			</select>
		    </div>

		    <div class="game-details">

		    <p class="result_score">Forfeit? </p>
		    <div class="btn-group btn-group-justified" role="group" aria-label="..." style="width:50%; margin:0 auto;">
			  <div class="btn-group" role="group">
			    <button id="forfeit_yes" type="button" class="btn btn-default">Yes</button>
			  </div>
			  <div class="btn-group" role="group">
			    <button id="forfeit_no" type="button" class="btn btn-default active">No</button>
			  </div>
			</div>
			<br>

			<!-- This is the content that is toggled based on forfeit/nonforfeit -->
			<div class="toggle-content">
			</div>

			</div>

		</div>
    </fieldset>
</form>
<div>
    or <a href="index.php">go back</a> 
</div>

<script>
	var scoresHTML;
	var forfeitHTML;


	// on load, show the scores HTML
	$(document).ready(function() {
		$("div.toggle-content").html(scoresHTML);
		$("div.game-details").hide();
	});

	$("#forfeit_yes").click(function() {
		$(this).attr('class', 'btn btn-default active');
		$("#forfeit_no").attr('class', 'btn btn-default');
		$("div.toggle-content").html(forfeitHTML);
	});

	$("#forfeit_no").click(function() {
		$(this).attr('class', 'btn btn-default active');
		$("#forfeit_yes").attr('class', 'btn btn-default');
		$("div.toggle-content").html(scoresHTML);
	});

	$("#chooseGame").change(function() {
		if ($(this).val() != "") {
			$("div.game-details").show();

			// this is the text of the option
			var text = $("#chooseGame option:selected").text();
			
			// split the text at the comma-space
			var splitText = text.split(", ");

			var teams = splitText[1];

			var splitTeams = teams.split(" vs. ");
			var team1 = splitTeams[0];
			var team2 = splitTeams[1];

			scoresHTML = '<div class="form-group">' + 
				'<p class="result_score">' + team1 + ' Score: </p>' + 
				'<input type="number" name="team1score" min="0" max="200" autocomplete="off" value="">' + 
			    '</div>' + 
			    '<div class ="form-group">' + 
				'<p class="result_score">' + team2 + ' Score: </p>' + 
				'<input type="number" name="team2score" min="0" max="200" autocomplete="off" value="">' + 
			    '</div>' + 
			    '<div class="form-group">' + 
			        '<button type="submit" class="btn btn-default">Submit Result</button>' + 
			    '</div>';

			forfeitHTML = '<p class="result_score"> Who forfeited? </p>' +
				'<div class="form-group">' +
	   				'<div class="radio">' +
	    				'<label style="color: white;">' + 
	      					'<input id="radio1" type="radio" name="forfeit" value="team1forfeit">' + team1 +
	   					'</label>' +
	    				'<label style="padding-left: 50px; color: white;">' + 
	      					'<input id="radio2" type="radio" name="forfeit" value="team2forfeit">' + team2 +
	   					'</label>' +
	   					'<label style="padding-left: 50px; color: white;">' + 
	      					'<input id="radio3" type="radio" name="forfeit" value="both"> Both' +
	   					'</label>' +
	   				'</div>' + 
  				'</div>' +
			    '<div class="form-group">' + 
			        '<button type="submit" class="btn btn-default">Submit Result</button>' + 
			    '</div>';

			updateText();


		}
		else {
			$("div.game-details").hide();
		}
	});

	function updateText() {
		// change scores is no_forfeit button is active
		if ($("#forfeit_no").attr('class') == "btn btn-default active") {
			$("div.toggle-content").html(scoresHTML);
		}
		else {
			$("div.toggle-content").html(forfeitHTML);
		}

	}

	/*

	$("form").submit(function() {
		if ($("#radio1").attr("checked") == undefined && $("#radio2").attr("checked") == undefined && $("#radio3").attr("checked") == undefined && $(["name='team1score'"]).val() == "" && $(["name='team2score'"]).val() == "" ){
			alert("Please select an option!");
			return false;
		}
		
		alert("hi");

		
	});
*/

</script>
