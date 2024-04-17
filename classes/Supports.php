<?php
namespace Qwel_WP_Calendar;

trait Supports {
  // テーマサポート機能
  public function setup_theme() {
    add_action( 'init', [ $this, 'register_calendar_as_post_type' ] );
  }

  public function register_calendar_as_post_type() {
    $name = '予定';
    register_post_type( 'calendar', [
      'labels' => [
        'name'           => $name,
        'singular_name'  => $name,
        'menu_name'      => 'カレンダー',
        'all_items'      => $name . '一覧',
        'new_item'       => '新規' . $name,
        'add_new_item'   => '新規' . $name . 'を追加',
        'edit_item'      => $name . 'を編集',
        'view_item'      => $name . 'を表示',
        'search_items'   => $name . 'を検索'
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
