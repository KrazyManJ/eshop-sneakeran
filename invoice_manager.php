<?php
require("php/Core.php");
Core::init();

if (!UserManager::isAdminLogged()) Core::postRedirect("index.php");

if (isset($_GET["updatestatus"])){
    InvoicesManager::updateInvoiceStatus($_GET["updatestatus"]);
    Core::postRedirect("invoice_manager.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | Správce objednávek</title>
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
            <div class="shadow-soft-text fs-50 textcenter">Objednávky</div>
            <table class="fullwidth">
                <tr>
                    <td>ID</td>
                    <td>Uživ. Jméno</td>
                    <td>Datum</td>
                    <td>Celková cena</td>
                    <td>Status</td>
                    <td>Nástroje</td>
                </tr>
                <?php
                    foreach(Db::queryAll("SELECT * FROM invoices") as $invoice){
                        echo "<tr class='pointer' onclick='window.open(`invoice_view.php?invoice=$invoice[id]`,`_self`)'>";
                        echo "<td>$invoice[id]</td>";
                        echo "<td>".UserManager::getUsernameById($invoice["userid"])."</td>";
                        echo "<td>".FormatUtils::formatDate($invoice["date"])."</td>";
                        echo "<td>".FormatUtils::formatMoney(InvoicesManager::invoiceTotalPrice($invoice["id"]))."</td>";
                        echo "<td>".InvoicesManager::formatState($invoice["state"])."</td>";
                        echo "<td><a href='invoice_manager.php?updatestatus=$invoice[id]'><button class='shadow-soft'>Posunout status objednávky</button></a></td>";
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