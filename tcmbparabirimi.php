<?php
/*
Plugin Name: Para Birimi
Plugin URI: http://dev.4gendesign.com/para-birimi
Description: Convert 19 different currencies. / 19 ülkenin para birimini çevirir.
Version: 4.0.1
Author: Ozibal
Author URI: http://dev.4gendesign.com
Text Domain: para-birimi
Domain Path: /languages
Licence : GPL2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2016 4gendesign.
*/

if ( !function_exists( 'add_action' ) ) {
	echo 'Opppss!!!';
	exit;
}

$plugin		= plugin_basename(__FILE__);
$plugindir	= dirname(__FILE__) . DIRECTORY_SEPARATOR;

define( 'PARABIRIMI_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'PARABIRIMI_DOWNLOAD_SERVICE', 'http://dev.4gendesign.com/tcmbparabirimi' );

require_once PARABIRIMI_PLUGIN_DIR. '/tcmbparabirimi-class.php';
require_once PARABIRIMI_PLUGIN_DIR. '/tcmbparabirimi-widget.php';

add_action ( 'admin_menu', 'tcmbparabirimi_menu');
function tcmbparabirimi_menu(){
	add_menu_page(
        'Para Birimi',
        'Para Birimi',
        'manage_options',
		'para-birimi/tcmbparabirimi-setting.php',
        '',
        plugins_url( 'images/tcmbparabirimi.png', __FILE__ ),
        81
    );
	
}

add_filter( "plugin_action_links_$plugin", 'parabirimi_pluginaddsettingslink' );
function parabirimi_pluginaddsettingslink( $links ) {
    $settings_link = '<a href="options-general.php?page=para-birimi/tcmbparabirimi-setting.php">' . __( 'Ayarlar', 'para-birimi' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}

add_action( 'admin_init', 'tcmbparabirimi_setting');
function tcmbparabirimi_setting() {

	register_setting( 'parabirimi-hub', 'parabirimi_from' );
	register_setting( 'parabirimi-hub', 'parabirimi_to' );
	register_setting( 'parabirimi-hub', 'parabirimi' );
	register_setting( 'parabirimi-hub', 'parabirimi_gettimestamp' );
	register_setting( 'parabirimi-hub', 'parabirimi_update' );
	register_setting( 'parabirimi-hub', 'pb_actives' );	

}
add_action( 'plugins_loaded', 'parabirimi_languagesload' );
function parabirimi_languagesload() {
	
	load_plugin_textdomain( 'para-birimi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}



class tcmbparabirimi {
	
	private $parabirimi;
	
	public function __construct() {
		
		$this->parabirimi = new tcmbparabirimiget;
		
		add_action( 'init', array( $this, 'tcmbparabirimi_plugin_init' ) );
		add_action( 'widgets_init', array( $this, 'tcmbparabirimi_plugin_widget_init' ) );
		add_filter('widget_text', 'do_shortcode'); 
		add_shortcode( 'ParaBirimi', array( $this, 'tcmbparabirimi_plugin_shortcode' ) );
	}

	public function tcmbparabirimi_plugin_init(){
			wp_enqueue_style( 'tcmbparabirimi_style', plugins_url( $plugindir."tcmbparabirimi-style.css", __FILE__ ), array(), '1.0' );
	}

	public function tcmbparabirimi_plugin_widget_init(){
		register_widget('tcmbparabirimiwidget');
	}

	public function tcmbparabirimi_plugin_shortcode($atts = array()){
	
		if($atts){
			
			$pb = array ('TRY', 'USD', 'AUD', 'DKK', 'EUR', 'GBP', 'CHF', 'SEK', 'CAD', 'KWD', 'NOK', 'SAR', 'JPY', 'BGN', 'RON', 'RUB', 'IRR', 'CNY', 'PKR');
			
			if ( in_array(esc_html( $atts[2] ), $pb)  and in_array(esc_html( $atts[3] ), $pb)) {
				$result = $this->parabirimi->tcmbparabirimi_data(esc_html( $atts[2] ), esc_html( $atts[3] ));
				// Restore Database	   
				$this->tcmbconverter->tcmbconverter_data(get_option( 'parabirimi_from' ), get_option( 'parabirimi_to' ));
				$flag = "<div class='pb_symboladmin ". esc_html( $atts[3]) ."'>&nbsp;</div>";
			}else{
				$result = get_option( 'parabirimi' );
				$flag = "<div class='pb_symboladmin ". get_option( 'parabirimi_to' ) ."'>&nbsp;</div>";
			}
			
			

			
			if ( esc_html( $atts[0] ) == 'Simple'){ 
				if ( esc_html( $atts[1] ) > 1) {
					
					$shortcode_content = $result * esc_html( $atts[1] );

				} else{
					$shortcode_content = $result;
				}
				
			} else if ( esc_html( $atts[0] ) == 'Flag'){ 
				if ( esc_html( $atts[1] ) > 1) {
					$shortcode_content = $flag.($result * esc_html( $atts[1] ));

				} else{
					$shortcode_content = $flag.$result;
				}
				
			}
			
			
		}else{
			$shortcode_content = "<div class='parabirimi_shortcode'><span title='" . __( ' ! Günceleme hatası : Veri çekilemedi... ', 'para-birimi' ). "' class='parabirimi_update'>".get_option( 'parabirimi_update' )."</span>&nbsp;<span class='parabirimi_from'>".get_option( 'parabirimi_from' )."</span>&nbsp;<span class='parabirimi_to'>".get_option( 'parabirimi_to' )."</span>&nbsp;&nbsp;<span class='parabirimi'>".get_option( 'parabirimi' )."</span></div>";		
		} 

		return $shortcode_content;	
	}

}

$parabirimi = new tcmbparabirimi;