<?php
class JP_Admin_Functions {
	function __construct() {
		add_action( 'wp_enqueue_scripts', array($this, 'front_enqueue_styles') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_styles') );
		add_action( 'admin_menu', array($this, 'nb_admin_menu_option') );
		add_shortcode('notice_box', array($this, 'notice_box') );
	}

	function enqueue_styles() {
		global $pagenow;
		if ( $pagenow == "admin.php" ){
			if ( $_GET['page'] == "nb_admin_menu_option" ){
				wp_enqueue_style( 'plugin-admin-css', NB_PLUGIN . 'assests/css/admin-css.css', array(), 1.0, 'all' );
				wp_enqueue_style( 'front-end-css', NB_PLUGIN . 'assests/css/front-css.css', array(), 1.0, 'all' );
				wp_enqueue_script( 'jquery_script', NB_PLUGIN . 'assests/js/jquery.min.js', array('jquery'), '', false);
				wp_enqueue_script( 'frontend_script', NB_PLUGIN . 'assests/js/front.js', array( 'jquery_script' ), 1.0, true);
			}
		}
	}

	function front_enqueue_styles(){
		wp_enqueue_style( 'front-end-css', NB_PLUGIN . 'assests/css/front-css.css', array(), 1.0, 'all' );
		wp_enqueue_script( 'jquery_script', NB_PLUGIN . 'assests/js/jquery.min.js', array('jquery'), '', false);
		wp_enqueue_script( 'frontend_script', NB_PLUGIN . 'assests/js/front.js', array( 'jquery_script' ), 1.0, true);
	}

	function nb_admin_menu_option(){
		add_menu_page( NB_NAME , NB_NAME , 'manage_options', 'nb_admin_menu_option',array($this, 'gb_gwd_page_setting'),'dashicons-warning',200);
	}

	function gb_gwd_page_setting(){
		global $pagenow;
		/* Page HTML */ ?>
		<div class="row">
			<h2><?php echo NB_NAME; ?> - Settings</h2>
			<ul class="info_list">
				<li><p class="info">To show Notice Box use the following shortcode on any page.<span class="shortcode">[notice_box]</span></p></li>
				<li><p class="info">Following attributes can be used with short code:</p>
					<ul class="info_list">
						<li><p class="info">Heading - Heading to be used for Notice Box.</p></li>
						<li><p class="info">Message - Message to be shown in Notice Box.</p></li>
						<li><p class="info">Box Type - What type of Notice Box to be used.</p></li>
						<li><p class="info">Folloing "Box Type" attibutes can be used for Notice Box (this attribute is not case sensitive).</p>
							<ul class="info_list">
								<li><p class="info"><span class="shortcode">Danger</span></p></li>
								<li><p class="info"><span class="shortcode">Success</span></p></li>
								<li><p class="info"><span class="shortcode">Info</span></p></li>
								<li><p class="info"><span class="shortcode">Warning</span></p></li>
							</ul>
						</li>
					</ul>
				</li>
				<li><p class="info">Short Code</p></li>
				<li><p class="info">[notice_box heading="Notice Box Heading!" message="Notice Box Message." box_type="info"]</p></li>
			</ul>

			<?php
			echo do_shortcode( '[notice_box heading="This is Notice Box Heading!" message="Hello! This is Notice Box Message. This Notice Box has Box Type Danger" box_type="Danger" allow_close="yes"]' );
			echo do_shortcode( '[notice_box heading="This is Notice Box Heading!" message="Hello! This is Notice Box Message. This Notice Box has Box Type Danger" box_type="success"]' );
			echo do_shortcode( '[notice_box heading="This is Notice Box Heading!" message="Hello! This is Notice Box Message. This Notice Box has Box Type Danger" box_type="info"]' );
			echo do_shortcode( '[notice_box heading="This is Notice Box Heading!" message="Hello! This is Notice Box Message. This Notice Box has Box Type Danger" box_type="warning"]' );
			?>
		</div>
		<?php
	}

	// Add Shortcode
	function notice_box( $atts ) {
		// Attributes
		$atts = shortcode_atts(
			array(
				'heading' => 'Heading',
				'message' => 'Message',
				'box_type' => 'info',
				'allow_close' => 'no',
			),
			$atts
		);

		$box_heading = $atts['heading'];
		$msg = $atts['message'];
		$css_class = strtolower($atts['box_type']);
		$allow_close = $atts['allow_close'];

		$NoticeBox = '';
		$NoticeBox = '<div class="notice_box ' . $css_class . '">';
		$NoticeBox .= '<b>' . $box_heading . '</b> <p>' . $msg . '</p>';
		if ( $allow_close == 'yes' ){
			$NoticeBox .= '<span class="close_cross">x</span>';
		}
		$NoticeBox .= '</div>';
		return $NoticeBox;
	}
}

if ( class_exists( 'JP_Admin_Functions' ) ) {
    $JP_Admin_Functions = new JP_Admin_Functions();
}
?>
