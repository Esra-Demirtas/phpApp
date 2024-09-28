<?php

function convertToSEO($text){

    $turkce = array ("ç", "Ç", "ğ", "Ğ", "ü", "Ü","ö", "Ö", "ı", "i", "ş", "Ş", ",", ".", "!", "\"", " ", "?", "*", "_", "|", "=", "(", ")", "[", "]", "{", "}");
    $convert = array("c", "C", "g", "g", "u", "u", "o", "o", "i", "i", "s", "s", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-");

    return strtolower(str_replace($turkce, $convert, $text));
}
function get_readable_date($date){
    return date("d.m.Y", strtotime($date));
}
