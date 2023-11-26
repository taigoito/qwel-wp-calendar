<?php
/*
Plugin Name: Qwel WP Calendar
Description: This is a simple calendar plugin.
Version: 1.0
Requires PHP: 7.4
Author: Taigo Ito
Author URI: https://qwel.design/
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */


defined( 'ABSPATH' ) || exit;


/*
 * プラグインのパス, URI
 */
define( 'QWEL_WP_CALENDAR_DIR', WP_PLUGIN_DIR . '/qwel-wp-calendar/' );
define( 'QWEL_WP_CALENDAR_URI', WP_PLUGIN_URL . '/qwel-wp-calendar/' );


/*
 * classのオートロード
 */
spl_autoload_register(
	function( $classname ) {
		if ( strpos( $classname, 'Qwel_WP_Calendar' ) === false ) return;
		$classname = str_replace( '\\', '/', $classname );
		$classname = str_replace( 'Qwel_WP_Calendar/', '', $classname );
		$file      = QWEL_WP_CALENDAR_DIR . '/classes/' . $classname . '.php';
		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

class Qwel_WP_Calendar {
  use \Qwel_WP_Calendar\Supports,
		\Qwel_WP_Calendar\Scripts,
    \Qwel_WP_Calendar\Shortcodes;
		
	public function __construct() {
		// テーマサポート機能
		$this->setup_theme();
    
    // CSS, JSファイルを読み込み (フロント)
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    
    // ショートコード登録
    add_action( 'init', [ $this, 'register_shortcode' ] );

	}

}

new Qwel_WP_Calendar();
