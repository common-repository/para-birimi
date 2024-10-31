<?php

Class tcmbparabirimiget {
	
	private $parabirimi_from;
	private $parabirimi_to;
	private $parabirimi;
	private $parabirimi_gettimestamp;
	private $nowtimestamp;
	private $parabirimi_widget;

	
	public function __construct() {
		
		if(!get_option( 'parabirimi_from' ) OR get_option( 'parabirimi_from' ) == '') update_option( 'parabirimi_from', 'TRY' ); 
		if(!get_option( 'parabirimi_to' ) OR get_option( 'parabirimi_to' ) == '') update_option( 'parabirimi_to', 'USD' );
		if(!get_option( 'parabirimi' ) OR get_option( 'parabirimi' ) == '') update_option( 'parabirimi', 1 );

		$this->parabirimi_from = get_option( 'parabirimi_from' );
		$this->parabirimi_to = get_option( 'parabirimi_to' );
		$this->parabirimi = get_option( 'parabirimi' );
		$this->parabirimi_gettimestamp = get_option( 'parabirimi_gettimestamp' );
		$this->nowtimestamp = current_time( 'timestamp' );
		$this->tcmbparabirimi_control();

	}
	
	public function tcmbparabirimi_control(){
		if( ! empty( $this->parabirimi ) && ( $this->nowtimestamp - $this->parabirimi_gettimestamp ) < 900 ) {
			return $this->parabirimi;
		} else {
			return $this->tcmbparabirimi_data($this->parabirimi_from, $this->parabirimi_to);
		}
	}

	public function tcmbparabirimi_data($from, $to){
		
		$from_bvalue = 1; 
		$from_svalue = 1;
		$to_bvalue = 1; 
		$to_svalue = 1;
		
		if(empty( $from )) update_option( 'parabirimi_from', 'TRY' ); 
		if(empty( $to )) update_option( 'parabirimi_to', 'USD' );
		
		$pb_activescontrol = array ('TRY'=>'', 'USD'=>'', 'AUD'=>'', 'DKK'=>'', 'EUR'=>'', 'GBP'=>'', 'CHF'=>'', 'SEK'=>'', 'CAD'=>'', 'KWD'=>'', 'NOK'=>'', 'SAR'=>'', 'JPY'=>'', 'BGN'=>'', 'RON'=>'', 'RUB'=>'', 'IRR'=>'', 'CNY'=>'', 'PKR'=>'');
		if(!get_option( 'pb_actives' ) OR get_option( 'pb_actives' ) == '') update_option( 'pb_actives', $pb_activescontrol );
		
		$pb_actives = get_option( 'pb_actives' );
		
		$xml = simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');
		foreach($xml->Currency as $group => $item){	
			
			if($item['CurrencyCode'] == $from AND $item['CurrencyCode'] != 'TRY'){
				$from_svalue = number_format(substr(trim($item->ForexSelling),0,6),4);
				$from_bvalue = number_format(substr(trim($item->ForexBuying),0,6),4);
			}
			if($item['CurrencyCode'] == $to AND $item['CurrencyCode'] != 'TRY'){
				$to_svalue = number_format(substr(trim($item->ForexSelling),0,6),4);
				$to_bvalue = number_format(substr(trim($item->ForexBuying),0,6),4);
			}
		}
		// TRY

		if($pb_actives["TRY"] == 1) { $parabirimi_widget .="<div class='pb_widgetrow'><div class='pb_symbol TRY' style='background-color:#FFFFFF'>TRY</div><div class='pb_buy'>" .number_format(1/$from_bvalue, 4, '.', ''). "</div><div class='pb_sell'>" .number_format(1/$from_svalue, 4, '.', '')."</div></div>"; }
		
		foreach($xml->Currency as $group => $item){	// Widget
			if($item->ForexSelling != ''){
				$widget_bvalue = number_format(substr(trim($item->ForexBuying),0,6),4);
				$widget_svalue = number_format(substr(trim($item->ForexSelling),0,6),4);
				$pb_CurrencyCode = $item['CurrencyCode'];
				if($item['CurrencyCode'] != $from AND $item['CurrencyCode'] != 'TRY' AND $item['CurrencyCode'] != 'XDR' AND $pb_actives["$pb_CurrencyCode"] == 1){
					$pb_widgetrow++;
					if($pb_widgetrow%2==1){ $bgcolor="#F3F3F3"; } else{ $bgcolor="#FFFFFF";}
					$parabirimi_widget .="<div class='pb_widgetrow'><div class='pb_symbol " .$item['CurrencyCode']. "'  style='background-color:" .$bgcolor. "'>" .$item['CurrencyCode']. "</div><div class='pb_buy'>" .number_format($from_bvalue / $widget_bvalue, 4, '.', ''). "</div><div class='pb_sell'>" .number_format($from_svalue / $widget_svalue, 4, '.', '')."</div></div>";
				}
			}
		}

		$parabirimi_result = number_format($from_svalue / $to_svalue, 4, '.', '');
		
		update_option( 'parabirimi_widget', $parabirimi_widget );
		update_option( 'parabirimi', $parabirimi_result );
		update_option( 'parabirimi_gettimestamp', current_time( 'timestamp' ) );
		if( $USDsell == '0' || empty($parabirimi_result) ){ update_option( 'parabirimi_update', '!' ); }
	 	else{ update_option( 'parabirimi_update', ' ' ); }
		
		return $parabirimi_result;	
	}

}