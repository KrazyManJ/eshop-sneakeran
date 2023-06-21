<?php

class SneakersManager
{
    public static function getNameById($productid){
        return Db::queryOne("SELECT name FROM sneakers WHERE id=?",$productid)["name"];
    }
    public static function getImageById($productid){
        return Db::queryOne("SELECT imgpath FROM sneakers WHERE id=?",$productid)["imgpath"];
    }
    public static function getPriceById($productid): string{
        return number_format(Db::queryOne("SELECT price FROM sneakers WHERE id=?",$productid)["price"],0,"."," ")." Kč";
    }
    public static function getDescriptionById($productid): string {
        return Db::queryOne("SELECT description FROM sneakers WHERE id=?",$productid)["description"];
    }
    public static function getSneakerInfo($productid) {
        return Db::queryAll("SELECT * FROM sneakers WHERE id=?",$productid)[0];
    }

    public static function getAvailableSizes($productid): array
    {
        $R = array();
        if (BasketManager::isEmpty()){
            foreach (Db::queryAll("SELECT size FROM sneakersizes WHERE sneakerid=? AND amount > 0",$productid) as $sizedata){
                $R[] = $sizedata["size"];
            }
        }
        else {
            foreach (Db::queryAll("SELECT size,amount FROM sneakersizes WHERE sneakerid=? AND amount > 0",$productid) as $sizedata){
                $currentsize = $sizedata["amount"];
                foreach (BasketManager::basketData() as $basketData){
                    if ($basketData["id"] == $productid && $basketData["size"] == $sizedata["size"]) $currentsize--;
                }
                if ($currentsize > 0) $R[] = $sizedata["size"];

            }
        }
        return $R;
    }

    public static function isAvailable($productid): bool{
        return sizeof(self::getAvailableSizes($productid)) > 0;
    }

    public static function amount($productid,$size){
        $r = Db::queryOne("SELECT amount FROM sneakersizes WHERE sneakerid=? AND size=?",$productid,$size);
        return sizeof($r) > 0 ? $r["amount"] : 0;
    }

    public static function addSneaker($name,$desc,$imgpath,$price){
        Db::query("INSERT INTO sneakers (name, description, price, imgpath) VALUE (?,?,?,?)",$name,$desc,$price,$imgpath);
    }
    public static function removeSneaker($id){
        Db::query("DELETE FROM sneakers WHERE id=?",$id);
    }
    public static function addSneakerSize($sneakerid,$size,$amount){
        if (in_array($size,self::getAvailableSizes($sneakerid))) Db::query("UPDATE sneakersizes SET amount=? WHERE sneakerid=? AND size=?",$amount,$sneakerid,$size);
        else Db::query("INSERT INTO sneakersizes (sneakerid, size, amount) VALUES (?,?,?)",$sneakerid,$size,$amount);
    }
    public static function removeSneakerSize($sneakerid,$size){
        Db::query("DELETE FROM sneakersizes WHERE sneakerid=? AND size=?",$sneakerid,$size);
    }

    public static function getAllSneakersData(){
        return Db::queryAll("SELECT * FROM sneakers");
    }

    public static function isValidSneaker($id){
        return sizeof(Db::queryOne("SELECT * FROM sneakers WHERE id=?",$id)) > 0;
    }
}