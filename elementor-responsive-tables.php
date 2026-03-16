<?php
/**
 * Plugin Name: Elementor Responsive Tables
 * Description: A custom Elementor widget to easily create styled, responsive tables.
 * Version:     1.0.0
 * Author:      23Web
 * Author URI:  https://www.23web.dev
 * Text Domain: elementor-responsive-tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elementor Responsive Tables Class
 */
final class Elementor_Responsive_Tables_Extension {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Register Widget Hooks
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		
		// Register Frontend Scripts / Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
	}

	public function register_widgets( $widgets_manager ) {
		require_once( __DIR__ . '/widgets/responsive-table.php' );
		$widgets_manager->register( new \Elementor_Responsive_Table_Widget() );
	}

	public function widget_styles() {
		wp_register_style( 'elementor-responsive-table', plugins_url( 'assets/css/responsive-table.css', __FILE__ ), [], self::VERSION );
	}

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-responsive-tables' ),
			'<strong>' . esc_html__( 'Elementor Responsive Tables', 'elementor-responsive-tables' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-responsive-tables' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-responsive-tables' ),
			'<strong>' . esc_html__( 'Elementor Responsive Tables', 'elementor-responsive-tables' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-responsive-tables' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-responsive-tables' ),
			'<strong>' . esc_html__( 'Elementor Responsive Tables', 'elementor-responsive-tables' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-responsive-tables' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

Elementor_Responsive_Tables_Extension::instance();
