
<div style="text-align:right;">
    <a href = "/manage_account.php"><img id="profile_pic" style="border-radius: 25px; margin-bottom: 5px;"/></a>
	<span id="welcome" style="clear: both;">Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!</span>
</div>

<?php if ($_SESSION["ref"] == 0): ?>

	<!-- From the bootstrap documentation -->
	<!--
	<div class="round">
		<section class="color-3">
			<nav class="cl-effect-8">
				<a href="/">Home</a>
				<a href="games.php">Games</a>
			<?php if ($_SESSION["captain"] == 1): ?> 
				<a href="schedule_game.php">Schedule Game</a>
			<?php endif ?>
				<a href="/results.php">Results</a>
			<?php if ($_SESSION["captain"] == 1): ?>
				<a href="submit_result.php">Submit Result</a>
			<?php endif ?>
				<a href="standings.php">Straus Cup Standings</a>
				<a href="huddle.php">The Huddle</a>
				<a href="manage_account.php">Manage Account</a>
				<a href="logout.php">Log out</a>
			</nav>
		</section>
	</div>
	-->

<nav class="navbar navbar-default">
  	<div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="results.php">Results</a></li>
        <li><a href="standings.php">Standings</a></li>
        <li><a href="huddle.php">Huddle</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Captain Actions<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="schedule_game.php">Schedule Game</a></li>
            <li><a href="submit_result.php">Submit Result</a></li>
            <li><a href="captain_email.php">E-mail Players</a></li>
          </ul>
        </li>
        </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php if ($_SESSION["dual"] == 1): ?>
    	<li><a href="dual.php">Switch Account</a></li>
    <?php endif ?>
    	<li><a href="manage_account.php">Account Management</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
    </div>
  </div>
</nav>

<?php else: ?>
<!-- From the bootstrap documentation -->
<nav class="navbar navbar-default">
  	<div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="results.php">Results</a></li>
        <li><a href="standings.php">Standings</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Referee Actions<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="schedule_game.php">Schedule Game</a></li>
            <li><a href="submit_result.php">Submit Result</a></li>
            <li><a href="announcement.php">Make Announcement</a></li>
            <li><a href="create_schedule.php">Generate Schedule</a></li>
          </ul>
        </li>
        </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php if ($_SESSION["dual"] == 1): ?>
    	<li><a href="dual.php">Switch Account</a></li>
    <?php endif ?>
    	<li><a href="manage_account.php">Account Management</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
    </div>
  </div>
</nav>

<?php endif ?>
<br>

<script>

$(document).ready(function() {
    var photo = "<?= $_SESSION['photo'] ?>";
    console.log(photo);

    var smallPic = photo.split("200x200")[0];
    smallPic += "50x50/";

    $("#profile_pic").attr('src', smallPic);
});

function changePicture(url) {
    var smallPic = url.split("200x200")[0];
    smallPic += "50x50/";
    $("#profile_pic").attr('src', smallPic);
}

</script>

