<?php
require("php/Core.php");
Core::init();

if (!UserManager::isLogged()) Core::postRedirect("index.php");
if (UserManager::isAdminLogged()) Core::postRedirect("index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SNEAKERAN | Změna hesla</title>
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/FormPage.css">
	<link rel="icon" href="favicon.svg">
</head>
<body>

    <?php
        echo ComponentDrawer::drawNav(false,false);
    ?>
	<main class="grid-ctr">
		<div>
			<h1 class="shadow-soft-text textcenter">Změna hesla</h1>
			<div class="grid-ctr">
				<div class="widget shadow-soft" style="width: 300px;height: fit-content">
					<form method="post" id="login">
						<div
                            <?php

                            if (isset($_POST["change_password"])){
                                if ($_POST["newpassword"] == $_POST["newpasswordcheck"]) $ERROR = "Nové heslo se neshoduje s kontrolou!";
                                if (UserManager::changePassword($_POST["oldpassword"],$_POST["newpassword"])){
                                    Core::postRedirect("change_password_success.php");
                                }
                                else $ERROR = "Aktuální heslo je nesprávné!";
                            }
                            else echo "hidden";
                            ?>
                                class="textcenter error-text" ><?php echo $ERROR ?? "" ?></div>

						<label for="oldpassword" class="light">Aktuální heslo</label>
						<input required id="oldpassword" name="oldpassword" type="password" class="fullwidth textcenter shadow-soft">

                        <label for="newpassword" class="light">Nové heslo</label>
						<input required id="newpassword" name="newpassword" type="password" class="fullwidth textcenter shadow-soft">

                        <label for="newpasswordcheck" class="light">Zopakované nové heslo</label>
						<input required id="newpasswordcheck" name="newpasswordcheck" type="password" class="fullwidth textcenter shadow-soft">

						<input type="submit" name="change_password" value="Změnit heslo" class="shadow-soft pointer">
					</form>
				</div>
			</div>
		</div>
	</main>
	<footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
	<img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>