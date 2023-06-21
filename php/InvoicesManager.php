<?php

class InvoicesManager
{
    public static function gatherAllUserInvoices($username){
        return Db::queryAll("SELECT * FROM invoices WHERE userid=? ORDER BY date DESC",UserManager::getLoggedId());
    }

    public static function formatState($state): string
    {
        switch ($state){
            case "accepted":
                return "Přijata";
            case "processing":
                return "Zpracovává se";
            case "sent":
                return "Odeslána";
            default:
                return "Žádná";
        }
    }

    public static function doesLoggedUserOwnsInvoice($invoiceid){
        if (!UserManager::isLogged()) return false;
        if (UserManager::isAdminLogged()) return false;


        foreach (Db::queryAll("SELECT id FROM invoices WHERE userid=?",UserManager::getLoggedId()) as $invoice){
            if ($invoiceid == $invoice["id"]) return true;
        }

        return false;
    }

    public static function getInvoiceSneakers($invoiceid){
        return Db::queryAll("SELECT * FROM invoices_sneakers WHERE idinvoice=?",$invoiceid);
    }
    public static function getInvoiceData($invoiceid){
        return Db::queryAll("SELECT * FROM invoices WHERE id=?",$invoiceid)[0];
    }
    public static function invoiceTotalPrice($invoiceid){
        $value = 0;
        foreach (self::getInvoiceSneakers($invoiceid) as $product) {
            $value += Db::queryOne("SELECT price FROM sneakers WHERE id=?",$product["idsneaker"])["price"];
        }
        return $value;
    }

    public static function updateInvoiceStatus($id){
        $currentState = Db::queryOne("SELECT state FROM invoices WHERE id=?",$id)["state"];
        $newState = "";
        switch ($currentState) {
            case "accepted":
                $newState = "processing";
                break;
            case "processing":
                $newState = "sent";
                break;
            default:
                return;
        }
        Db::query("UPDATE invoices SET state=? WHERE id=?",$newState,$id);
    }
}