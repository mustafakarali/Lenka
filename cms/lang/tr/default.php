<?php

/* Custom variables */
require_once 'custom.php';
/* Other variables */
require_once 'menu.php';
require_once 'ecommerce.php';
require_once 'settings.php';
/*
 * General
 *
 */
$lang['Loading'] = 'İşlem yapılıyor';
$lang['Session died'] = 'Oturum süreniz doldu';
$lang['Go to web site'] = 'Siteyi görüntüle';

$lang['id'] = 'Nu';
$lang['Id'] = 'Nu';
$lang['desc'] = 'Açıklama';
$lang['Desc'] = 'Açıklama';
$lang['description'] = 'Açıklama';
$lang['Description'] = 'Açıklama';
$lang['name'] = 'İsim';
$lang['Name'] = 'İsim';
$lang['First name'] = 'İsim';
$lang['surname'] = 'Soyadı';
$lang['Surname'] = 'Soyadı';
$lang['title'] = 'Başlık';
$lang['Title'] = 'Başlık';
$lang['value'] = 'Değer';
$lang['Value'] = 'Değer';
$lang['Field'] = 'Alan';
$lang['List'] = 'Liste';
$lang['Item'] = 'Seçilen';

// Datatable
$lang['sSearch'] = 'Ara:';
$lang['sLengthMenu'] = 'Her sayfada _MENU_ kayıt göster';
$lang['sZeroRecords'] = 'Üzgünüz, hiç kayıt bulunmuyor';
$lang['sInfo'] = '_TOTAL_ kayıttan _START_ ile _END_ arasındakiler gösteriliyor';
$lang['sInfoEmpty'] = 'Showing 0 to 0 of 0 records';
$lang['sInfoFiltered'] = '(filtered from _MAX_ total records)';
$lang['sFirst'] = 'İlk';
$lang['sLast'] = 'Son';
$lang['sNext'] = 'Önceki';
$lang['sPrevious'] = 'Sonraki';
$lang['fileDefaultText'] = 'Dosya seçin';
$lang['zeroRecords'] = 'Üzgünüz, kayıt bulunamadı';
// File
$lang['selectedFile'] = 'Dosya seçildi';
$lang['Selected item'] = 'Seçili eleman';
$lang['file_Url'] = 'Dosya adresi';
$lang['file_Size'] = 'Dosya boyutu';
$lang['file_Date'] = 'Yükleme tarihi';
// Others
$lang['General'] = 'Genel';
$lang['Global'] = 'Küresel';
$lang['Local'] = 'Yerel';
// Notes
$lang['Added successfully'] = 'Başarıyla eklenmiştir';
$lang['Completed successfully'] = 'Başarıyla tamamlanmıştır';
$lang['Deleted successfully'] = 'Başarıyla silinmiştir';
$lang['Edited successfully'] = 'Başarıyla düzenlenmiştir';
$lang['Removed successfully'] = 'Başarıyla kaldırılmıştır';
$lang['Saved successfully'] = 'Başarıyla kaydedilmiştir';

$lang['Admin'] = 'Yönetim';
/* Other pages */
// Homepage
$lang['Calendar'] = 'Takvim';
$lang['Count of categories'] = 'Kategori sayısı';
$lang['Count of contents'] = 'İçerik sayısı';
$lang['Count of galleries'] = 'Albüm sayısı';
$lang['Count of langs'] = 'Tanımlı dil sayısı';
$lang['Count of menus'] = 'Menü sayısı';
$lang['Count of modules'] = 'Modül sayısı';
$lang['Count of orders'] = 'Siperiş sayısı';
$lang['Count of products'] = 'Ürün sayısı';
$lang['Count of routers'] = 'Yönlendirisi sayısı';
$lang['Count of users'] = 'Kayıtlı kullanıcı sayısı';
$lang['My Calendar'] = 'Kayıtlı etkinlikler';
// Calendar
$lang['Events'] = 'Etkinlikler';
$lang['Event title'] = 'Başlık';
$lang['Event start'] = 'Başlangıç zamanı';
// Settings
$lang['Localization'] = 'Konum';
$lang['Contact'] = 'İletişim';
$lang['Additional codes'] = 'Ekstra kod ekleme';
$lang['Social media'] = 'Sosyal medya';
// Dynamic variables
$lang['Dynamic variables'] = 'Dinamik değişkenler';
$lang['dynamic_var_key'] = 'Değişken adı';
$lang['dynamic_var_value'] = 'Değişkenin değeri';
$lang['dynamic_var_type'] = 'Tipi';
$lang['Type'] = 'Tip';
$lang['Default data'] = 'Varsayılan veri';
$lang['Note'] = 'Not';
$lang['Prefix'] = 'Önek';
$lang['Prefix in the columns name as "coupon", "faq"'] = 'Tabloda yer alan sütunların ön ekleri "coupon", "faq" şeklinde belirtilir';
$lang['Column names for heading'] = 'Sütun isimleri';
$lang['Column names for data'] = 'Veri isimleri';
$lang['Seperate with \',\' witout any spaces between items'] = 'İlgili alanları arada hiç boşluk kalmayacak şekilde \',\' ile ayırın';
$lang['Will be in menu?'] = 'Ana menüde bulunacak mı?';
$lang['Icon'] = 'İkon';
$lang['Icon for menu item'] = 'Menüde gözükecek ikon';
$lang['To use dynamic tables'] = 'Dinamik tabloları kullanmak için';
$lang['First of all, create a new table in database'] = 'İlk olarak veritabanı içerisinde bir tablo oluşturun';
$lang['Secondly, insert one row dummy text'] = 'Ardından bu tabloya anlamsızda olsa bir satırlık veri girin';
$lang['Lastly, set rules to map columns of database table'] = 'Son olarak, dinamik tablonun nasıl çalışacağını belirtmek için aşağıdaki formu doldurun';

