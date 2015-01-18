<!DOCTYPE html>

<html>
    <head>
	    <script>
			UPLOADCARE_LOCALE = "en";
			UPLOADCARE_TABS = "facebook";
			UPLOADCARE_AUTOSTORE = true;
			UPLOADCARE_PUBLIC_KEY = "5160facbc560cda93ca3";
		</script>
		<script src="https://ucarecdn.com/widget/1.5.3/uploadcare/uploadcare.full.min.js" charset="utf-8"></script>
		
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        
	<!-- Includes for creative links - tympanus.net-->
	<link rel="stylesheet" type="text/css" href="css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/demo.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<script src="js/modernizr.custom.js"></script>

	<!-- General style sheet -->
	<link href="/css/styles-default.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>IMguru: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>IMguru</title>
        <?php endif ?>

        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>
    <link rel="shortcut icon" href="/img/favicon.ico" />

    <!-- for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Facebook Like button -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
    </head>

    <body>
        <div class="container">

            <div id="top">	
			<?php if (isset($_SESSION["house"]))
				{
					if ($_SESSION["house"] == "Adams")
						$link = "http://adamshouse.harvard.edu";
					else if ($_SESSION["house"] == "Winthrop")
						$link = "http://winthrophouse.net";
					else
						$link = "http://" . $_SESSION["house"] . ".harvard.edu";
				}
			?>
			
			<!-- If logged in -->
			<?php if (isset($_SESSION["id"])): ?>
			<?php if ($_SESSION["ref"] == 0): ?>
			<div>
				<a href="/">
					<img alt="Guru" src="/img/logo_text1.gif" class="logo"/>
				</a>
				<a href = <?= $link ?> >
					<img alt="Shield" id="shield2" src="/img/<?= htmlspecialchars(strtolower($_SESSION["house"])) ?>_shield.jpg"/>
				</a>
				<h1 class="title"><?= htmlspecialchars($_SESSION["house"]) ?> House Intramurals</h1>
			</div>


			<?php else: ?>
			<div class="container-fluid">
				<a href="/"><img alt="Guru" src="/img/logo_text1.gif" class="logo-login"/></a>
			</div>
			<?php endif ?>

			<?php else: ?>
			<div class="container-fluid">
				<a href="/"><img alt="Guru" src="/img/logo_text1.gif" class="logo-login"/></a>
			</div>

			<?php endif ?>

            </div>

            <div id="middle">

