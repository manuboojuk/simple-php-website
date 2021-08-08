<?php 

	// for refilling fields
	if (!isset($_REQUEST['newUsername']))$_REQUEST['newUsername'] = $_SESSION['userInfo']['userid'];
	if (!isset($_REQUEST['newPassword']))$_REQUEST['newPassword'] = '';
	if (!isset($_REQUEST['newPassword2']))$_REQUEST['newPassword2'] = '';

	// for form resubmissions
	$_SESSION['token'] = md5(uniqid());
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<style>.ProfileNavLink{color: black; background-color: white;}</style>
		<title>Games</title>
	</head>
	<body>
		<header>
			<?php include 'navbar.php';?>
		</header>
		<main class='mainBody'>
			<section>
				<h1>Update Your Profile</h1>
				<p>Change the field you want to change and hit the corresponding submit button</p>
				<form action="index.php" method="post">
					<table>
						<tr>
							<td>
								Update username:  <input type="text" name="newUsername" value="<?php echo(htmlentities($_REQUEST['newUsername'])); ?>"/>
								<input type="submit" name="submit" value="Update Username">
							</td>
						</tr>
						<tr>
							<td>
								<!-- Dont Display password, even though it would be hidden its a security vulnerability-->
								Update password:  <input type="password" name="newPassword" value="<?php echo(htmlentities($_REQUEST['newPassword'])); ?>"/> 
							</td>
						</tr>
						<tr>
							<td>
								<!-- Dont Display password, even though it would be hidden its a security vulnerability-->
								Please re-enter your updated password:  <input type="password" name="newPassword2" value="<?php echo(htmlentities($_REQUEST['newPassword2'])); ?>"/>
								<input type="submit" name="submit" value="Update Password"/>
							</td>
						</tr>
						<tr>
							<td>
								Update your gender:   
								<input type="radio" name="newGender" value="Male" <?php if ($_SESSION['userInfo']['gender'] == 'Male') echo 'checked';?>/>Male
								<input type="radio" name="newGender" value="Female" <?php if ($_SESSION['userInfo']['gender'] == 'Female') echo 'checked';?>/>Female
								<input type="radio" name="newGender" value="Other" <?php if ($_SESSION['userInfo']['gender'] == 'Other') echo 'checked';?>/>Other
								<input type="submit" name="submit" value="Update Gender"/>
							</td>
						</tr>
						<tr>
							<td>
								Update your age (in years):
								<select name="newAge">
									<?php
										for ($i = 1; $i < 150; $i++) {
											if ($_SESSION['userInfo']['age'] == $i) {
												echo '<option value="' . $i . '" selected="selected">' . $i . '</option>'; 
											}
											else {
												echo '<option value="' . $i . '">' . $i . '</option>'; 
											}
										}   
									?>
									<input type="submit" name="submit" value="Update Age"/>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="newStudentStatus" <?php if ($_SESSION['userInfo']['uoftstudent'] == 't')echo 'checked';?>/> Are you a UofT student?
								<input type="submit" name="submit" value="Update UofT Student Status"/>
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="newPizzaPref" <?php if ($_SESSION['userInfo']['pizzapref'] == 't')echo 'checked';?>/> The most important question, do you like pineapples on pizza?
								<input type="submit" name="submit" value="Update Pizza Preference"/>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo(view_errors($errors)); ?>
								<?php echo($_SESSION['profileUpdates']); ?>
							</td>
						</tr>
					</table>
					<input type="hidden" name="token" value="<?php echo($_SESSION['token']); ?>"/>
				</form>	
			</section>
		</main>
		<footer>
			A project by ME
		</footer>
	</body>
</html>

