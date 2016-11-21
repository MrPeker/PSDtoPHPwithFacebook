<?php ?>
<div class=" demo-card mdl-card mdl-shadow--16dp" style="width:400px; position: absolute; top:110px; left:670px; margin-top:10px; height:360px;">
	<?php 
		?>
		<div class="mdl-card__title mdl-color--blue-500 mdl-card--expand">
    <h2 class="mdl-card__title-text">Reklamlar</h2>
  </div>
		<?php
		$time = time();
		//echo $time;
		$kacReklamVar = row(query("SELECT COUNT(*) FROM reklam WHERE zaman > ".$time." AND sil=0 "));
		$kacReklamVar = $kacReklamVar[0];
		$rastgele = rand(1 , $kacReklamVar );
		//echo $rastgele;
		$reklamlar = query("SELECT * FROM reklam  WHERE zaman > ".$time." AND sil=0 ");
		$i = 0;
		while($reklam = row($reklamlar))
		{
			$i += 1;
			if($i == $rastgele)
			{
				?>

					<a style="outline: 5px solid #fff;" target="blank" href="<?=$reklam["link"]?>"><img style="width:400px; height:300px;" src="<?=URL?><?=$reklam["resim"]?>" /></a>

				<?php
			}
		}
		//print_r($reklamlar);


	?>
</div>