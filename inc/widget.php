<?php 

/**
 * Adds cref_Widget widget.
 */
class cref_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'cref_widget', // Base ID
			__('Contact Referral', 'contact-reference'), // Name
			array( 'description' => __( 'Contact Referral Data Widget', 'contact-reference' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		/*
		Set Default ID
		*/

		if(is_null($_SESSION['cref_view'])) {
			$_SESSION['cref_view'] = get_option('cref_default');
		}

		$cref_option_hide = get_option('cref_hide');
		settype($cref_option_hide, "boolean");
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$widget_style = $instance['widget_style'];

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		echo '<ul>';
		$loop = array( 'post_type' => 'refcontact', 'post_status' => 'publish', 'posts_per_page' => 1, 'name' => $_SESSION['cref_view'] );
    	$loop = new WP_Query( $loop );
    	while ( $loop->have_posts() ) : $loop->the_post();
    	$cref_custom_field = get_post_custom();
    	
    	// Display Photo
    	if( isset($cref_custom_field['photo'][0] )) {
    		$image = wp_get_attachment_image_src( $cref_custom_field['photo'][0], 'thumbnail' );
    		echo '<li class="cref_photo"><img src="'.$image[0].'" /></li>';
    	}
    	// Display Name
    	if(isset($cref_custom_field['name'][0])) 
    		echo '<li><label>' . __('Name','contact-reference') . ':</label>'.$cref_custom_field['name'][0].'</li>';
    	// Display Address
    	if(isset($cref_custom_field['address'][0])) 
    		echo '<li><label>' . __('Address','contact-reference') . ':</label>'.$cref_custom_field['address'][0].'</li>';
    	// Display Phone
    	if(isset($cref_custom_field['phone'][0])) 
    		echo '<li><label>' . __('Phone','contact-reference') . ':</label>'.$cref_custom_field['phone'][0].'</li>';

	    	if ($widget_style == 'full') {
		    	// Display Email
		    	if(isset($cref_custom_field['email'][0])) 
		    		echo '<li><label>' . __('Email','contact-reference') . ':</label>'.$cref_custom_field['email'][0].'</li>';
		    	// Display Yahoo Messenger
		    	if(isset($cref_custom_field['yahoo_messenger'][0])) 
		    		echo '<li><label>' . __('Yahoo Messenger','contact-reference') . ':</label>'.$cref_custom_field['yahoo_messenger'][0].'</li>';
		    	// Display gplus
		    	if(isset($cref_custom_field['gplus'][0])) 
		    		echo '<li><label>' . __('Gplus','contact-reference') . ':</label>'.$cref_custom_field['gplus'][0].'</li>';
		    	//Display Facebook URL
		    	if(isset($cref_custom_field['facebook_url'][0])) 
		    		echo '<li><label>' . __('Facebook','contact-reference') . ':</label>'.$cref_custom_field['facebook_url'][0].'</li>';
		    	// Display Twitter Username
		    	if(isset($cref_custom_field['twitter_username'][0])) 
		    		echo '<li><label>' . __('Twitter Username','contact-reference') . ':</label>'.$cref_custom_field['twitter_username'][0].'</li>';
		    } else {
		    	if(isset($cref_custom_field['email'][0])) 
		    		echo '<li class="simple" title="email"><a href="mailto:'.$cref_custom_field['email'][0].'"><span class="genericon genericon-mail"></span></a></li>';
		    	// Display Yahoo Messenger
		    	if(isset($cref_custom_field['yahoo_messenger'][0])) 
		    		echo '<li class="simple" title="Yahoo Messenger"><a href="ymsgr:'.$cref_custom_field['yahoo_messenger'][0].'"><span class="genericon genericon-chat"></span></a></li>';
		    	// Display gplus
		    	if(isset($cref_custom_field['gplus'][0])) 
		    		echo '<li class="simple" title="Google Plus"><a href="'.$cref_custom_field['gplus'][0].'"><span class="genericon genericon-googleplus-alt"></span></a></li>';
		    	//Display Facebook URL
		    	if(isset($cref_custom_field['facebook_url'][0])) 
		    		echo '<li class="simple" title="Facebook"><a href="'.$cref_custom_field['facebook_url'][0].'"><span class="genericon genericon-facebook"></span></a></li>';
		    	// Display Twitter Username
		    	if(isset($cref_custom_field['twitter_username'][0])) 
		    		echo '<li class="simple" title="Twitter"><a href="http://twitter.com/'.$cref_custom_field['twitter_username'][0].'"><span class="genericon genericon-twitter"></span></a></li>';
	    	}

    	endwhile;
    	echo '</ul>';
		echo $args['after_widget'];


	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Reach Me', 'contact-reference' );
		}
		$widget_style = $instance [ 'widget_style' ];
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'contact-reference' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'widget_style' ); ?>"><?php _e( 'Widget Style:','contact-reference' ); ?></label> <br />
		<select name="<?php echo $this->get_field_name( 'widget_style' ); ?>" id="<?php echo $this->get_field_id( 'widget_style' ); ?>" class="widefat">
			<option value="simple" <?php selected( $widget_style, 'simple', true ); ?>>Simple</option>
			<option value="full" <?php selected( $widget_style, 'full', true ); ?>>Full</option>
		</select>
		</p>
		<?php

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['widget_style'] = $new_instance['widget_style'];

		return $instance;
		
	}

} // class cref_Widget

// register cref_Widget widget
function register_cref_widget() {
    register_widget( 'cref_Widget' );
}
add_action( 'widgets_init', 'register_cref_widget' );