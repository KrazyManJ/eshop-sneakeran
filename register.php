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
	<title>SNEAKERAN | Registrace</title>
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/FormPage.css">
	<link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(true,false);
    ?>
	<main class="grid-ctr">
		<div>
			<h1 class="shadow-soft-text textcenter">Registrace</h1>
			<div class="grid-ctr">
				<div class="widget shadow-soft" style="width: 400px;height: fit-content">
					<form method="post" id="register" style="width: 100%">
                        <?php

                        if(isset($_POST["register"])){
                            if (UserManager::existsUser($_POST["username"])) $ERROR = "Tento uživatel již je zaregistrovaný!";
                            elseif (UserManager::existsEmail($_POST["email"])) $ERROR = "Uživatel s tímto emailem je již zaregistrovaný!";
                            elseif (UserManager::existsPhoneNumber($_POST["phonenumber"])) $ERROR = "Uživatel s tímto telefonním číslem je již zaregistrovaný!";
                            elseif ($_POST["password"] != $_POST["passwordcheck"]) $ERROR = "Hesla se neshodují!";
                            elseif (!preg_match("/\d{5}/",$_POST["postcode"])) $ERROR = "PSČ je napsáno ve špatném formátu!";
                            elseif (!isset($ERROR)){
                                UserManager::register(
                                    $_POST["username"],
                                    $_POST["firstname"],
                                    $_POST["lastname"],
                                    $_POST["password"],
                                    $_POST["email"],
                                    $_POST["phonenumber"],
                                    $_POST["street"],
                                    $_POST["streetnumber"],
                                    $_POST["city"],
                                    $_POST["postcode"]
                                );
                                Core::postRedirect("register_success.php");
                            }
                        }

                        ?>
						<div <?php echo isset($ERROR) ? "" : "hidden" ?> class="textcenter error-text" ><?php echo $ERROR ?? "" ?></div>

						<label for="username" class="light" >Uživatelské jméno</label>
						<input required id="username" name="username" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["username"] ?? "" ?> >

						<label for="email" class="light" >Email</label>
						<input required id="email" name="email" type="email" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["email"] ?? "" ?>>

                        <div class="fullwidth" style="display: grid; column-gap: 5% ; grid-template-columns: 47.5% 47.5%">
                            <div class="grid-ctr fullwidth">
                                <label for="firstname" class="light fullwidth textcenter">Jméno</label>
                                <input required id="firstname" name="firstname" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["firstname"] ?? "" ?>>
                            </div>
                            <div class="grid-ctr fullwidth">
                                <label for="lastname" class="light textcenter" >Příjmení</label>
                                <input required id="lastname" name="lastname" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["lastname"] ?? "" ?>>
                            </div>
                        </div>

                        <div class="fullwidth" style="display: grid; column-gap: 5% ; grid-template-columns: 47.5% 47.5%">
                            <div class="grid-ctr fullwidth">
                                <label for="password" class="light">Heslo</label>
                                <input required id="password" name="password" type="password" class="fullwidth textcenter shadow-soft">
                            </div>
                            <div class="grid-ctr fullwidth">
                                <label for="passwordcheck" class="light">Heslo znovu</label>
                                <input required id="passwordcheck" name="passwordcheck" type="password" class="fullwidth textcenter shadow-soft">
                            </div>
                        </div>

						<label for="phonenumber" class="light">Telefonní číslo</label>
						<input required id="phonenumber" name="phonenumber" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["phonenumber"] ?? "" ?>>

						<div class="fullwidth" style="display: grid; column-gap: 5% ; grid-template-columns: minmax(0%, 60%) 40%">
							<div class="grid-ctr fullwidth">
								<label for="street" class="light fullwidth textcenter">Ulice</label>
								<input required id="street" name="street" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["street"] ?? "" ?>>
							</div>
							<div class="grid-ctr fullwidth">
								<label for="streetnumber" class="light textcenter" style="font-size: 15px">Číslo popisné</label>
								<input required id="streetnumber" name="streetnumber" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["streetnumber"] ?? "" ?>>
							</div>
						</div>
						<div class="fullwidth" style="display: grid; column-gap: 5% ; grid-template-columns: minmax(0%, 70%) 30%">
							<div class="grid-ctr fullwidth">
								<label for="city" class="light fullwidth textcenter">Město</label>
								<input required id="city" name="city" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["city"] ?? "" ?>>
							</div>
							<div class="grid-ctr fullwidth">
								<label for="postcode" class="light textcenter">PSČ</label>
								<input required id="postcode" name="postcode" type="text" class="fullwidth textcenter shadow-soft" value=<?php echo $_POST["postcode"] ?? "" ?>>
							</div>
						</div>
						<div class="fullwidth">

						</div>

						<input type="submit" name="register" value="Registrovat se" class="shadow-soft pointer">
					</form>
				</div>
			</div>
		</div>
	</main>
	<footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
	<img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>