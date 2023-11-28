<?php
namespace Qwel_WP_Calendar;

trait Supports {
  // テーマサポート機能
  public function setup_theme() {
    // カスタム投稿タイプ, タクソノミーを登録
    add_action( 'init', [ $this, 'register_calendar_as_post_type' ] );
    
    // REST API にて表示
    add_action( 'rest_api_init', [ $this, 'register_calendar_tax' ] );
  }

  public function register_calendar_as_post_type() {
    register_post_type( 'calendar', [
      'labels' => [
        'name'           => '予定',
        'singular_name'  => '予定',
        'menu_name'      => 'カレンダー',
        'all_items'      => '予定一覧',
        'new_item'       => '新規予定',
        'add_new_item'   => '新規予定を追加',
        'edit_item'      => '予定を編集',
        'view_item'      => '予定を表示',
        'search_items'   => '予定を検索'
      ],
      'public'         => true,
      'has_archive'    => false,
      'menu_icon'      => 'dashicons-calendar-alt',
      'menu_position'  => 25,
      'show_in_rest'   => true,
      'supports'       => [
        'title',
        'editor',
        'thumbnail'
      ]
    ] );

    register_taxonomy( 'color','calendar', [
      'labels' => [
        'name' => '色'
      ],
      'hierarchical' => true,
      'show_in_rest' => true,
    ] );
  }

  public function register_calendar_tax() {
    register_rest_field( 'calendar', 'taxonomy', [
      'get_callback' => [ $this, 'get_calendar_tax' ]
    ] );
  }

  public function get_calendar_tax( $object ) {
    $tax = get_the_terms( $object[ 'id' ], 'color' );
    return $tax;
  }

}