// Datatables
$lang['Tables in database'] = 'Veritabanı tabloları';
$lang['Rules'] = 'Kurallar';
$lang['Columns'] = 'Sütunlar';
$lang['Buttons'] = 'Tuşlar';
$lang['Is Details button visible to show the details of row?'] = 'Listeleme de kullanılan Detaylar tuşu görünür mü olacak?';
$lang['Details Button'] = 'Detaylar Tuşu';
$lang['Additional Button'] = 'Ekstra Tuş';
$lang['You can add an extra button between details and delete buttons in the table for list view'] = 'Listeleme de kullanılmak üzere detaylar ve sil tuşlarının arasına bir tuş daha ekleyebilirsiniz';
$lang['External Link'] = 'Harici bağlantı adresi';
$lang['Links'] = 'Bağlantı adresleri';
$lang['Events'] = 'Olay';
$lang['Call onClick, onMouseOver event and type function name with params'] = 'onClick gibi js eventlerinin nasıl kullanılacağını parametreleriyle birlikte buraya yazabilirsiniz';

// Dynamic tables
$lang['Dynamic table'] = 'Dinamik tablo';
$lang['Dynamic tables'] = 'Dinamik tablolar';
$lang['Rules of dynamic table'] = 'Dinamik tablonun kuralları';
$lang['prefix'] = 'Önek';
$lang['Predefined options in Input class'] = 'Input sınıfındaki ön tanımlı değerlerden birini seçin';
$lang['You can type a function name to fill the value of the element'] = 'Elemanın değerini doldurmak için tanımlanmış olan bir fonksiyonun adını da yazabilirsiniz';
$lang['Note to display in form'] = 'Form\'da gösterilecek notu belirtin';

// Modules & Routers
$lang['module_auth'] = 'Yetki seviyesi';
$lang['module_id'] = 'Modül';
$lang['module_name'] = 'Modül ismi';
$lang['parent_folder'] = 'Üst klasör';
$lang['header_cache'] = 'Header bellek süresi';
$lang['model_cache'] = 'Model bellek süresi';
$lang['view_cache'] = 'View bellek süresi';
$lang['footer_cache'] = 'Footer bellek süresi';
$lang['module_header'] = 'Header dosyası';
$lang['module_footer'] = 'Footer dosyası';
$lang['router_name'] = 'Yönlendirici';
// Categories
$lang['Category'] = 'Kategori';
$lang['category_name'] = 'Kategori ismi';
$lang['category_img'] = 'Kategori resmi';
$lang['Parent_category'] = 'Üst kategori';
$lang['Parent category'] = 'Üst kategori';
$lang['parent_id'] = 'Üst kategori';
// Content
$lang['Content'] = 'İçerik';
$lang['gallery_id'] = 'Galeri';
$lang['content_img_c'] = 'Büyük resim';
$lang['content_img_t'] = 'Küçük resim';
$lang['is_home'] = 'Anasayfa\'da göster';
$lang['Place into homepage'] = 'Anasayfa\'ya koy';
$lang['Do not place into homepage'] = 'Anasayfa\'ya koyma';

