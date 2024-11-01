<?php
/**
Plugin Name: statistX
Plugin URI: http://www.statistx.com/plugin/wordpress/
Description: statistX adds a configurable hit counter to your WordPress blog. It also includes a web traffic and search/keyword -analysis. To get your free statistX ID, simply visit <a href="http://www.statistx.com/signup.php" target="_blank">www.statistx.com/signup.php</a> and: 1. enter your desired username 2. enter your website's URL 3. select the counter style you like 4. opt for top 100 inclusion for valuable backlinks 5. enter the captcha code 6. press "Signup" 7. write down or save your statistX ID and password 8. insert your statistX ID in the widget parameters 9. press "Save". Visit <a href="http://www.statistx.com" target="_blank">www.statistx.com</a> and <a href="http://www.statistx.com/top10.php" target="_blank">statistX Top100</a>.
Version: 1.0.0
Author: Yatko
Author URI: http://www.yatko.com

 * statistX Widget is free software. This version may have been modified pursuant
 * to the GNU General Public License.
 * 
 * the statistX Widget is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 * 
 * statistX Widget is distributed as is, without any warranty.
 * See the GNU General Public License for more details.
 * 
 * See <http://www.gnu.org/licenses/> for the GNU General Public License.


/**
 * Add function to widgets_init to load the widget.
 * @since 1.0.0
 */
add_action( 'widgets_init', 'statistx_load_widgets' );

/**
 * Register the statistx_Widget widget.
 * @since 1.0.0
 */
function statistx_load_widgets() {
	register_widget( 'statistx_Widget' );
}

/**
 * statistx Widget class, handles the settings, form, display, and update.
 * @since 1.0.0
 */
class statistx_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function statistx_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'statistx', 'description' => __('Displays the hit counter and tracks/creates traffic analisys using www.statistX.com free service.', 'statistx') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'statistx-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'statistx-widget', __('statistX Widget', 'statistx'), $widget_ops, $control_ops );
	}

	/**
	 * Display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* The variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$statistxID = $instance['statistX_ID'];
		$statistxAlign = $instance['statistX_Align'];
		$statistxBGColor = $instance['statistX_BGColor'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

?>
<div style="text-align: <?php echo $statistxAlign; ?>; background-color: <?php echo $statistxBGColor; ?>;">
<script language="JavaScript">
<!--

  // Start statistX code for statistX 2.0
  var data = '&r=' + escape(document.referrer)
	+ '&n=' + escape(navigator.userAgent)
	+ '&p=' + escape(navigator.userAgent)
	+ '&g=' + escape(document.location.href);

  if (navigator.userAgent.substring(0,1)>'3')
    data = data + '&sd=' + screen.colorDepth 
	+ '&sw=' + escape(screen.width+'x'+screen.height);

  document.write('<a href="http://www.statistx.com/stats.php?i=<?php echo $statistxID; ?>" target=\"_blank\" >');
  document.write('<img border=0 hspace=0 '+'vspace=0 src="http://www.statistx.com/counter.php?i=<?php echo $statistxID; ?>' + data + '" title="Free Hit Counters and Web Stats" alt="statistX Hit Counter">');
  document.write('</a>');
  // End statistX code for statistX 2.0

// -->
</script>
</div>
<?php		

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['statistX_ID'] = strip_tags( $new_instance['statistX_ID'] );
		$instance['statistX_Align'] = strip_tags( $new_instance['statistX_Align'] );
		$instance['statistX_BGColor'] = strip_tags( $new_instance['statistX_BGColor'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up default widget settings. */
		$defaults = array( 'title' => __('statistX', 'statistx'), 'statistX_ID' => __('0', 'statistx'), 'statistX_Align' => __('center', 'statistx'), 'statistX_BGColor' => __('transparent', 'statistx'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- statistX ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'statistX_ID' ); ?>"><?php _e('statistX ID:', '0'); ?></label>
			<input id="<?php echo $this->get_field_id( 'statistX_ID' ); ?>" name="<?php echo $this->get_field_name( 'statistX_ID' ); ?>" value="<?php echo $instance['statistX_ID']; ?>" style="width:100%;" />
		</p>
		
		<!-- Align: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'statistX_Align' ); ?>"><?php _e('Align:', 'center'); ?></label>
			<select id="<?php echo $this->get_field_id( 'statistX_Align' ); ?>" name="<?php echo $this->get_field_name( 'statistX_Align' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'center' == $instance['format'] ) echo 'selected="selected"'; ?>>center</option>
				<option <?php if ( 'left' == $instance['format'] ) echo 'selected="selected"'; ?>>left</option>
				<option <?php if ( 'right' == $instance['format'] ) echo 'selected="selected"'; ?>>right</option>
			</select>
		</p>

		<!-- BG Color: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'statistX_BGColor' ); ?>"><?php _e('BG Color:', 'transparent'); ?></label> 
			<input id="<?php echo $this->get_field_id( 'statistX_BGColor' ); ?>" name="<?php echo $this->get_field_name( 'statistX_BGColor' ); ?>" value="<?php echo $instance['statistX_BGColor']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>