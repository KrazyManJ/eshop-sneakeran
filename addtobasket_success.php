<?php
require("php/Core.php");
Core::init();

if (UserManager::isAdminLogged()) Core::postRedirect("index.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SNEAKERAN | Úspěšná transakce</title>
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
			<div class="grid-ctr">
				<div class="widget shadow-soft" style="width: 400px;height: fit-content">
					<div id="success" style="margin: 80px 0">
						<img src="src/imgs/nikee/nike_green.svg" alt="" class="fullwidth" style="fill: green;">
						<div class="textcenter medium" style="font-size: 20px">Úspěšně jsi přidal zboží do košíku!</div>
					</div>
					<div class="grid-ctr">
						<a style="margin-bottom: 10px" href="index.php" class="pointer">
							<button class="pointer shadow-soft">Zpět do obchodu</button>
						</a>
                        <a href="basket_view.php" class="pointer">
							<button class="pointer shadow-soft">Přejít ke košíku</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</main>
	<footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
	<img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>