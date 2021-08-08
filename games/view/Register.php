<?php
    $_REQUEST['regUsername']=!empty($_REQUEST['regUsername']) ? $_REQUEST['regUsername'] : '';
    $_REQUEST['regPassword']=!empty($_REQUEST['regPassword']) ? $_REQUEST['regPassword'] : '';
    $_REQUEST['regPassword2']=!empty($_REQUEST['regPassword2']) ? $_REQUEST['regPassword2'] : '';

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
        <title>registration</title>
	</head>

    <body>
        <main class="mainBody">
            <section>
                <h1>Registration</h1>
                <form action="index.php" method="post">
                    <input type="hidden" name="token" value="<?php echo($_SESSION['token']); ?>" />
                    <table>
                        <tr>
                            <td>
                                Choose a username:  <input type="text" name="regUsername" placeholder="Username" value="<?php echo(htmlentities($_REQUEST['regUsername'])); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Choose a password:  <input type="password" name="regPassword" placeholder="Password" value="<?php echo(htmlentities($_REQUEST['regPassword'])); ?>"> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Please re-enter your password:  <input type="password" name="regPassword2" placeholder="Re-enter Password" value="<?php echo(htmlentities($_REQUEST['regPassword2'])); ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Indicate your gender:   
                                <input type="radio" name="gender" value="male" <?php if (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'male')echo 'checked';?>>Male
                                <input type="radio" name="gender" value="female" <?php if (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'female')echo 'checked';?>>Female
                                <input type="radio" name="gender" value="other" <?php if (isset($_REQUEST['gender']) && $_REQUEST['gender'] == 'other')echo 'checked';?>>Other
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Indicate your age (in years):
                                <select name="age">
                                    <?php
                                        for ($i = 1; $i < 150; $i++) {
                                            if ((isset($_REQUEST['age']) && $_REQUEST['age'] == $i)) {
                                                echo '<option value="' . $i . '" selected="selected">' . $i . '</option>'; 
                                            }
                                            else {
                                                echo '<option value="' . $i . '">' . $i . '</option>'; 
                                            }
                                        }   
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" name="student" <?php if (isset($_REQUEST['student']))echo 'checked';?>> Are you a UofT student?
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" name="pizzaPref" <?php if (isset($_REQUEST['pizzaPref']))echo 'checked';?>> The most important question, do you like pineapples on pizza?
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="regSubmit" value="Register!">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo(view_errors($errors)); ?>
                            </td>
                        </tr>
                    </table>
                </form>
            </section>
        </main>
        <footer>
            A project by ME
        </footer>
    </body>
</html>