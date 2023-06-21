<?php

class FormatUtils
{

    public static function formatMoney($number): string
    {
        return number_format($number, 0, ".", " ")." Kč";
    }

    public static function formatDate($date)
    {
        return date_format(date_create($date), "d.m.Y H:i");
    }
}