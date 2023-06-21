<?php

class BasketManager
{

    private static function basket(){
        return $_SESSION["basket"];
    }

    public static function initBasket(){
        $_SESSION["basket"] = [];
    }
    public static function clearBasket(){
        $_SESSION["basket"] = [];
    }
    public static function destroyBasket(){
        unset($_SESSION["basket"]);
    }


    public static function isEmpty(): bool
    {
        return !isset($_SESSION["basket"]) || sizeof(self::basket()) == 0;
    }

    public static function addToBasket($productid,$size){
        $_SESSION["basket"][] = [
            "id" => $productid,
            "size" => $size
        ];
    }

    public static function removeFromBasket($productindex){
        if ($productindex >= sizeof(self::basket())) return;

        array_splice($_SESSION["basket"],$productindex,1);
    }

    public static function basketSize(): int
    {
        return sizeof($_SESSION["basket"]);
    }
    public static function basketData(){
        return $_SESSION["basket"];
    }
    public static function mergedBasketData()
    {
        $R = [];
        foreach (array_unique(self::basket(),SORT_REGULAR) as $item){
            $R[] = [
                "id" => $item["id"],
                "size" => $item["size"],
                "count" => self::array_occurence($item,self::basket())
            ];
        }
        return $R;
    }

    public static function array_occurence($element,$array){
        $count = 0;
        foreach($array as $e) if ($e == $element) $count++;
        return $count;
    }

    public static function basketTotalValue(){
        if (self::isEmpty()) return 0;
        $value = 0;
        foreach (self::basket() as $product) {
            $value += Db::queryOne("SELECT price FROM sneakers WHERE id=?",$product["id"])["price"];
        }
        return $value;
    }
}