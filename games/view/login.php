<?php
	// So I don't have to deal with unset $_REQUEST['user'] when refilling the form
	$_REQUEST['user']=!empty($_REQUEST['user']) ? $_REQUEST['user'] : '';
	$_REQUEST['password']=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';

	// for form resubmissions
	if (!isset($_SESSION['token'])) {
		$_SESSION['token'] = md5(uniqid());
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games</title>
	</head>
	<body>
		<header>
			<nav>
				<ul>
				</ul>
			</nav>
		</header>
		<main>
			<section>
				<hr>
				<h1>Games</h1>
				<form action="index.php" method="post">
					<input type="hidden" name="token" value="<?php echo($_SESSION['token']); ?>" />
					<legend>Login</legend>
					<table>
						<!-- Trick below to re-fill the user form field -->
						<tr><th><label for="user">User</label></th><td><input type="text" name="user" value="<?php echo(htmlentities($_REQUEST['user'])); ?>" /></td></tr>
						<tr><th><label for="password">Password</label></th><td> <input type="password" name="password" /></td></tr>
						<tr><th>&nbsp;</th><td><input type="submit" name="submit" value="login" /></td></tr>
						<tr><th>&nbsp;</th><td><?php echo(view_errors($errors)); ?></td></tr>
					</table>
				</form>
				<a href="?operation=register">Register</a>
			</section>
			<section>
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

