<?php
require("php/Core.php");
Core::init();

if (UserManager::isAdminLogged()) Core::postRedirect("index.php");
if (isset($_GET["remove"])){
    BasketManager::removeFromBasket($_GET["remove"]);
    Core::postRedirect("basket_view.php");
}
if (isset($_POST["order"]) && !BasketManager::isEmpty()){
    if (OrderManager::order()){
        BasketManager::clearBasket();
        Core::postRedirect("transaction_success.php");
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
    <title>SNEAKERAN | Košík</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/Main.css">
    <link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(false,false);
    ?>
    <main>
        <h1 class="textcenter medium" style="font-size: 80px">Košík</h1>
        <div class="widget fullwidth">

            <?php if(BasketManager::isEmpty())
                echo '<div class="textcenter" style="font-size: 50px">Váš košík je prázdný!</div>' ?>

            <table class="fullwidth exclude-first">

                <?php
                if (!BasketManager::isEmpty()) echo '<tr>
                    <td colspan="2">Bota</td>
                    <td>Velikost</td>
                    <td>Cena</td>
                </tr>';
                $index = 0;
                foreach (BasketManager::basketData() as $item){
                    $sneaker = Db::queryAll("SELECT * FROM sneakers WHERE id=?",$item["id"])[0];
                    echo "
                        <tr>
                            <td><img class='product-preview' alt='' style='height: 100px' src=src/imgs/sneakers/$sneaker[imgpath]></td>
                            <td class='medium'>Air Jordan 1 $sneaker[name]</td>
                            <td>$item[size]</td>
                            <td>". FormatUtils::formatMoney($sneaker["price"]) ."</td>
                            <td><a href='basket_view.php?remove=$index'><img src='src/imgs/x.svg'></a></td>
                        </tr>
                        ";
                    $index++;
                }

                ?>
            </table>
            <form method="post" class="fullwidth grid-ctr">
                <input <?php if (BasketManager::isEmpty()) echo "disabled" ?> type="submit" name="order" value="Objednat ( <?php echo FormatUtils::formatMoney(BasketManager::basketTotalValue()) ?> )">
            </form>
            <?php


            ?>
        </div>
    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>