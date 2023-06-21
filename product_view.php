<?php
require("php/Core.php");
Core::init();

if (!isset($_GET["product"])) Core::postRedirect("index.php");

if (isset($_POST["addtobasket"])){
    BasketManager::addToBasket($_GET["product"],$_POST["size"]);
    Core::postRedirect("addtobasket_success.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | <?php echo "Air Jordan 1 ".SneakersManager::getNameById($_GET["product"]) ?> </title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/Main.css">
    <link rel="stylesheet" href="styles/ProductView.css">
    <link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(true,true);

        $productid = $_GET["product"];
    ?>

    <main class="grid-ctr">
        <div class="widget shadow-soft" id="product-content">
            <img src="<?php echo "src/imgs/sneakers/".SneakersManager::getImageById($_GET["product"]) ?>" class="fullwidth" alt="">
            <div id="product-info" style="display: grid;grid-template-rows: 60% 40%">
                <div style="overflow: hidden;">
                    <div class="textcenter">Air Jordan 1</div>
                    <h1 class="textcenter" style="font-size: 40px" ><?php echo SneakersManager::getNameById($_GET["product"]) ?></h1>
                    <div class="light textjustify fs-20" style="margin: 20px"><?php echo SneakersManager::getDescriptionById($_GET["product"]) ?></div>
                </div>

                <<?php echo UserManager::isLogged() || !UserManager::isAdminLogged() ? 'form method="post"' : "div"; ?> class="grid-ctr">
                    <div style="font-size: 30px" ><?php echo SneakersManager::getPriceById($_GET["product"]) ?></div>
                    <label for="size"></label>
                    <select id="size" <?php echo UserManager::isLogged() ? "required" : "" ?> name="size">-->
                        <option disabled selected value> Vyber velikost </option>
                        <?php
                            foreach (SneakersManager::getAvailableSizes($_GET["product"]) as $size){
                                echo "<option>$size</option>";
                            }
                        ?>
                    </select>
                    <?php
                    if (!UserManager::isLogged())
                        echo '<a href="login.php?" class="shadow-soft"><button class="pointer">Přihlásit se</button></a>';
                    elseif(!SneakersManager::isAvailable($_GET["product"]))
                        echo '<button class="pointer">Není skladem!</button>';
                    elseif(UserManager::isAdminLogged())
                        echo '<button class="pointer">Jako administrátor nemůžeš nakupovat!</button>';
                    else echo '<input class="pointer shadow-soft" type="submit" name="addtobasket" value="Přidat do košíku" >';

                    ?>
                </<?php echo UserManager::isLogged() ? 'form' : "div"; ?>>

        </div>
    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>