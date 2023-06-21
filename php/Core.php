<?php

include("php/ComponentDrawer.php");
include("php/SneakersManager.php");
include("php/BasketManager.php");
include("php/OrderManager.php");
include("php/InvoicesManager.php");
include("php/FormatUtils.php");

class Core {
    /**
     * Funkce, která načte znovu stránku po vykonání metody "POST"
     * @return void
     */
    public static function postRedirect($redirect = null){
        header( "Location: ".($redirect ?? $_SERVER["REQUEST_URI"]), true, 303 );
        exit();
    }


    public static function init(){
        require("php/UserManager.php");
        require_once "dependencies/Db.php";
        Db::connect("localhost","sneaker_eshop","root","");
        session_start();
    }
}