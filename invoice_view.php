<?php
require("php/Core.php");
Core::init();

if (!UserManager::isLogged()) Core::postRedirect("index.php");
if (!isset($_GET["invoice"])) Core::postRedirect("index.php");

$invoiceid = $_GET["invoice"];

if (!UserManager::isAdminLogged()) {
    if (!InvoicesManager::doesLoggedUserOwnsInvoice($invoiceid)) {
        Core::postRedirect("index.php");
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | Objednávka číslo <?php echo $invoiceid ?></title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/Main.css">
    <link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(false,false);
    ?>
    <main>
        <div class="widget">
            <div class="textcenter medium fs-50">Objednávka číslo <?php echo $invoiceid ?></div>
            <?php

                $data = InvoicesManager::getInvoiceData($invoiceid);
                echo "
                    <div class='textcenter' style='margin: 30px 0; font-size: 30px'>
                        <div>Objednáno uživatelem: ".UserManager::getUsernameById($data["userid"])."</div>
                        <div>Objednáno: ".FormatUtils::formatDate($data["date"])."</div>
                        <div>Stav objednávky: ".InvoicesManager::formatState($data["state"])."</div>
                    </div>
                    
                ";

            ?>
            <div class="fs-50 textcenter">Zakoupené zboží</div>
            <table class="fullwidth exclude-first">
                <tr>
                    <td class="medium" colspan="2">Bota</td>
                    <td class="medium">Velikost</td>
                    <td class="medium">Cena</td>
                </tr>
            <?php
                foreach(InvoicesManager::getInvoiceSneakers($invoiceid) as $item){
                    $sneaker = SneakersManager::getSneakerInfo($item["idsneaker"]);
                    echo "<tr>
                        <td><img class='product-preview' alt='' src=src/imgs/sneakers/$sneaker[imgpath]></td>
                        <td class=medium>Air Jordan 1 $sneaker[name]</td>
                        <td>$item[size]</td>
                        <td>". FormatUtils::formatMoney($sneaker["price"]) ."</td>
                    </tr>";
                }
            ?>
            </table>
            <div style="text-align: right" class="medium fs-50"><?php echo FormatUtils::formatMoney(InvoicesManager::invoiceTotalPrice($invoiceid)) ?></div>
        </div>
    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>