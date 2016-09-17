<html>
	<head>
		<title>
			Facebook Sweetness
		</title>
	</head>
	<body>
		<h1>
			Facebook stuff
		</h1>

		<?php echo print_r($user_profile); ?>
			
		<a href="<?= $logout_url ?>">Logout</a>


		<h2>
			Welcome, please login below
		</h2>
		<a href="<?= $login_url ?>">Login</a>

	</body>

</html>