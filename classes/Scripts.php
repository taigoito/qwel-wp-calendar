<?php
namespace Qwel_WP_Calendar;

trait Scripts {
  // CSS, JSファイルを読み込み (フロント)
  public function enqueue_scripts() {
    // バージョン情報
    if( !function_exists( 'get_plugin_data' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    $plugin_data = get_plugin_data( __FILE__ );
    $version     = $plugin_data['Version'];

		// style.css
		wp_enqueue_style(
			'qwel-wp-calendar',
			plugins_url( '../style.css', __FILE__ ),
			[],
      $version
		);

    // init.js (フロントエンドのみ)
    if ( !is_admin() ) {
      wp_enqueue_script(
        'qwel-wp-calendar',
        plugins_url( '../init.js', __FILE__ ),
        [],
        $version,
        true
      );
    }

  }

}
