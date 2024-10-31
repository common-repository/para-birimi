<?php

class tcmbparabirimiwidget extends WP_Widget {
	
	private $parabirimi;

	public function __construct() {
		
		$this->parabirimi = new tcmbparabirimiget;
		
		
		$params = array(
			'name'			=> 'Para Birimi',
			'description'	=> 'Bu bileşen dönüştürülen Para Birimi bilgilerini gösterir.'
		);
		parent::__construct('tcmbparabirimiwidget','',$params);
	}
	
	public function form( $instance ) {
		$pb_title	= isset($instance['title']) ? esc_attr( $instance['title'] )	: '';
		?>
        <p>
        	<label for ="<?php echo $this->get_field_id( 'title' ); ?>"><strong>Başlık</strong>  
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $pb_title; ?>" />
            </label>
        </p>
        <?php
		$pb_buy	= isset($instance['buy']) ? esc_attr( $instance['buy'] )	: '';
		?>
        <p>
        	<label for ="<?php echo $this->get_field_id( 'buy' ); ?>"><strong>Alış Başlığı</strong>  
            <input class="widefat" id="<?php echo $this->get_field_id( 'buy' ); ?>" name="<?php echo $this->get_field_name( 'buy' ); ?>" type="text" value="<?php echo $pb_buy; ?>" />
            </label>
        </p>
        <?php
		$pb_sell	= isset($instance['sell']) ? esc_attr( $instance['sell'] )	: '';
		?>
        <p>
        	<label for ="<?php echo $this->get_field_id( 'sell' ); ?>"><strong>Satış Başlığı</strong>  
            <input class="widefat" id="<?php echo $this->get_field_id( 'sell' ); ?>" name="<?php echo $this->get_field_name( 'sell' ); ?>" type="text" value="<?php echo $pb_sell; ?>" />
            </label>
        </p>
        <?php
	}
	
	public function widget( $args, $instance ) {
		
		extract($args, EXTR_SKIP);
		$pb_title = $instance['title'];
		$pb_buy = $instance['buy'];
		$pb_sell = $instance['sell'];
		
		echo $before_widget;
		
		if ( $pb_title ){ echo $before_title . $pb_title . $after_title; }
		
		$widget_content = "<div class='parabirimi_widget'>";
		
			$widget_content .= "<div class='pb_labels'>";
				$widget_content .= "<span title=' ! Günceleme hatası : Veri çekilemedi...'>".get_option( 'parabirimi_update' )."</span>&nbsp;<span class='pb_buytag'>".get_option( 'parabirimi_from' )."</span>";
				if( $pb_buy) $widget_content .= "<div class='pb_label'>".$pb_buy."</div>";
				if( $pb_sell) $widget_content .= "<div class='pb_label'>".$pb_sell."</div>";
			$widget_content .= "</div>";
			
			$widget_content .= "<div class='pb_widgetrows'>";
				$widget_content .= get_option( 'parabirimi_widget' );
			$widget_content .="</div>";
		
		$widget_content .= "</div>";
		
		echo $widget_content;
		
		echo $after_widget;
	}
	
}