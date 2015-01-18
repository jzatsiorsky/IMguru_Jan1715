<nav class="navbar navbar-default cl-effect-1" role="navigation">
  <div class="container-fluid">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
		<li><a href="/">Home<span class="sr-only">(current)</span></a></li>
        <li><a href="#">Games</a></li>
        <li><a href="results.php">Results</a></li>
	<?php if ($_SESSION["captain"] == 1): ?>
		<li><a href="submit_result.php">Submit Result</a></li>
	<?php endif ?>
        <li><a href="standings.php">Straus Cup Standings</a></li>   
		<li><a href="huddle.php">The Huddle</a></li>  
      </ul>
      <ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="change_password.php">Change password</a></li>
            <li><a href="change_email.php">Change e-mail</a></li>
            <li class="divider"></li>
            <li><a href="become_captain.php">Become a Captain</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log out</a></li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
