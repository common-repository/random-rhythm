<?php
/*
Plugin Name: Random Rhythm
Plugin URI: http://www.woodymood-dev.net/cms/wordpress/en/2009/04/26/generateur-aleatoire-rythmes-de-guitare/
Description: Random generator of guitar rhythms 
Version: 0.4
Author: Anthony Dubois
Author URI: http://www.woodymood-dev.net/cms/wordpress/en/lauteur/
*/

/*  Copyright 2009-2010  ANTHONY DUBOIS  (email : dev@woodymood-dev.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*******************************************************************


			widget class for wordpress 2.8 compatibility


********************************************************************/

class RandomRhythm extends WP_Widget {

	function RandomRhythm() {
		parent::WP_Widget(false, $name = 'RandomRhythm');	
	}

	function widget( $args, $instance ) {
		random_rhythm_widget($args, $instance);
	}
	
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
	    $title = esc_attr($instance['title']);
        ?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Title:'); ?> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</label>
		</p>
        <?php 
    }
	
}



/*******************************************************************


				init


********************************************************************/

// new widget load since worpdress 2.8
add_action('widgets_init', create_function('', 'return register_widget("RandomRhythm");'));

add_action( "init", "random_rhythm_init" );

function random_rhythm_init() {

	load_plugin_textdomain('random_rhythm', PLUGINDIR . '/' . dirname(plugin_basename (__FILE__)) . '/lang');
	
}


/*******************************************************************


				menu d'administration
		(will come back later if new options come)


********************************************************************/
/*
add_action('admin_menu', 'random_rhythm_menu');

function random_rhythm_menu() {

  add_options_page('Random Rhythm', 'Random Rhythm', 8, __FILE__, 'random_rhythm_admin');
}


function random_rhythm_admin() {
	?>
	<div class="wrap">
	<h2><?php _e('Random Rhythm', 'random_rhythm') ?></h2>
	<?php 

	if( @$_POST['random_rhythm'] == 'admin') {
			
		?>
		<div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
		<?php
	}

	echo '
	
	<form name="form1" method="post" action="' . $_SERVER['REQUEST_URI'] . '">
	
	<input type="hidden" name="random_rhythm" value="admin" />
	
	<table class="form-table">
	

	</table>
	
	<p class="submit">
	<input type="submit" class="button-primary" value="' . __('Save Changes') . '" />
	</p>
	</form>
	
	</div>';
}
*/

/*******************************************************************


				widget view


********************************************************************/

// widget function
// new argument $instance since wordpress 2.8
function random_rhythm_widget($args, $instance) {

	extract($args);

	$content = random_rhythm();
	
	$title = $instance['title'];
	
	if ( $title == false || $title == '' ) $title = __('Random guitar rhythm', 'random_rhythm'); 
	
	if ( $content != '' ) {  
	
		echo $before_widget . $before_title . $title . $after_title . $content . $after_widget;
	}
}



/*******************************************************************


				ajax


********************************************************************/


add_action('wp_head', 'random_rhythm_js_header' );

function random_rhythm_js_header() {

	// use JavaScript SACK library for Ajax
	wp_print_scripts( array( 'sack' ));
 
	?>
	<script type="text/javascript">
	//<![CDATA[
	function random_rhythm_refresh() {
		var mysack = new sack("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/random-rhythm/include/random_rhythm_ajax.php");
		mysack.execute = 1;
		mysack.method = 'POST';
		mysack.onError = function() { alert('Ajax error') };
		mysack.runAJAX();
		return true;
	} 
	//]]>
	</script>
	<?php
}



require_once('include/random_rhythm_func.php');


?>