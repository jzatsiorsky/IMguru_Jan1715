<head>
	<script src="/js/jquery-2.1.1.js"></script> 
    <script src="/js/scripts.js"></script> 
</head>
<!-- Include navigation bar-->
<?php include 'navigation.php';?>
<body>
	<h1> Change your sign-up preferences for each intramural sport.</h1>
		<?php if (empty($rosters) && empty($lists)): ?>
		<h4> You are currently signed up for no intramural sports. </h4>
	<?php endif ?>
	<?php if (!empty($rosters)): ?>
		<h4> You are currently signed up to receive all emails and to be placed on all rosters for
			<?php for($i = 0, $n = count($rosters); $i < $n; $i++)
			{
				if ($n != 1)
				{
					if ($i != ($n-1))
					{
						print("<b>{$rosters[$i]}</b>, ");
					}
					else
					{
						print("and <b>{$rosters[$i]}</b>.");
					}
				}
				else
				{
					print ("<b>{$rosters[$i]}</b>.");
				}
			} ?>
	<?php endif ?>
	<?php if (!empty($lists)): ?>
		<h4> You are currently signed up for the email list for 
			<?php for($i = 0, $n = count($lists); $i < $n; $i++)
			{
				if ($n != 1)
				{
					if ($i != ($n-1))
					{
						print("<b>{$lists[$i]}</b>, ");
					}
					else
					{
						print("and <b>{$lists[$i]}</b>.");
					}
				}
				else
				{
					print ("<b>{$lists[$i]}</b>.");
				}
			} ?>
	<?php endif ?>
	<p><p>
	<form action="league_signup.php" method="post">
		<div class="boxed" style="width: 80%;">
			<fieldset>
				<h2 style="margin:0 0 20px 0; color:white">You can choose to be signed up for every game of a particular sport,
				or only to be added to that sport's email list.</h2>
				<div class="form-group">
					<h3 style="margin:0 0 20px 0; color:white"> Choose a season of sports to update your league preferences </h3>
					<select class="form-control" id="season">
						<option value="">Choose a season</option>
						<option value="fall">Fall Sports</option>
						<option value="winter">Winter Sports</option>
						<option value="spring">Spring Sports</option>
					</select>
					<p><p><p>
					<div id="signups">
						
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default">Update your sign-up preferences!</button>
				</div>
			</fieldset>
		</div>
	</form>
</body>
<script>
	function signupform(league) {
		parameters = {
			season: league
		}
		var search = $.getJSON("search_signups.php", parameters);
		search.fail (function() {
			alert("Failed to access database. Please contact Sam Green at samuelgreen@college.harvard.edu");
		});
		search.done (function(data) {
			var buttons = "";
			for (var i = 0, length = data.length; i < length; i++) {
				buttons += "<h4 style='color:white'>" + data[i].sport + "</h4>";
				buttons += "<div class='btn-group' role='group' aria-label='...'>";
				if (data[i].pref == "none") {
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default active'>None</button>";
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default'>Just Emails</button>";
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default'>Emails and Game</button></div><br><br>";
				}
				else if (data[i].pref == "email") {
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default'>None</button>";
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default active'>Just Emails</button>";
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default'>Emails and Game</button></div><br><br>";
				}
				else if (data[i].pref == "all") {
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default'>None</button>";
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default'>Just Emails</button>";
					buttons += "<button id='" + data[i].sport + "' type='button' class='btn btn-default active'>Emails and Game</button></div><br><br>";
				}
			}
			//document.getElementById("signups").innerHTML = buttons;
			$("#signups").html(buttons);
		});
	}
	$(document).ready( function() {
		$("#season").change( function() {
			var season = $("select option:selected").val();
			signupform(season);
			$(".btn").click(function () {
				alert("click!");
			});
		});
		});
</script>