<?php

if (isset($_FILES['upload'])) {
    $url = '../'.$site['file_dir'].$_FILES['upload']['name'];

    //*********** UPLOAD İŞLEMİ ***********/
    // Tüm upload dosyalarına PHP'nin $_FILES objesinden ulaşışabilir. Örneğimizde, HTML elementimizin name değeri dosya'dır
    $handle = new Upload($_FILES['upload']);

    // Geçici yükleme işlemi tamamlandı mı kontrol edelim
    // Dosyamız geçici yükleme işleminin yapıldığı *temporary* sunucudaki konumda bulunuyor. (Genellikle /tmp klasörüdür.)
    if ($handle->uploaded) {
        // Dosyamız sunucuda
        // Eğer yüklenen dosya resimse, dosyayı kalıcı konumuna almadan bir kaç değişiklik yapalım.
        // Resim değilse direk yükleme yapar
        $handle->image_resize    = true;
        $handle->image_ratio_y    = true;
        $handle->image_x        = 500;

        // Yüklenen dosyayı geçici klasöründen bizim konmasını istediğimiz klasöre alalım. Dosya izinlerine dikkat, everyone read&write olmalı!
        // Örneğin $handle->Process('/home/www/veri/');
        $dir_dest = $site['file_dir'];
        $handle->Process($dir_dest);
    }

    $funcNum = $_GET['CKEditorFuncNum'];
    echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
}
