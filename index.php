<?php
require("php/Core.php");
Core::init();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SNEAKERAN | Hlavní stránka</title>
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/Main.css">
    <link rel="stylesheet" href="styles/Products.css">
	<link rel="icon" href="favicon.svg">
</head>
<body>
	<?php
        echo ComponentDrawer::drawNav(true,true);
    ?>
	<main>
		<section class="flex-center">
			<div class="disable-select">
				<img src="src/imgs/jordan.svg" height="300" alt="">
				<div class="nikee" style="font-size: 62px">SNEAKERAN</div>
			</div>
			<div style="margin-left: 3vw">
				<h1 class="bold" style="font-size: 55px">Největší sortiment Air Jordan 1 v ČR...</h1>
				<p style="font-size: 25px">
					Legendární spojení Michaela Jordana a Nike v roce 1984 odstartovalo novou éru sneaker kultury, když představili boty Air Jordan 1. Původně výhradní tenisky pro třiadvacítku se postupem času dostaly i mezi širokou veřejnost a v současnosti patří k nejpopulárnějším siluetám teniskových nadšenců.
				</p>
				<p style="font-size: 25px">
					V naší nabídce najdeš Air Jordan jedničky v mnoha siluetách.
				</p>
			</div>
		</section>
		<article class="fullwidth" id="products">
            <?php
                $unavailable = array();
                foreach(Db::queryAll("SELECT * FROM sneakers ORDER BY price") as $sneaker){
                    if (SneakersManager::isAvailable($sneaker["id"])) echo ComponentDrawer::drawProductCard($sneaker);
                    else $unavailable[] = $sneaker;
                }
                foreach ($unavailable as $sneaker){
                    echo ComponentDrawer::drawProductCard($sneaker);
                }

            ?>
		</article>
	</main>
	<footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
	<img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>