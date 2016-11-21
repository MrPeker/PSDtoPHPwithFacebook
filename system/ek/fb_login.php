<?php 

	$facebook = new Facebook(array(
	  'appId'  => FB_ID,
	  'secret' => FB_SECRET,
	));

	// kullanıcı giriş yapmış ise onun kullanıcı id'sini alalım
	$userid = $facebook->getUser();

	// eğer kullanıcı giriş yapmışsa profil ve arkadaş listesi bilgilerini alalım
	if ( $userid ){
	    try {
	        $profile = $facebook->api('/me');
	        $friendlists = $facebook->api('/me/friends');
	    } catch ( FacebookApiException $e ){
	        print $e->getMessage();
	        $userid = null;
	    }
	}

	// giriş ve çıkış url'lerini belirleyelim
	if ( $userid ){
	    $logout = $facebook->getLogoutUrl(array(
	        'next' => 'http://www.erbilen.net/facebook/index.php?do=logout'
	    ));
	} else {
	    $login = $facebook->getLoginUrl(array(
	        'scope' => 'email, public_profile, user_about_me, user_birthday, user_friends, read_custom_friendlists, user_managed_groups, user_groups'
	    ));
	}

	// profil ve arkadaş listesi bilgilerini yazdıralım
	if ( $userid ){

	    print '<a href="'.$logout.'">Çıkış Yap</a>';

	    print '<h2>Kişisel Bilgiler</h2>';
	    // print_r($profile);
	    foreach ( $profile as $key => $val ){
	        if ( !is_array($val) )
	            print $key.' : '.$val.'<br />';
	    }

	    print '<h2>Arkadaş Listen</h2>';
	    // print_r($friendlists);
	    foreach ( $friendlists['data'] as $friend ){
	        print '<a href="https://facebook.com/profile.php?id='.$friend['id'].'" target="_blank" style="float: left; margin: 2px">
	        <img src="https://graph.facebook.com/'.$friend['id'].'/picture" width="20" height="20" />
	        </a>';
	    }
	}
?>