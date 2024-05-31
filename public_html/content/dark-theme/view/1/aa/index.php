<?php

$user = $_GET['user'];
$getUser = $_COOKIE['user'];
if (isset($user) and ($user != $getUser)) {
	setcookie("user", $user, time()+3600);
	header('Location: '.$_SERVER['REQUEST_URI']);
}

$module = $_GET["module"];
if (!$module) {
	$module = "index";
}

?>


<!DOCTYPE html>
<html lang="en" class="ab-page-<?=$module?>">

	<?php include "head.php"; ?>

	<body>
		<div id="page-wrapper" class="clearfix">

			<?php include "header.php"; ?>

			<div class="ab-wrapper ab-main">
				<?php if($module=='index') {
					include "home.php";
				} else {
					include "modules/".$module.".php";
				} ?>
			</div>

			<?php include "footer.php"; ?>
			<?php include "modals.php"; ?>

		</div>
		<?php include "includes/mobile-menu.php"; ?>
		<?php include "scripts.php"; ?>
	</body>

</html>
