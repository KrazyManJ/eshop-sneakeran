<?php
require("php/Core.php");
Core::init();

if (!UserManager::isAdminLogged()) Core::postRedirect("index.php");

if (isset($_GET["remove"])){
    SneakersManager::removeSneaker($_GET["remove"]);
    Core::postRedirect("product_manager.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | Správce produktů</title>
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
            <div class="fs-50 textcenter shadow-soft-text">Zboží</div>
            <div class="grid-ctr" style="margin: 20px">
                <a href="product_creation.php"><button class="shadow-soft">Přidat produkt</button></a>
            </div>
            <table class="fullwidth exclude-first">
                <tr>
                    <td>ID</td>
                    <td colspan="2">Bota</td>
                    <td>Cena</td>
                    <td>Nástroje</td>
                </tr>
                <?php
                    foreach (SneakersManager::getAllSneakersData() as $sneaker){
                        echo "<tr>";
                        echo "<td>$sneaker[id]</td>";
                        echo "<td><img alt='' class='product-preview' src=src/imgs/sneakers/$sneaker[imgpath]></td>";
                        echo "<td>$sneaker[name]</td>";
                        echo "<td>".FormatUtils::formatMoney($sneaker["price"])."</td>";
                        echo "<td>
                                <a href='product_amount_manager.php?product=$sneaker[id]'><img alt='' style='width: 20px' src='src/imgs/box.svg'>
                                <a href='product_manager.php?remove=$sneaker[id]'><img alt='' style='width: 20px' src='src/imgs/x.svg'></a>
                            </td>";
                        echo "<td></a></td>";
                        echo "</tr>";
                    }

                ?>
            </table>
        </div>
    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>