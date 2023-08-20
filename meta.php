<?php
include ("baglanti.php");


$meta_cek = $db->query("SELECT * FROM ayar");
$meta_cek->execute();		
if($meta_cek->rowCount() != 0){
									
	foreach ($meta_cek as $meta_oku) {

$keyword = $meta_oku['keyword'];
$descri = $meta_oku['descri'];

}
}
?>