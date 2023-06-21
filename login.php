<?php
require("php/Core.php");
Core::init();

if (UserManager::isLogged()) Core::postRedirect("index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SNEAKERAN | Přihlášení</title>
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/FormPage.css">
	<link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(false,true);
    ?>
	<main class="grid-ctr">
		<div>
			<h1 class="shadow-soft-text textcenter">Přihlašování</h1>
			<div class="grid-ctr">
				<div class="widget shadow-soft" style="width: 300px;height: fit-content">
					<form method="post" id="login">
						<div
                            <?php
                            if (isset($_POST["login"])){
                                if (UserManager::isLogged() || UserManager::login($_POST["username"],$_POST["password"])) {
                                    Core::postRedirect("index.php");
                                }
                            }
                            else echo "hidden";
                            ?>
                                class="textcenter error-text" >Zadal jste nesprávné přihlašovací údaje!</div>

						<label for="username" class="light" >Uživatelské jméno</label>
						<input required id="username" name="username" type="text" class="fullwidth textcenter shadow-soft" <?php echo isset($_POST["username"]) ? "value=$_POST[username]" : "" ?> >

						<label for="password" class="light">Heslo</label>
						<input required id="password" name="password" type="password" class="fullwidth textcenter shadow-soft">

						<input type="submit" name="login" value="Přihlásit se" class="shadow-soft pointer">
					</form>
				</div>
			</div>
		</div>
	</main>
	<footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
	<img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>