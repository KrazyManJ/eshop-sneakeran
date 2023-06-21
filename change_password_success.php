<?php
require("php/Core.php");
Core::init();

if (!UserManager::isLogged()) Core::postRedirect("index.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SNEAKERAN | Úspěšná registrace</title>
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
				<div class="widget shadow-soft" style="width: 400px;height: fit-content">
					<div id="success" style="margin: 80px 0">
						<img src="src/imgs/nikee/nike_green.svg" alt="" class="fullwidth" style="fill: green;">
						<div class="textcenter medium" style="font-size: 20px">Změna hesla proběhla úspěšně!</div>
						<div class="textcenter light" style="font-size: 20px">Nyní se můžete vrátit k nakupování!</div>
					</div>
					<div class="grid-ctr">
						<a href="login.php" class="pointer">
							<button class="pointer shadow-soft">Přejít do obchodu</button>
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