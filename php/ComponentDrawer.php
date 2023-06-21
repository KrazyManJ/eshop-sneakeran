<?php

class ComponentDrawer
{
    public static function drawNav($includeLogin, $includeRegister): string
    {
        $MID = "";
        $RIGHT = "";
        if (UserManager::isLogged()) {
            $RIGHT = '<a href="user_info.php" class="white shadow-soft-text">' . UserManager::getLoggedUsername() . '</a>';
            if (UserManager::isAdminLogged()) {
                $MID = '
                    <ul>
                        <li><a href="user_manager.php" class="white shadow-soft-text">Uživatelé</a></li>
                        <li><a href="invoice_manager.php" class="white shadow-soft-text">Objednávky</a></li>
                        <li><a href="product_manager.php" class="white shadow-soft-text">Zboží</a></li>
                    </ul>
                ';
                $RIGHT .= '<a href="" class="white shadow-soft" title="Jako administrátor nemůžeš nakupovat!" style="opacity: 0.25" ><img src="src/imgs/basket-fill.svg" height="40px" alt=""></a>';
            } else {
                $RIGHT .= '<a href="basket_view.php" class="white shadow-soft"><img src="src/imgs/basket-fill.svg" height="40px" alt=""></a>';
            }
        } else {
            if ($includeLogin) $RIGHT .= '<a href="login.php" class="white shadow-soft-text">Přihlásit se</a>';
            if ($includeRegister) $RIGHT .= '<a href="register.php" class="white shadow-soft-text">Registrace</a>';
        }
        return '
            <nav class="disable-select">
                <a href="index.php">
                    <img src="src/imgs/jordan_white.svg" height="60px" alt="" class="shadow-solid-2" >
                    <span class="nikee white shadow-solid-2" style="font-size: 25px;margin-left: -10px">
                        sneakeran
                    </span>
                </a>
                ' . $MID . '
                <span class="flex-center">
                    ' . $RIGHT . '
                </span>
            </nav>
        ';
    }

    public static function drawProductCard($productdata): string
    {
        return '
            <a href="product_view.php?product=' . $productdata["id"] . '">
                <div class="product-card widget shadow-soft">
                    <div>
                        <img class="shadow-soft" src=src/imgs/sneakers/' . $productdata["imgpath"] . ' alt="">
                    </div>
                    <div class="product-info-container">
                        <div class="label medium">' . $productdata["name"] . '</div>
                        <div class="shadow-soft medium price ' . (SneakersManager::isAvailable($productdata["id"]) ? "available" : "unavailable") . '">' . (
            SneakersManager::isAvailable($productdata["id"])
                ? number_format($productdata["price"], 0, ".", " ") . " Kč"
                : "Není skladem"
            ) . '</div>
                    </div>
                    
                </div>
            </a>
        ';
    }
}
