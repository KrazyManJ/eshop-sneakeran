<?php
require("php/Core.php");
Core::init();

if (isset($_POST["logout"])){
    UserManager::logout();
    Core::postRedirect("index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SNEAKERAN | Účet</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/Main.css">
    <link rel="icon" href="favicon.svg">
</head>
<body>
    <?php
        echo ComponentDrawer::drawNav(false,false);
    ?>
    <main>
        <?php if(UserManager::isRootAdminLogged()) {

            echo '
                <div class="widget shadow-soft">
                    <div style="margin-bottom: 20px" class="textcenter fs-50 shadow-soft-text">Jsi přihlášen jako root admin!</div>
                    <form method="post" class="grid-ctr">
                        <input type="submit" name="logout" value="Odhlásit se" class="pointer shadow-soft" >
                    </form>
                </div>
                </main>
                <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
                <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
            </body>
            </html>
            
            ';
            exit();
        }


            ?>
        <h1 class="main-title shadow-soft-text">Účet</h1>
        <div style="display: grid; grid-template-columns: 30% minmax(60%, 70%); column-gap: 20px;">
            <div>
                <div class="widget shadow-soft" style="margin-bottom: 20px">
                    <div class="textcenter medium fs-50 shadow-soft-text" >Údaje</div>
                    <table class="fullwidth exclude-last">
                        <?php
                        $user = Db::queryAll("SELECT * FROM users WHERE username=? LIMIT 1",UserManager::getLoggedUsername())[0];

                        $data = [
                                ["Email",$user["email"]],
                                ["Jméno",$user["firstname"]." ".$user["lastname"]],
                                ["Telefon",number_format($user["phonenumber"],0,""," ")],
                                ["Adress",ucfirst($user["street"])." ".$user["propertynum"]],
                                ["Město",ucfirst($user["city"])],
                                ["PSČ",substr_replace($user["postcode"]," ",3,0)]
                        ];
                        foreach ($data as $el){
                            echo "<tr><td>$el[0]</td><td>$el[1]</td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <div class="widget grid-ctr shadow-soft">
                    <a href="change_password.php" style="margin-bottom: 10px" ><button class="pointer shadow-soft">Změnit heslo</button></a>
                    <form method="post">
                        <input type="submit" name="logout" value="Odhlásit se" class="pointer shadow-soft" >
                    </form>

                </div>
            </div>
            <div>
                <div class="widget shadow-soft">
                    <?php
                        if (UserManager::isAdminLogged()) {
                            echo "<div class='fs-50 textcenter'>Jako admin nemáš žádné objednávky!</div>";
                        }
                        else {
                            $a = "";
                            foreach(InvoicesManager::gatherAllUserInvoices(UserManager::getLoggedId()) as $invoice){
                                $a .= "<tr class='pointer' onclick='window.open(`invoice_view.php?invoice=$invoice[id]`,`_self`)'>
                                <td>$invoice[id]</td>
                                <td>".FormatUtils::formatDate($invoice["date"]) ."</td>
                                <td>".InvoicesManager::formatState($invoice["state"])."</td>
                            </tr>
                            ";
                            }
                            echo '<div class="textcenter medium fs-50 shadow-soft-text">Vaše objednávky</div>
                                <table class="exclude-last fullwidth">
                                    <tr>
                                        <td class="medium">Identifikace</td>
                                        <td class="medium">Datum objednání</td>
                                        <td class="medium">Status</td>
                                    </tr>
                                    '.$a.'
                                </table>';
                        }
                    ?>

                </div>
            </div>
        </div>



    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>