<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Kaydol - <?=TITLE?></title>
</head>
<body>
	
	<?php require_once __DIR__ . "/header.php"; ?>
	<div class="uye">
	<!--
		<form action="#">
			<div class="mdl-card__title mdl-color--red-500 mdl-card--expand">
    			<h2 class="mdl-card__title-text">Kaydol</h2>
  			</div>
  			<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" data-val-required="true" type="text" name="ad" id="ad">
		    	<label class="mdl-textfield__label" for="ad">Ad...</label>
		    	<span class="mdl-textfield__error">Lütfen şifre alanın boş bırakmayınız...</span>
		  	</div>
		  	<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" data-val-required="true" type="text" name="soyad" id="sifre">
		    	<label class="mdl-textfield__label" for="sifre">Soyad...</label>
		    	<span class="mdl-textfield__error">Lütfen şifre alanın boş bırakmayınız...</span>
		  	</div>
			<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" type="email" name="eml" id="eml">
		    	<label class="mdl-textfield__label" for="eml">E-posta...</label>
		    	<span class="mdl-textfield__error">Lütfen bir E-posta adresi giriniz!</span>
		  	</div>
		  	<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" data-val-required="true" name="sifre" type="password" id="sifre">
		    	<label class="mdl-textfield__label" for="sifre">Şifre...</label>
		    	<span class="mdl-textfield__error">Lütfen şifre alanın boş bırakmayınız...</span>
		  	</div>
		  	<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" data-val-required="true" type="password" name="sifre2" id="sifre2">
		    	<label class="mdl-textfield__label" for="sifre2">Şifre Tekrar...</label>
		    	<span class="mdl-textfield__error">Lütfen şifre alanın boş bırakmayınız...</span>
		  	</div>
		  	<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--red-500">Kaydol</button>
		</form>
		-->
		<?php
		 	$fb = new Facebook(array(
			  'appId'  => FB_ID,
			  'secret' => FB_SECRET
			));
			/*
			$user = $fb->getUser();
			//print_r($user);
			if (empty($user))
			{
				$login = $fb->getLoginUrl(array(
					'scope' => 'user_friends, public_profile, user_about_me, user_managed_groups, user_birthday, user_photos'
				));

				print "<a href='".$login."'>Facebook ile Kaydol (zorunlu)</a>";
			}
			else 
			{
				$profil = $fb->api('/me');
				print_r($profil);
				$id = $profil['id'];
				$profilresmi = 'https://graph.facebook.com/'.$id.'/picture';
				//echo "<img src='".$profilresmi. "'/>";
				
				$query = $fb->api('/me?fields=last_name');

				print_r($query);
			}
			*/
			$user = $fb->getUser();
			if(empty($user))
			{
				$loginButton = $fb->getLoginUrl(array(
					"scope" => "email, user_birthday, user_photos, user_friends, user_managed_groups, user_managed_groups, user_about_me"
				));
				echo "<a href=".$loginButton.">Facebook ile Kaydol (zorunlu)</a>";

			}else{
				$profile = $fb->api('/me?fields=last_name,first_name,about,birthday,email,gender,link');
				print_r($profile);
				$id = $profile['id'];
				$ad =  $profile['first_name'];
				$soyad =  $profile['last_name'];
				$dtarihi =  $profile['birthday'];
				$email =  $profile['email'];
				$cinsiyet =  $profile['gender'];
				$link = $profile['link'];
				$avatar = "https://graph.facebook.com/".$id."/picture";
				$cinsiyet == 'male' ? $cinsiyet = 'Erkek' : $cinsiyet = 'Kadın';	
				$qUye = query("INSERT INTO uye(ad,soyad,eposta,cinsiyet,dogum_tarihi,avatar,fb_id,fb_link) VALUES('".$ad."','".$soyad."','".$email."','".$cinsiyet."','".$dtarihi."','".$avatar."','".$id."','".$link."')
					");
			}

		?>

	</div>
</body>
</html>