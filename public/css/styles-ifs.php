<?php if (!empty($_SESSION["house"])): ?>
		<?php if ($_SESSION["house"] == "Adams"): ?>
			<link href="/css/styles-adams.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Cabot"): ?>
			<link href="/css/styles-cabot.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Currier"): ?>
			<link href="/css/styles-currier.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Dudley"): ?>
			<link href="/css/styles-dudley.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Dunster"): ?>
			<link href="/css/styles-dunster.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Eliot"): ?>
			<link href="/css/styles-eliot.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Kirkland"): ?>
			<link href="/css/styles-kirkland.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Leverett"): ?>
			<link href="/css/styles-leverett.css" rel="stylesheet"/>
		<?php elseif ($_SESSION["house"] == "Lowell"): ?>
			<link href="/css/styles-lowell.css" rel="stylesheet"/>
		<?php else: ?>
			<link href="/css/styles-default.css" rel="stylesheet"/>
		<?php endif ?>
	<?php else: ?>
		<link href="/css/styles-default.css" rel="stylesheet"/>
	<?php endif ?>
