<?php
require("php/Core.php");
Core::init();

if (!UserManager::isAdminLogged()) Core::postRedirect("index.php");

if (!isset($_GET["product"])) Core::postRedirect("product_manager.php");
if (!SneakersManager::isValidSneaker($_GET["product"])) Core::postRedirect("product_manager.php");

$sneakerid = $_GET["product"];


if (isset($_GET["size"])) {
    SneakersManager::removeSneakerSize($sneakerid,$_GET["size"]);
    Core::postRedirect("product_amount_manager.php?product=".$sneakerid);
}
if (isset($_POST["addsize"])) {
    SneakersManager::addSneakerSize($sneakerid,$_POST["size"],$_POST["amount"]);
    Core::postRedirect("product_amount_manager.php?product=".$sneakerid);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | Správce množství zboží</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/Main.css">
    <link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(false,false);
    ?>
    <main >
        <div class="widget shadow-soft" >
            <div class="fs-50 textcenter shadow-soft-text">Velikosti boty</div>
            <table class="fullwidth exclude-both">
                <tr>
                    <td><?php echo "ID: ".$sneakerid?></td>
                    <td><img alt="" class="product-preview" src="src/imgs/sneakers/<?php echo SneakersManager::getImageById($sneakerid)?>"></td>
                    <td><?php echo SneakersManager::getNameById($sneakerid)?></td>
                    <td><?php echo SneakersManager::getPriceById($sneakerid)?></td>
                </tr>
            </table>
            <table class="fullwidth exclude-first">
                <tr>
                    <td>Velikost boty</td>
                    <td>Počet kusů</td>
                    <td>Nástroje</td>
                </tr>
                <?php
                    foreach (SneakersManager::getAvailableSizes($sneakerid) as $size){
                        echo "<tr>";
                        echo "<td>$size</td>";
                        echo "<td>".SneakersManager::amount($sneakerid,$size)." Ks</td>";
                        echo "<td><a href='product_amount_manager.php?remove=$size'><img alt='' style='width: 20px' src='src/imgs/x.svg'></a></td>";
                        echo "</tr>";
                    }
                    if (sizeof(SneakersManager::getAvailableSizes($sneakerid)) == 0){
                        echo "<tr><td class='fs-40' colspan='3'>Zatím tu nejsou žádné velikosti!</td></tr>";
                    }
                ?>
            </table>
            <div class="textcenter fs-50 shadow-soft-text">Přidat novou velikost boty</div>
            <form method="post" style="display: flex; align-items: center; justify-content: space-between">
                <div>
                    <label for="size">Velikost boty</label>
                    <input required id=size type="number" name="size" min="20" max="60">
                </div>
                <div>
                    <label for="amount">Počet kusů</label>
                    <input required id="amount" type="number" name="amount" min="1">
                </div>

                <input type="submit" value="Vložit" name="addsize">
            </form>
        </div>
    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>