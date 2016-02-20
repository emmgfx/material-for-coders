<?php
class mfc_widget_portfolio extends WP_Widget {

	function __construct() {
		parent::__construct(
			'mfc_widget_portfolio',
			__('Home: Portfolio', 'material-for-coders'),
			array(
				'description' => __('The last 3 items of the portfolio in the home page.', 'material-for-coders'),
			)
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		echo '<div class="container">';
		echo '<div class="row">';
		global $wp_query;
		$wp_query = new WP_Query();

		$args = array(
			'post_type'			=> 'm4c_portfolio',
			'paged'				=> $paged,
			'posts_per_page'	=> 3
		);

		$wp_query->query($args);

		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			include(__DIR__.'/../portfolio_list_item.php');
		endwhile;

		echo '</div>';
		echo '<a href="#" class="btn btn-primary pull-right">Ir al portfolio</a>';
		echo '</div>';

		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'Title', 'wpb_widget_domain' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}
?>
