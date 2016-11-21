<?php
	define('PATH', empty($_SERVER['PATH_INFO']) ? '/' : getenv('PATH_INFO'));
	define('METHOD', $_SERVER['REQUEST_METHOD']);
	$route = true;
	function ext($file)
	{
	    $ext = pathinfo($file);
	    return $ext['extension'];
	} 
	function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
	function dbTarihtoJsTarih($str)
	{
		$tarih = $str;
		$tarih_dizi = explode("-",$tarih);
		$tarih = $tarih_dizi[2] ."/".  $tarih_dizi[1] ."/". $tarih_dizi[0];
		return $tarih;
	}
 	function Durum($degisken)
	{
		switch ($degisken)
		{
			case 0:
			$rutbe = "Erişilebilir";
			break;
			case 1:
			$rutbe = "Engellendi";
			break;

		}
		return $rutbe;
	}
	function Rutbe($str)
	{
		switch ($str)
		{
			case 0:
			$rutbe = "Normal Üye";
			break;
			case 1:
			$rutbe = "Yönetici";
			break;

		}
		return $rutbe;
	}
	function issetLogin()
	{
	    if (isset($_SESSION['login'])) {
	        if (!headers_sent())
	            header('Location: /');
	        exit;
	    }
	}
	function loginVar()
	{
		if(isset($_SESSION["login"]))
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	function adminMi()
	{
		if($_SESSION['rutbe'] == 1 )
		{
			return true;
		}else
		{
			return go(URL);
		}
	}
	function Route($method, $desen, $callable)
	{
	    global $route;
	    if (is_array($desen)) {
	        list($desen, $func) = $desen;
	    }

	    if (preg_match("~^$desen$~ms", PATH, $param) && $route && METHOD == $method) {
			
	        if (isset($func))
	            call_user_func($func);
	        if (is_callable($callable)) {
	            array_shift($param);
	            call_user_func_array($callable, $param);
	        }
	        $route = false;
	    }
	}
	
	function p($par, $st = false){
		if ($st){
			return htmlspecialchars(addslashes(trim($_POST[$par])));
		}else {
			return addslashes(trim($_POST[$par]));
		}
	}
	
	
	function g($par){
		return strip_tags(trim(addslashes($_GET[$par])));
	}
	
	function kisalt($par, $uzunluk = 50){
		if (strlen($par) > $uzunluk){
			$par = mb_substr($par, 0, $uzunluk, "UTF-8")."..";
		}
		return $par;
	}
	
	
	
	function go($par, $time = 0){
		if ($time == 0){
			header("Location: {$par}");
		}else {
			header("Refresh: {$time}; url={$par}");
		}
	}
	
	function session($par){
		if ($_SESSION[$par]){
			return $_SESSION[$par];
		}else {
			return false;
		}
	}
	
	function cookie($par){
		if ($_COOKIE[$par]){
			return $_COOKIE[$par];
		}else {
			return false;
		}
	}
	
	function ss($par){
		return stripslashes($par);
	}
	
	function session_olustur($par){
		foreach ($par as $anahtar => $deger){
			$_SESSION[$anahtar] = $deger;
		}
	}
	
	function sef_link($baslik){
		$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
		$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
		$perma = strtolower(str_replace($bul, $yap, $baslik));
		$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
		$perma = trim(preg_replace('/\s+/',' ', $perma));
		$perma = str_replace(' ', '-', $perma);
		return $perma;
	}
	
	function query($query){
		return mysql_query($query);
	}
	
	function row($query){
		return mysql_fetch_array($query);
	}
	
	function rows($query){
		return mysql_num_rows($query);
	}
	function eposta ($adsoyad, $eposta, $konu, $mesaj){
		$header = "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset=utf-8\r\n";
		$header .= "From: {$adsoyad} <{$eposta}>\r\n";
		$header .= "Reply-To: {$adsoyad} <{$eposta}>\r\n";
		$mesaj = '<div style="padding: 10px; font-size: 17px; font-weight: bold">'.$konu.'</div>
		<div style="margin: 10px 0; border: 1px solid #ddd; padding: 10px; color: #333">'.nl2br($mesaj).'</div>
		<div style="border-top: 1px solid #ddd; padding: 10px 0; font-style: oblique; color: #aaa">Tüm Hakları Saklıdır. &copy; 2012 - Öğretiyor Blog Scripti</div>';
		if(mail(EPOSTA, $konu, $mesaj, $header)){
			return true;
		}else {
			return true;
		}
	}
	
	function getUserPosts ($uid){
		$query = query("SELECT count(konu_id) as toplam FROM konular WHERE konu_ekleyen = '$uid'");
		$row = row($query);
		return $row["toplam"];
	}
	
	function getAy($ay){
		if ($ay == "1"){
			$ay = "Ocak";
		} elseif ($ay == "2"){
			$ay = "Şubat";
		} elseif ($ay == "3"){
			$ay = "Mart";
		} elseif ($ay == "4"){
			$ay = "Nisan";
		} elseif ($ay == "5"){
			$ay = "Mayıs";
		} elseif ($ay == "6"){
			$ay = "Haziran";
		} elseif ($ay == "7"){
			$ay = "Temmuz";
		} elseif ($ay == "8"){
			$ay = "Ağustos";
		} elseif ($ay == "9"){
			$ay = "Eylül";
		} elseif ($ay == "10"){
			$ay = "Ekim";
		} elseif ($ay == "11"){
			$ay = "Kasım";
		} elseif ($ay == "12"){
			$ay = "Aralık";
		}
		return $ay;
	}
	
?>