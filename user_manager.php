<?php
require("php/Core.php");
Core::init();

if (!UserManager::isAdminLogged()) Core::postRedirect("index.php");

if (isset($_GET["promote"])){
    UserManager::promoteToAdmin($_GET["promote"]);
    Core::postRedirect("user_manager.php");
}
if (isset($_GET["demote"])){
    UserManager::demoteToAdmin($_GET["demote"]);
    Core::postRedirect("user_manager.php");
}
if (isset($_GET["removeuser"])) {
    UserManager::unregister($_GET["removeuser"]);
    Core::postRedirect("user_manager.php");
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | Správce uživatelů</title>
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
            <div class="fs-50 textcenter shadow-soft-text">Uživatelé</div>
            <table class="fullwidth">
                <tr>
                    <td>ID</td>
                    <td>Uživ. Jméno</td>
                    <td>Email</td>
                    <td>Tel. Číslo</td>
                    <td>Adresa</td>
                    <td>Je adminem?</td>
                </tr>
                <?php
                    foreach(Db::queryAll("SELECT * FROM users") as $user){
                        echo "<tr>";
                        foreach (["id","username","email","phonenumber"] as $param) echo "<td>$user[$param]</td>";
                        echo "<td>".$user["street"]." ".$user["propertynum"]." ".$user["city"]." ".$user["postcode"]."</td>";
                        echo $user["isadmin"] ? " <td>Ano</td>" : "<td>Ne</td>";
                        if (UserManager::isRootAdminLogged()){
                            if ($user["isadmin"]) echo "<td><a href='user_manager.php?demote=$user[id]' style='opacity: 50%'><img alt='' style='width: 20px' src='src/imgs/crown.svg'> Sesadit</a></td>";
                            else echo "<td><a href='user_manager.php?promote=$user[id]'><img alt='' style='width: 20px' src='src/imgs/crown.svg'> Povýšit</a></td>";
                        }
                        //uživatel admin => 1
                        //ten samý uživatel => 1

                        // 0 0 => 0
                        // 1 0 => 0
                        // 0 1 => 0
                        // 1 1 => 1

                        if (!$user["isadmin"] && $user["username"] != UserManager::getLoggedUsername()){
                            echo "<td><a href='user_manager.php?removeuser=$user[id]'><img alt='' style='width: 20px' src='src/imgs/x.svg'></a></td>";
                        }

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