<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo __('Para Birimi Wordpress Plugin Sayfasına Hoş Geldiniz.', 'para-birimi' ); ?></title>
</head>

<body>
<form method="post" action="options.php">
<h2><?php echo __('Para Birimi', 'para-birimi' ); ?><div style="float:right; padding-right:50px;"></h2>
<hr />
<?php
$parabirimi_array = array ('TRY'=>__('TÜRK LİRASI', 'para-birimi' ), 'USD'=>__('AMERİKAN DOLARI', 'para-birimi' ), 'AUD'=>__('AVUSTRALYA DOLARI', 'para-birimi' ), 'DKK'=>__('DANİMARKA KRONU', 'para-birimi' ), 'EUR'=>__('EURO', 'para-birimi' ), 'GBP'=>__('İNGİLİZ STERLİNİ', 'para-birimi' ), 'CHF'=>__('İSVİÇRE FRANGI', 'para-birimi' ), 'SEK'=>__('İSVEÇ KRONU', 'para-birimi' ), 'CAD'=>__('KANADA DOLARI', 'para-birimi' ), 'KWD'=>__('KUVEYT DİNARI', 'para-birimi' ), 'NOK'=>__('NORVEÇ KRONU', 'para-birimi' ), 'SAR'=>__('SUUDİ ARABİSTAN RİYALİ', 'para-birimi' ), 'JPY'=>__('JAPON YENİ', 'para-birimi' ), 'BGN'=>__('BULGAR LEVASI', 'para-birimi' ), 'RON'=>__('RUMEN LEYİ', 'para-birimi' ), 'RUB'=>__('RUS RUBLESİ', 'para-birimi' ), 'IRR'=>__('İRAN RİYALİ', 'para-birimi' ), 'CNY'=>__('ÇİN YUANI', 'para-birimi' ), 'PKR'=>__('PAKİSTAN RUPİSİ'));

echo __( '<p>Bu plugin, TCMB (Türkiye Cumhuriyeti Merkez Bankası) tarafından yayınlanan xml formatındaki veriden faydalanarak para birimleri arasında çevrim yapar. 
  <br />
  Yapılan çevrim TRY (Türk Lirası) baz alınarak yapılır. Bu da çok ufak küsarat farklılıkları oluşturmaktadır.</p>', 'para-birimi' );
?>

<hr />
<p>
<h2>ShortCode : <strong>[ParaBirimi]</strong> </h2>
<?php echo "<div class='parabirimi_shortcode'><span title='" .__( ' ! Günceleme hatası : Veri çekilemedi... ', 'para-birimi' ). "' class='parabirimi_update'>".get_option( 'parabirimi_update' )."</span>&nbsp;<span class='parabirimi_from'>".get_option( 'parabirimi_from' )."</span>&nbsp;<span class='parabirimi_to'>".get_option( 'parabirimi_to' )."</span>&nbsp;&nbsp;<span class='parabirimi'>".get_option( 'parabirimi' )."</span></div>"; ?>
</p>
<hr />

<div> 
	<?php settings_fields ( 'parabirimi-hub' ); ?>
    <?php do_settings_sections ( 'parabirimi-hub' ); ?>
    <select name="parabirimi_from">
	<?php    
    foreach($parabirimi_array AS $tag=>$desc){
		$select_opt = '';
		if ( get_option( 'parabirimi_from' ) == $tag) $select_opt = 'selected';
        echo '<option '.$select_opt.' value="'.$tag.'">'.$desc.'</option>';
    }    
    ?>
    </select> ==>
    <select name="parabirimi_to">
	<?php    
    foreach($parabirimi_array AS $tag=>$desc){
		$select_opt = '';
		if ( get_option( 'parabirimi_to' ) == $tag) $select_opt = 'selected';
        echo '<option '.$select_opt.' value="'.$tag.'">'.$desc.'</option>'; 
	}    
    ?>
    </select>   
    <h2>Widget : </h2
    ><p>
		<?php	
		$pb_actives = get_option( 'pb_actives' );	
		echo "<div class='pb_admincol'>";
        foreach($parabirimi_array AS $tag=>$desc){
            $pb_widgetrow++;
				//echo "<input type='checkbox' name='pb_actives[" .$tag. "]' value='1'".checked( 1 == $pb_actives[$tag] )."/> <div class='pb_symboladmin " .$tag. "'>&nbsp;</div> ".$desc. "[ " .$tag." ] </br>";
				?><input type="checkbox" name="pb_actives[<?php echo $tag; ?>]" value="1"<?php checked( 1 == $pb_actives[$tag] ); ?>/> <div class="pb_symboladmin <?php echo $tag; ?>">&nbsp;</div> <?php echo $desc. "[ " .$tag." ]"; ?> </br><?php
            	if($pb_widgetrow == '6' OR $pb_widgetrow == '12' OR $pb_widgetrow == '19') echo "</div><div class='pb_admincol'>";
         } 
         echo "</div>";
		 ?>
    </p>
<table cellspacing="0">
    <tbody>
    <tr valign="top"><td colspan="3"><a href="https://codecanyon.net/item/19-different-currencies-instant-converter-for-woocommerce/19466196?ref=Ozibal" target="_blank"><h2>▢ PLUS VER </h2></a></td></tr>
    <tr valign="top"><td colspan="3"><?php echo __( ' Woocommerce ürün sayfalarında, sepet ve ödeme sayfasında para birimini 16 farklı para birimine dönüştürür.', 'para-birimi' ); ?></td></tr>
    <tr valign="top">
        <td><div class='card'>
        <p><a href="https://codecanyon.net/item/19-different-currencies-instant-converter-for-woocommerce/19466196?ref=Ozibal" target="_blank">▢ <?php echo __( ' WooCommerce Ürün Sayfaları ', 'para-birimi' ); ?> </a></p>
    <img width="100%" src="<?php echo plugins_url( 'images/wooCommerceproductpages.png', __FILE__ ); ?>"></div></td>
        <td><div class='card'>
    	<p><a href="https://codecanyon.net/item/19-different-currencies-instant-converter-for-woocommerce/19466196?ref=Ozibal" target="_blank">▢ <?php echo __( ' WooCommerce Sepet Sayfası ', 'para-birimi' ); ?> </a></p>
    <img width="100%" src="<?php echo plugins_url( 'images/wooCommercecartpage.png', __FILE__ ); ?>"></div></td>
        <td><div class='card'>
    	<p><a href="https://codecanyon.net/item/19-different-currencies-instant-converter-for-woocommerce/19466196?ref=Ozibal" target="_blank">▢ <?php echo __( ' WooCommerce Ödeme Sayfası ', 'para-birimi' ); ?> </a>  </p>
    <img width="100%" src="<?php echo plugins_url( 'images/wooCommerceorderpage.png', __FILE__ ); ?>"></div></td>
    </tr>
    </tbody>
</table>
	<?php submit_button(); ?>
</form>
</div>
<hr />

</body>
</html>