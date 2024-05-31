<?php
	
	die("quit");

	// @idriskhrmn

	require_once("src/Api.php");

	$user = [
		'id' => 1,
		'parent' => 'ResellerAccountUserId',
		'name' => 'Idris',
		'surname' => 'Kahraman',
		'phone' => '05384848411',
		'email' => 'test@test.com',
		'password' => '123456'
	];

	$api = new \LiveGames\ClientApi\Api($user, '9ca1431b', 'c0557915b2a8bebe651891946bc8f33e');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>tombala</title>

	<!-- css -->
	<link rel="stylesheet" href="//ui.livegames.io/css/app.css">

</head>
<body>

	<?php print_r( $api ); ?>

	<script type="text/javascript">
	  (function(l,i,v,e,t,c,h){
	  l['LiveGamesObject']=t;l[t]=l[t]||function(){(l[t].q=l[t].q||[]).push(arguments)},
	  l[t].l=1*new Date();c=i.createElement(v),h=i.getElementsByTagName(v)[0];
	  c.async=1;c.src=e;h.parentNode.insertBefore(c,h)
	  })(window,document,'script','//embed.livegames.io/e-if.js','lg');
	  if(lg){
	      lg('sign', '<?php echo $api->token; ?>');
	      lg('currency', '₺');
	      lg('bgColor', '000');
	  }
	</script>
	<div id="liveGamesRoot"></div>

	<!-- script -->
	<script src="//embed.livegames.io/livegames.js"></script>

</body>
</html>