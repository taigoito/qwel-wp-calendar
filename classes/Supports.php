<?php
namespace Qwel_WP_Calendar;

trait Supports {
  // テーマサポート機能
  public function setup_theme() {
    // カスタム投稿タイプ, タクソノミーを登録
    add_action( 'init', [ $this, 'register_calendar_as_post_type' ] );
    
    // カスタムフィールドを作成
    add_action( 'admin_menu', [ $this, 'create_meta_boxes' ] );

    // カスタムフィールドの値を保存
    add_action( 'save_post', [ $this, 'save_meta_boxes' ] );
    
    // REST API にて表示
    add_action( 'rest_api_init', [ $this, 'register_calendar_attrs' ] );

    // 取得記事数を1000件
    add_filter('rest_calendar_collection_params', [ $this, 'change_calendar_limit' ], 10, 2 );
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
    ] );

    register_taxonomy( 'color','calendar', [
      'labels' => [
        'name' => '色'
      ],
      'hierarchical' => true,
      'show_in_rest' => true,
    ] );
  }

  public function create_meta_boxes() {
    add_meta_box(
      'calendar-setting',
      'カレンダー設定',
      [ $this, 'insert_meta_boxes' ],
      'calendar'
    );
  }

  public function insert_meta_boxes() {
    global $post;
    // カレンダー開始日・終了日
    $post_date = get_the_date( 'Y-m-d', $post->ID );
    $start_date = get_post_meta( $post->ID, 'start_date', true );
    if ( !$start_date ) $start_date = $post_date;
    $end_date = get_post_meta( $post->ID, 'end_date', true );
    if ( !$end_date ) $end_date = $post_date;
    // リンクURL
    $url = get_post_meta( $post->ID, 'detail_url', true );
?>
  
<form method="post" action="admin.php?page=site_settings">
  <label for="startDate">開始日: </label>
  <input id="startDate" type="date" name="startDate" value="<?php echo $start_date ?>">
  <label for="endDate">終了日: </label>
  <input id="endDate" type="date" name="endDate" value="<?php echo $end_date ?>">
  <label for="endDate">URL: </label>
  <input id="url" type="url" name="url" value="<?php echo $url ?>">
</form>
  
<?php
  }

  public function save_meta_boxes( $post_id ) {
    if ( isset( $_POST[ 'startDate' ] ) ) {
      update_post_meta( $post_id, 'start_date', $_POST[ 'startDate' ] );
    }
    if ( isset( $_POST[ 'endDate' ] ) ) {
      update_post_meta( $post_id, 'end_date', $_POST[ 'endDate' ] );
    }
    if ( isset( $_POST[ 'url' ] ) ) {
      update_post_meta( $post_id, 'detail_url', $_POST[ 'url' ] );
    }
  }

  public function register_calendar_attrs() {
    register_rest_field( 'calendar', 'attributes', [
      'get_callback' => [ $this, 'get_calendar_attrs' ]
    ] );
  }

  public function get_calendar_attrs( $object ) {
    $start_date = get_post_meta( $object[ 'id' ], 'start_date', true );
    $end_date = get_post_meta( $object[ 'id' ], 'end_date', true );
    $url = get_post_meta( $object[ 'id' ], 'detail_url', true );
    $colors = get_the_terms( $object[ 'id' ], 'color' );
    return [
      'start_date' => $start_date,
      'end_date'   => $end_date,
      'detail_url' => $url,
      'colors'     => $colors
    ];
  }

  public function change_calendar_limit( $params, $post_type ) {
    $params[ 'per_page' ][ 'maximum' ] = 1000;
    return $params;
  }

}