$lang['content_text'] = 'Metin';
$lang['content_time'] = 'Tarih';
$lang['content_title'] = 'Başlık';
$lang['content_summary'] = 'Özet';
$lang['Image dimension should be :img_w px and height :img_h px'] = 'Resim boyutları :img_w px genişliğinde ve :img_h px yüksekliğinde olmalıdır';
$lang['Image dimension should be :thumb_w px and height :thumb_h px'] = 'Resim boyutları :thumb_w px genişliğinde ve :thumb_h px yüksekliğinde olmalıdır';
$lang['seo_author'] = 'SEO yazarı';
$lang['seo_desc'] = 'SEO tanımı';
$lang['seo_keywords'] = 'SEO anahtar kelimeleri';
$lang['seo_img'] = 'SEO resmi';
$lang['seo_title'] = 'SEO başlığı';
$lang['Similar contents'] = 'Benzer içerikler';
$lang['Summerize your content with 150-160 chars'] = 'İçeriğinizi 150-160 karakterle özetleyin';
$lang['You can select multiple categories with ctrl'] = 'Ctrl tuşuna basılı tutarak birden çok kategori seçebilirsiniz';
$lang['Double click to select similar contents'] = 'Benzer içerikleri seçmek için sol taraftaki kutuda bulunan içeriklere çift tıklayabilirsiniz';
$lang['You can use predefined patterns to enhance your content'] = 'İçeriğinizi geliştirebilecek ön tanımlı şablonlar varsa, buradan seçebilirsiniz';
$lang['Public'] = 'Yayında';
$lang['Not public'] = 'Yayında değil';
// Pattern
$lang['Pattern'] = 'Şablon';
$lang['pattern_id'] = 'Şablon';
$lang['Name of pattern'] = 'Şablonun ismi';
// Gallery
$lang['Cover photo of the album'] = 'Kapak fotoğrafını seçin';
$lang['Size of thumb, width and height'] = 'Küçük resmin genişlik ve yükseklik değerleri';
$lang['Size of image, width and height'] = 'Albüme eklenecek resmin genişlik ve yükseklik değerleri';
$lang['Number of photo'] = 'Albümdeki resim sayısı';
$lang['Width of thumb'] = 'Küçük resmin genişliği';
$lang['Height of thumb'] = 'Küçük resmin yüksekliği';
$lang['Width of photo'] = 'Büyük resmin genişliği';
$lang['Height of photo'] = 'Büyük resmin yüksekliği';
$lang['gallery_title'] = 'Albüm\'ün adı';
$lang['gallery_text'] = 'Albüm açıklaması';
$lang['gallery_date'] = 'Albüm\'ün oluşturulduğu tarih';
$lang['gallery_img'] = 'Albüm\'ün kapak fotoğrafı';
$lang['gallery_vid'] = 'Video\'nun embed kodu';
$lang['gallery_video_text'] = 'Açıklama';
$lang['To add an image click to select button'] = 'Resim yüklemek için "Resim seçin" tuşuna basın, seçtiğiniz resim alt tarafa açılacaktır. Açılan bu resim üzerine tıklayarak küçük resminin oluşmasını sağlayabilirsiniz.';
$lang['Select image to add'] = 'Resim seçin';
$lang['Select another one'] = 'Başka bir resim seçin';
$lang['gallery_data_type'] = 'Dosya türü';
$lang['gallery_data_text'] = 'Açıklama';
$lang['Gallery data'] = 'Albüm içeriği';
// Menü
$lang['menu_data_target'] = 'Yeni sayfa nasıl açılacak';
$lang['menu_name'] = 'Menü adı';
$lang['menu_text'] = 'Menü açıklama';
// Popup
$lang['Height of popup window'] = 'Açılır pencerenin yüksekliği';
$lang['image_width'] = 'Resmin genişliği';
$lang['popup_text'] = 'Metin';
$lang['popup_href'] = 'URL';
$lang['window_width'] = 'Pencere genişliği';
$lang['window_height'] = 'Pencere yüksekliği';
$lang['What will happen on click'] = 'Tıklanınca açılacak sayfanın adresi';
$lang['Width of popup window'] = 'Açılır pencerenin genişliği';
$lang['Width of image in the popup window'] = 'Açılır pencerede yer alan resmin genişliği';
// Slide
$lang['slides'] = 'Slide\'lar';
$lang['slide_img'] = 'Resim';
$lang['slide_title'] = 'Başlık';
$lang['slide_text'] = 'Metin';
$lang['target'] = 'Nasıl açılacak';
$lang['slide_href'] = 'URL';
$lang['slide_target'] = 'Nasıl açılacak';
// Faqs
$lang['Question'] = 'Soru';
$lang['Answer'] = 'Cevap';
$lang['faq_question'] = 'Soru';
$lang['faq_answer'] = 'Cevap';
// Users
$lang['User'] = 'User';
$lang['Auth'] = 'Yetki';
$lang['Last seen'] = 'Son görülme';
$lang['Last page'] = 'Son görüldüğü sayfa';
$lang['Most visit'] = 'En çok ziyaret';
$lang['Last active editors'] = 'En son çevrimiçi olan yöneticiler';
$lang['Last active members'] = 'En son çevrimiçi olan üyeler';
$lang['Unactivated users'] = 'Aktivasyonu yapılmamış kullanıcılar';
$lang['Activate'] = 'Aktifleştir';
$lang['activate'] = 'Aktifleştir';
$lang['Ban'] = 'Engelle';
$lang['pass1'] = 'Şifre';
$lang['pass2'] = 'Şifre (Yeniden)';
$lang['user_about'] = 'Hakkında';
// Backup
$lang['Backups'] = 'Yedekler';
$lang['Backup file'] = 'Yedek dosyası';
