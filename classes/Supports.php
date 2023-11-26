<?php
namespace Qwel_WP_Calendar;

trait Supports {
  // テーマサポート機能
  public function setup_theme() {
    add_action( 'init', [ $this, 'register_calendar_as_post_type' ] );
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
      ]
    );
  }

}
