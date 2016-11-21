<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Giriş Yap - <?=TITLE?></title>
</head>
<body>

	<?php require __DIR__ . "/header.php"; ?>
	<div class="uye">
		<form action="#">
			<div class="mdl-card__title mdl-color--blue-500 mdl-card--expand">
    			<h2 class="mdl-card__title-text">Giriş Yap</h2>
  			</div>
			<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" type="email" id="eml">
		    	<label class="mdl-textfield__label" for="eml">E-posta...</label>
		    	<span class="mdl-textfield__error">Lütfen bir E-posta adresi giriniz!</span>
		  	</div>
		  	<div class="mdl-textfield mdl-js-textfield">
		    	<input class="mdl-textfield__input" data-val-required="true" type="password" id="sifre">
		    	<label class="mdl-textfield__label" for="sifre">Şifre...</label>
		    	<span class="mdl-textfield__error">Lütfen şifre alanın boş bırakmayınız...</span>
		  	</div>
		  	<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-500">Giriş Yap</button>
		</form>
	</div>
</body>
</html>