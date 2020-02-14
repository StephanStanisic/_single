<?php

global $Wcms;

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?= $Wcms->get('config', 'siteTitle') ?></title>
        <meta name="description" content="<?= $Wcms->page('description') ?>">
        <meta name="keywords" content="<?= $Wcms->page('keywords') ?>">

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

		<?php if($Wcms->loggedIn) { ?>
			<link rel="stylesheet" href="<?= $Wcms->asset('assets/css/adminPanel.bootstrap.min.css') ?>" />
			<link rel="stylesheet" href="<?= $Wcms->asset('assets/css/node-editor.bootstrap.min.css') ?>" />
			<link rel="stylesheet" href="<?= $Wcms->asset('assets/css/note-popover.bootstrap.min.css') ?>" />
		<?php } ?>
		<?= preg_replace('/<link rel="stylesheet" href="(.*?)\/bootstrap\.min\.css"(.*?)>/', "", $Wcms->css()); ?>
		<link rel="stylesheet" href="<?= $Wcms->asset('assets/css/style.css') ?>" />
	</head>
	<body class="is-preload">
        <?= $Wcms->alerts() ?>
        <?= $Wcms->settings() ?>

		<ul>
			<?php foreach ( $Wcms->db->config->menuItems as $id => $page ):
				if($page->visibility != "show") continue;?>
			<li><a href="<?=$Wcms->loggedIn?"":"#"?><?=$page->slug?>"><?=$page->name; ?></a></li>
			<?php endforeach; ?>
		</ul>

		<h1><?= $Wcms->get('config', 'siteTitle') ?></h1>

		<?= $Wcms->block('subside') ?>

		<?php
		if($Wcms->get('config', 'login') === $Wcms->currentPage) {
			$segments = (object)$this->loginView();
			echo <<<HTML
			<div class=\"page\" id=\"{$Wcms->currentPage}\">
				<h2 class=\"major\">Login</h2>
				{$segments->content}
			</div>
HTML;
		}
		?>

		<?php foreach ( $Wcms->db->pages as $pageName => $page ): ?>
			<!-- Page: <?=$page->title; ?> -->
			<div class="page" id="<?=$pageName?>">
				<h2 class="major"><?=$page->title; ?></h2>

				<?= getPageBlocks("content", $pageName) ?>
			</div>
		<?php endforeach; ?>

		<?= $Wcms->footer() ?>

		<script src="<?= $Wcms->asset('assets/js/jquery.min.js') ?>"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" type="text/javascript"></script>
		<?= $Wcms->js() ?>
	</body>
</html>
