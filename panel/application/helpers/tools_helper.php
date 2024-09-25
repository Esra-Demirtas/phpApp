<?php

function convertToSEO($text){

    $turkce = array ("ç", "Ç", "ğ", "Ğ", "ü", "Ü","ö", "Ö", "ı", "i", "ş", "Ş", ",", ".", "!", "\"", " ", "?", "*", "_", "|", "=", "(", ")", "[", "]", "{", "}");
    $convert = array("c", "C", "g", "g", "u", "u", "o", "o", "i", "i", "s", "s", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-");

    return strtolower(str_replace($turkce, $convert, $text));
}

/*function getFileName($id){
    $fileName = $this->product_image_model->get(
        array(
            "id"    => $id
        )
    );
    return $fileName->img_url;
}*/

/*function getFileName($id) {
    // CodeIgniter'ın global instance'ına eriş
    $ci =& get_instance();

    // Modeli yükle
    $ci->load->model('product_image_model');

    // Veritabanından dosya adını al
    $fileName = $ci->product_image_model->get(array(
        "id" => $id
    ));

    // Eğer dosya adı mevcutsa img_url döndür
    return $fileName ? $fileName->img_url : null;
}*/
