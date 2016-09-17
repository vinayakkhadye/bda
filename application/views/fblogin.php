<html>
	<head>
		<title>
			Login with Facebook | Puneet Kalra
		</title>
		
	</head>
	<body>


				<?php
				if(@$user_profile):  // call var_dump($user_profile) to view all data ?>
				<?php print_r($user_profile); ?>
				<img src="https://graph.facebook.com/<?=$user_profile['id']?>/picture?type=square" />
					<h2>
						<?=$user_profile['name']?>
					</h2>

					<a href="<?= $logout_url ?>" class="btn btn-lg btn-primary btn-block" role="button">
						Logout
					</a>
				<?php
				else: ?>
					<h2 class="form-signin-heading">
						Login with Facebook
					</h2>
					<a href="<?= $login_url ?>" class="btn btn-lg btn-primary btn-block" role="button">
						Login
					</a>
				<?php endif; ?>


	</body>
</html>