<?php 

	$fb = new Facebook(array(
	  'appId'  => FB_ID,
	  'secret' => FB_SECRET
	));

		$posts = $fb->api('/1082080965214531/feed?fields=message,link,picture,name,caption,description,full_picture');
 		//print_r($posts['data']);
 		$p = 1;
 		?>
 		<div class="slider" id="slider1">
				    <ul>
		<?php 
 		foreach ($posts["data"] as  $value) 
 		{
 			
 			if(isset($value["full_picture"]))
 			{	
 				$post_id = $value["id"];
 				$post =  $fb->api("/".$post_id."?fields=from");
 				?>
				        <li>
				            <a href="https://facebook.com/<?=$value["id"]?>" target="_blank" style="text-decoration: none;">
				                <img src="<?php if(endsWith($value["link"], ".gif")){ ?> <?=$value["link"]?> <?php } else {?> <?=$value["full_picture"]?> <?php } ?>" fbid="<?=$value['id']?>" alt=""/>
				                <div class="sliderDiv">
									<span class="sliderSpan">
										<img style="width:25px; height:25px; border-radius: 25px;" src="https://graph.facebook.com/<?=$post['from']['id']?>/picture" />
										<a style="color: white; font-weight: bold;" target="_blank" href="https://facebook.com/<?=$post['from']['id']?>"> 
										 <?=$post["from"]["name"]?> </a> tarafından :  <br/> 
										 <?php if(isset($value['message'])){ ?>
										 	<?=$value['message']?> 
										 <?php } ?>
									</span>
								</div>
				            </a>
				        </li>
		<?php } 

		} ?>
							    </ul>
							    <a class="prev" href="#">Önceki</a>
							    <a class="next" href="#">Sonraki</a>
							    <div class="pagination"></div>
							</div>
							<div class="list">
							    <ul>
   		<?php 
   			foreach ($posts["data"] as  $value) 
	 		{
	 			
	 			if(isset($value["full_picture"]))
	 			{	?>
   		 
				        <li>
				            <a href="#">
				                <img src="<?=$value["picture"]?>" alt=""/>
				            </a>
				        </li>
		<?php } 
		} ?>
			</ul>
		</div> 
	<?php 
		/*
		
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
			");*/
	

?>
<script type="text/javascript">
    $(function(){

        $('#slider1').pSlider({
            slider: $('#slider1 ul li'),
            button: {
                next: $('#slider1 .next'),
                prev: $('#slider1 .prev')
            },
            start: 0,
            width: 500,
            height : 250,
            animation: true,
            loop: true,
            auto: true,
            easing: 'easeInOutBack',
            duration: 1500,
            time: 3000,
            keyboard: true,
            list: $('.list ul li')
        });

    });
    </script>