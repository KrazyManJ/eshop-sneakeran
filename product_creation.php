<?php
require("php/Core.php");
Core::init();

if (!UserManager::isAdminLogged()) Core::postRedirect("index.php");

if (isset($_POST["addproduct"])){
    $file = $_FILES["img"];

    $t = explode(".",$file["name"]);
    $ext = strtolower(end($t));

    $finalname = str_replace(" ","_",strtolower($_POST["name"])).".".strtolower(end($t));

    move_uploaded_file($file["tmp_name"],"src/imgs/sneakers/".$finalname);
    SneakersManager::addSneaker($_POST["name"],$_POST["desc"],$finalname,$_POST["price"]);
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
    <title>SNEAKERAN | </title>
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
            <h1 class="shadow-soft-text textcenter">Přidání produktu</h1>
            <div class="grid-ctr">
                <div class="widget shadow-soft" style="width: 500px;height: fit-content">

                    <form method="post" enctype="multipart/form-data">

                        <label for="name" class="light">Jméno produktu</label>
                        <input required id="name" name="name" type="text" class="fullwidth textcenter shadow-soft">

                        <label for="img" class="light">Fotka produktu</label>
                        <input required id="img" name="img" type="file" accept=".jpg,.jpeg,.png" class="fullwidth textcenter shadow-soft">

                        <label for="desc" class="light">Popis produktu</label>
                        <input required id="desc" name="desc" type="text" class="fullwidth textcenter shadow-soft">

                        <label for="price" class="light">Cena</label>
                        <input required id="price" name="price" type="number" class="fullwidth textcenter shadow-soft">

                        <input type="submit" name="addproduct" value="Přidat produkt" class="shadow-soft" style="margin-top: 20px">
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer class="white textcenter">© 2022 Copyright: Jaroslav Korčák</footer>
    <img src="src/imgs/sneaker_black.svg" alt="" id="sneaker">
</body>
</html>