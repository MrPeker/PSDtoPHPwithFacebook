<link rel="stylesheet" href="<?=URL?>css/material.min.css">
<link rel="stylesheet" href="<?=URL?>css/styles.css">
<link rel="stylesheet" href="//cdn.materialdesignicons.com/1.7.12/css/materialdesignicons.min.css">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.eot">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.svg">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.ttf">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.woff">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.woff2">
<link rel="stylesheet" href="<?=URL?>css/style-slider.css">
<script src="<?=URL?>js/jquery.js"></script>
<script src="<?=URL?>js/header.js"></script>
<script src="<?=URL?>js/material.min.js"></script>
<script src="<?=URL?>js/pSlider.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> 
<?php 
	$fb = new Facebook(array(
	  'appId'  => FB_ID,
	  'secret' => FB_SECRET
	));
	$user = $fb->getUser();
	if(empty($user))
	{
		$loginButton = $fb->getLoginUrl(array(
			"scope" => "email, user_birthday, user_photos, user_friends, user_managed_groups, user_managed_groups, user_about_me"
		));
		//echo "<a href=".$loginButton.">Facebook ile Kaydol (zorunlu)</a>";

	}else{

		$profile = $fb->api('/me?fields=last_name,first_name,about,birthday,email,gender,link');
		//print_r($profile);
		$id = $profile['id'];
		$ad =  $profile['first_name'];
		$soyad =  $profile['last_name'];
		$dtarihi =  $profile['birthday'];
		$email =  $profile['email'];
		$cinsiyet =  $profile['gender'];
		$link = $profile['link'];
		$avatar = "https://graph.facebook.com/".$id."/picture";
		$cinsiyet == 'male' ? $cinsiyet = 'Erkek' : $cinsiyet = 'Kadın';
		$qMevcut = query("SELECT * FROM uye WHERE fb_id=".$id."");
		$row = row($qMevcut);
		if(mysql_affected_rows() == 1)
		{
			$sesUye = array(
				"login" => true,
				"id" => $row['id'],
				"ad" => $row['ad'],
				"soyad" => $row['soyad'],
				"fb_id" => $row['fb_id'],
				"dogum_tarihi" => $row['dogum_tarihi'],
				"tarih" => $row['tarih'],
				"fb_link" => $row['fb_link'],
				"cinsiyet" => $row['cinsiyet'],
				"rutbe" => $row['rutbe'],
				"avatar"=> $row['avatar']
			);
			session_olustur($sesUye);
		}
		else 
		{
			$qUye = query("INSERT INTO uye(ad,soyad,eposta,cinsiyet,dogum_tarihi,avatar,fb_id,fb_link) VALUES('".$ad."','".$soyad."','".$email."','".$cinsiyet."','".$dtarihi."','".$avatar."','".$id."','".$link."')
				");
			$qMevcut = query("SELECT * FROM uye WHERE fb_id=".$id."");
			$row = row($qMevcut);
			$sesUye = array(
				"login" => true,
				"id" => $row['id'],
				"ad" => $row['ad'],
				"soyad" => $row['soyad'],
				"fb_id" => $row['fb_id'],
				"dogum_tarihi" => $row['dogum_tarihi'],
				"tarih" => $row['tarih'],
				"fb_link" => $row['fb_link'],
				"cinsiyet" => $row['cinsiyet'],
				"rutbe" => $row['rutbe'],
				"avatar"=> $row['avatar']
			);
			session_olustur($sesUye);
		}
	}

?>
<header>
	<a href="<?=URL?>">
		<div class="header-menu">
			<i class=""><img style="width:90px;height:90px;" src="<?=URL?>img/logo.png"/></i>
		</div>
	</a>
		<div class="header-pages">
			<ul>
				
				<li>
					<a href="">
						Facebook
					</a>
				</li>
				<li>
					<a href="">
						Twitter
					</a>
				</li>
				<li>
					<a href="">
						Instagram
					</a>
				</li>
				<li>
					<a href="">
						İletişim
					</a>
				</li>
				<li>
					<a href="">
						Hakkımızda
					</a>
				</li>

			</ul>
		</div>
		<div class="header-search">
			<form id="searchForm" action="<?=URL?>search" method="post">
				<i OnClick="searchClick()" class="mdi mdi-magnify"></i>

				<input style="display:none;" type="text" name="query">
			</form>
		</div>
		<div class="header-ozellik">
			<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="ark">
        		<i class="mdi mdi-account-multiple"></i>
			</button>

			<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right mdl-js-ripple-effect--ignore-events" for="ark">
	            <li class="mdl-menu__item mdl-js-ripple-effect">About</li>
	        </ul>
	        <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="mes">
        		<i class="mdi mdi-forum"></i>
			</button>

			<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right mdl-js-ripple-effect--ignore-events" for="mes">
	            <li class="mdl-menu__item mdl-js-ripple-effect">About</li>
	        </ul>
	        <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="bil">
        		<i class="mdi mdi-earth"></i>
			</button>

			<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right mdl-js-ripple-effect--ignore-events" for="bil">
	            <li class="mdl-menu__item mdl-js-ripple-effect">About</li>
	        </ul>
		</div>
		<div class="header-user">
			
			<?php 
				if(!isset($_SESSION["login"]))
				{
					echo "<a href='".$loginButton."'><button class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--blue-500 mdl-color-text--grey-50'> <i class='mdi mdi-facebook'></i> Giriş Yap / Kaydol</button></a>";
				}else 
				{ ?>
					<button style="position:relative;top:-15px;" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="uye">
		        		<img src="<?=session('avatar')?>" style="width:100%; height:100%" />
					</button>
					<a target="_blank"style="margin:3px; margin-top:10px; position:relative; top:-15px; color:#333; text-decoration:none; font-size:19px;" href="<?=session("fb_link")?>"><?=session("ad")?> <?=session("soyad")?></a>
					<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right mdl-js-ripple-effect--ignore-events" for="uye">
			            <a href='<?=URL?>CikisYap'><button class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--red-500 mdl-color-text--grey-50'> <i class='mdi mdi-logout'></i> Çıkış Yap</button></a>
			        </ul>
			    <?php 
				}
			?>

		</div>
</header>