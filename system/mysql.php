<?php
	
	session_start();
	## Hataları Gizle ##

	
	## Bağlantı Değişkenleri ##
	$host 	= "localhost";
	$user 	= "root";
	$pass 	= "";
	$db		= "lop";
	
	## Mysql Bağlantısı ##
	$baglan = mysql_connect($host, $user, $pass) or die (mysql_Error());
	
	## Veritabanı Seçimi ##
	mysql_select_db($db, $baglan) or die (mysql_Error());
	
	## Karakter Sorunu ##
	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8'");
	
	## Genel Ayarları ##
	$query = mysql_query("SELECT * FROM ayar");
	$ayar = mysql_fetch_array($query);
	
		## Sabitler ##
		define("URL", $ayar["site_url"]);
		define("TITLE", $ayar["site_baslik"]);
		define("DESC", $ayar["site_desc"]);
		define("KEYW", $ayar["site_keyw"]);
		define("FB_ID", $ayar["fb_app_id"]);
		define("FB_SECRET", $ayar["fb_app_secret"]);
		define("BACK", isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');


?>