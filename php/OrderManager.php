<?php

class OrderManager
{
    public static function order(): bool {
        if (!UserManager::isLogged()) return false;
        if (UserManager::isAdminLogged()) return false;
        if (BasketManager::isEmpty()) return false;

        $userid = Db::queryOne("SELECT id FROM users WHERE username=?",UserManager::getLoggedUsername())["id"];
        Db::query("INSERT INTO invoices (userid) VALUE (?)",$userid);
        $invoiceid = Db::queryOne("SELECT id FROM invoices WHERE userid=? ORDER BY date DESC",$userid)["id"];
        foreach (BasketManager::basketData() as $basketItem){
            Db::query("INSERT INTO invoices_sneakers (idinvoice, idsneaker, size) VALUES (?,?,?)",$invoiceid,$basketItem["id"],$basketItem["size"]);
            Db::query("UPDATE sneakersizes SET amount=amount-1 WHERE sneakerid=? AND size=?",$basketItem["id"],$basketItem["size"]);
        }
        return true;
    }
}