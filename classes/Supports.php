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
    $post_date = get_the_date( 'Y-m-d', $post->ID );
    $start_date = get_post_meta( $post->ID, 'start_date', true );
    if ( !$start_date ) $start_date = $post_date;
    $end_date = get_post_meta( $post->ID, 'end_date', true );
    if ( !$end_date ) $end_date = $post_date;
?>
  
<form method="post" action="admin.php?page=site_settings">
  <label for="startDate">開始日: </label>
  <input id="startDate" type="date" name="startDate" value="<?php echo $start_date ?>">
  <label for="endDate">終了日: </label>
  <input id="endDate" type="date" name="endDate" value="<?php echo $end_date ?>">
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
  }

  public function register_calendar_attrs() {
    register_rest_field( 'calendar', 'attributes', [
      'get_callback' => [ $this, 'get_calendar_attrs' ]
    ] );
  }

  public function get_calendar_attrs( $object ) {
    $start_date = get_post_meta( $object[ 'id' ], 'start_date', true );
    $end_date = get_post_meta( $object[ 'id' ], 'end_date', true );
    $colors = get_the_terms( $object[ 'id' ], 'color' );
    return [
      'start_date' => $start_date,
      'end_date'   => $end_date,
      'colors'     => $colors
    ];
  }

}
