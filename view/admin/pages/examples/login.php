<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="<?=URL?>css/styles.css">
<link rel="stylesheet" href="//cdn.materialdesignicons.com/1.7.12/css/materialdesignicons.min.css">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.eot">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.svg">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.ttf">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.woff">
<link rel="stylesheet" href="<?=URL?>fonts/materialdesignicons-webfont.woff2">
<link rel="stylesheet" href="<?=URL?>css/material.min.css">
<script src="<?=URL?>js/jquery.js"></script>
<script src="<?=URL?>js/header.js"></script>
<script src="<?=URL?>js/material.min.js"></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
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
if(isset($_SESSION['login']))
{
  go( URL . "admin");
}else 
{
  echo "<center><a href='".$loginButton."'><button class='mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--blue-500 mdl-color-text--grey-50'> <i class='mdi mdi-facebook'></i> Giriş Yap / Kaydol</button></a></center>";
}

?>
</div>

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
