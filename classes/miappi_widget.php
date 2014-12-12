<?php

class Miappi_Widget extends WP_Widget {

	private $embed_view;

	public function __construct() {
		// Widget set-up
		parent::__construct( 'miappi_widget', 'Miappi Social Wall', 'text_domain', array(
			'description' => 'Show all your Social feeds and hashtag content in one widget', 'text_domain',
		) );

		// Create View Instance
		$this->embed_view = new Miappi_Embed_View();
	}

	public function form( $instance ) {
		// Merge default values with the current values for this instance
		$instance = wp_parse_args( (array) $instance, $this->embed_view->default_attributes() );

		// Show the form
		?>

        <h4>Settings</h4>

		<p>
			<label for="<?php echo $this->get_field_id( 'user' ); ?>"><?php _e('User') ?>: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'user' ); ?>" name="<?php echo $this->get_field_name( 'user' ); ?>" value="<?php echo esc_attr ( $instance['user'] ); ?>" />
			<br><small>E.g. miappi</small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'fontsize' ); ?>"><?php _e('Font Size') ?>: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'fontsize' ); ?>" name="<?php echo $this->get_field_name( 'fontsize' ); ?>" value="<?php echo esc_attr ( $instance['fontsize'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'bgcolor' ); ?>"><?php _e('Background Color') ?>: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'bgcolor' ); ?>" name="<?php echo $this->get_field_name( 'bgcolor' ); ?>" value="<?php echo esc_attr ( $instance['bgcolor'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Widget Width') ?>: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo esc_attr ( $instance['width'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Widget Height') ?>: </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo esc_attr ( $instance['height'] ); ?>" />
		</p>

		<?php

	}

	public function update( $new_instance, $old_instance ) {
		// Widget settings
		$instance = $old_instance;

		// Overwrite original instance data with new data
		if ( ! empty( $new_instance['fontsize'] ) ) {
			$instance['fontsize'] = strip_tags( $new_instance['fontsize'] );
		}

		if ( ! empty( $new_instance['bgcolor'] ) ) {
			$instance['bgcolor'] = strip_tags( $new_instance['bgcolor'] );
		}

		if ( ! empty( $new_instance['width'] ) ) {
			$instance['width'] = strip_tags( $new_instance['width'] );
		}

		if ( ! empty( $new_instance['height'] ) ) {
			$instance['height'] = strip_tags( $new_instance['height'] );
		}

		if ( ! empty( $new_instance['user'] ) ) {
			$instance['user'] = strip_tags( $new_instance['user'] );
		}

		// Send back the updated instance
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		// Handle changes to the title
		$title = apply_filters('widget_title', $instance['title']);
		if ( ! empty( $title ) ) { 
			echo $before_title . $title . $after_title;
		}

		// Build attributes array
		$attributes = array();

		if ( ! empty( $instance['fontsize'] ) ) {
			$attributes['fontsize'] = $instance['fontsize'];
		}

		if ( ! empty( $instance['bgcolor'] ) ) {
			$attributes['bgcolor'] = $instance['bgcolor'];
		}

		if ( ! empty( $instance['width'] ) ) {
			$attributes['width'] = $instance['width'];
		}

		if ( ! empty( $instance['height'] ) ) {
			$attributes['height'] = $instance['height'];
		}

		if ( ! empty( $instance['user'] ) ) {
			$attributes['user'] = $instance['user'];
		}

		// Render the widget
		$this->embed_view->generate( $attributes, true );

		echo $after_widget;
	}

}
