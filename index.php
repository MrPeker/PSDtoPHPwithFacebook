<?php 

	require_once('system/mysql.php');
	require_once('system/function.php');
 	require_once  'src/facebook.php'
	?>

	<?php

	Route('GET', '/', function(){
		//print_r($_SERVER);
		require_once('view/index.php');
	});

	Route('POST', '/search', function(){
		//
	});

	Route('GET', '/GirisYap', function(){
		require_once('view/girisyap.php');
	});
	Route('GET', '/uye', function(){
		
	});

	Route('GET', '/Kaydol', function(){
/*
			$userid = $fb->getUser();

			if( $userid ) 
			{
				try{
					$profile = $fb->api('/me');
				} catch ( FacebookApiException $e) {
					print $e->getMessage();
					$userid = null;
				}
			}
			if( $userid )
			{
				$logout = $fb->getLogoutUrl();
			}
			else 
			{
				$login = $fb->getLoginUrl(array(
					'email, public_profile, user_about_me, user_birthday, user_friends, read_custom_friendlists, user_managed_groups, user_groups'
					));
			}
			if( $userid )
			{
				print_r($profile);
			}
			else 
			{
				print '<a href="'.$login.'">Giriş Yap</a>';
			}


		*/
		require_once('view/kaydol.php');
	});

	Route('GET', '/CikisYap', function(){
		$fb = new Facebook(array(
			  'appId'  => FB_ID,
			  'secret' => FB_SECRET
			));
		session_destroy();
		go(BACK);
	});

	// Admin 
	Route("GET", "/admin" , function(){
	    require "sources.php"; 
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				require "view/admin/index.php";
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});

	Route("GET", "/admin/LogIn", function(){
		require "sources.php";
		if(isset($_SESSION["login"]) == true)
		{
			echo "İki kere giriş yapamazsın!";
			go(URL . "admin",1);
		}
		else 
		{
			require "view/admin/pages/examples/login.php";
		}
	});

	Route("GET", "/admin/uye/listele", function(){
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				
				require "view/admin/uye_listele.php";
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}

	});
	Route("GET", "/admin/uye/sil/(\d+)", function($id){
		//require "sources.php";
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				query("UPDATE uye SET sil=1 WHERE id=".$id." ");
				go(BACK);
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});
	Route("GET", "/admin/uye/engelikaldir/(\d+)", function($id)
	{
		//require "sources.php";
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				echo $id;
				query("UPDATE uye SET sil=0 WHERE id=".$id." ");
				go(BACK);
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});
	Route("GET", "/admin/uye/rutbe/(\d+)", function($id){
		//require "sources.php";
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				$quUye = query("SELECT rutbe FROM uye  WHERE id=".$id." ");
				$rowUye = row($quUye);
				if($rowUye["rutbe"] == 1)
				{
					query("UPDATE uye SET rutbe=0 WHERE id=".$id."");
				}else
				{
					query("UPDATE uye SET rutbe=1 WHERE id=".$id."");
				}
				go(BACK);
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});

	Route("GET", "/admin/reklam/ekle", function(){
		//require "sources.php";
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				require "view/admin/reklam_ekle.php";
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});
	Route("POST", "/admin/reklam/ekle", function(){
		if($_POST["url_a"] || $_POST["tarih"] || $_FILES["fileToUpload"]["name"] != "")
		{
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        echo "Dosya tipi - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "Dosya resim değil.";
		        $uploadOk = 0;
		    }
			$target_file = $target_dir . time() . "." . ext($target_file);

			    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			echo "Üzgünüm sadece GIF JPG JPEG ve PNG formatında resim kabul edilebilir.";
			$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			echo "Üzgünüm, dosya yüklenemedi.";
			// if everything is ok, try to upload file
			} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			    echo "Dosya ". basename( $_FILES["fileToUpload"]["name"]). " yüklendi.";
			} else {
			    echo "Üzgünüm dosya yüklenirken bir hata oluştu.";
			}
			}
			$rurl = p("url_a");
			$resim = $target_file;
			$tarih = p("tarih");
			$tarih_dizi = explode("/",$tarih);
			$tarih = $tarih_dizi[2] ."-".  $tarih_dizi[0] ."-". $tarih_dizi[1];
			$zaman =  date($tarih);
			$date = new DateTime($zaman);
			$tarih3 = $tarih;
			$tarih = $date->format("U");

			$quReklam = query("INSERT INTO reklam(link,resim,zaman,tarih) VALUES('".$rurl."','".$resim."','".$tarih."','".$tarih3."')");
			if(mysql_affected_rows() == 1)
			{
				//go(URL . "admin/reklam/listele");
			}
		}
		else
		{
			echo "Lütfen tüm alanları eksiksiz doldurunuz...";
		}
	});

	Route("GET", "/admin/reklam/listele", function(){
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				
				require "view/admin/reklam_listele.php";
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});

	Route("GET", "/admin/reklam/sil/(\d+)", function($id){
		//require "sources.php";
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				query("UPDATE reklam SET sil=1 WHERE id=".$id." ");
				go(BACK);
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});

	Route("GET", "/admin/reklam/engelikaldir/(\d+)", function($id)
	{
		//require "sources.php";
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				query("UPDATE reklam SET sil=0 WHERE id=".$id." ");
				go(BACK);
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});

	Route("GET", "/admin/reklam/duzenle/(\d+)", function($id)
	{
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{
				$quReklam = query("SELECT * FROM reklam WHERE id=".$id."");
				$rowReklam = row($quReklam);
				require "view/admin/reklam_duzenle.php";
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});
	Route("POST", "/admin/reklam/duzenle", function(){
		if(isset($_SESSION["login"]))
		{
			if($_SESSION["rutbe"] == 1)
			{

				if($_POST["url_a"] || $_POST["tarih"] || $_FILES["fileToUpload"]["name"] != "")
				{
					$target_dir = "uploads/";
					$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					// Check if image file is a actual image or fake image
				    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				    if($check !== false) {
				        echo "Dosya tipi - " . $check["mime"] . ".";
				        $uploadOk = 1;
				    } else {
				        echo "Dosya resim değil.";
				        $uploadOk = 0;
				    }
					$target_file = $target_dir . time() . "." . ext($target_file);

					    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "gif" ) {
					echo "Üzgünüm sadece GIF JPG JPEG ve PNG formatında resim kabul edilebilir.";
					$uploadOk = 0;
					}
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					echo "Üzgünüm, dosya yüklenemedi.";
					// if everything is ok, try to upload file
					} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					    echo "Dosya ". basename( $_FILES["fileToUpload"]["name"]). " yüklendi.";
					} else {
					    echo "Üzgünüm dosya yüklenirken bir hata oluştu.";
					}
					}
					$rurl = p("url_a");
					$resim = $target_file;
					$tarih = p("tarih");
					$tarih_dizi = explode("/",$tarih);
					$tarih = $tarih_dizi[2] ."-".  $tarih_dizi[0] ."-". $tarih_dizi[1];
					$zaman =  date($tarih);
					$date = new DateTime($zaman);
					$tarih3 = $tarih;
					$tarih = $date->format("U");
					$reklamID = p("id");
					echo $reklamID;
					$quReklam = query("UPDATE reklam SET link = '".$rurl."',resim = '".$resim."',tarih = '".$tarih3."', zaman = '".$tarih."' WHERE id=".$reklamID." ");
					echo mysql_error();
					if(mysql_affected_rows() == 1)
					{
						go(URL . "admin/reklam/listele");
					}
				}
				else
				{
					echo "Lütfen tüm alanları eksiksiz doldurunuz...";
				}
			}
			else 
			{
				echo "Buraya erişmeye yetkiniz bulunmamaktadır.";
				go(URL);
			}
		}
		else 
		{
			go(URL ."admin/LogIn");
		}
	});
	// #Admin
?>