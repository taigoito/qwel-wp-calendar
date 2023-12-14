<?php
namespace Qwel_WP_Calendar;

trait Shortcodes {
  // ショートコード登録
  public function register_shortcode() {

    // カレンダーを作成
    add_shortcode( 'calendar', [ $this, 'get_calendar' ] );
    
  }

  public function get_calendar( $atts ) {
    // デフォルト値
    $year = getdate()[ 'year' ];
    $month = getdate()[ 'mon' ];
    $atts = shortcode_atts(
      [
        'year' => $year,
        'month' => $month
      ],
      $atts
    );

    $atts[ 'month' ]--;

    $html = <<<DOC
    <div id="calendar" class="calendar" data-year="{$atts[ 'year' ]}" data-month="{$atts[ 'month' ]}">
      <div class="calendar__control">
        <a id="calendarPrev" class="calendar__prev" href="#">&lt; <span id="calendarPrevText"></span></a>
        <span id="calendarCurrentText"></span>
        <a id="calendarNext" class="calendar__next" href="#"><span id="calendarNextText"></span> &gt;</a>
      </div>
      <table class="calendar__view">
        <thead id="calendarHead"></thead>
        <tbody id="calendarBody"></tbody>
      </table>
    </div>
    DOC;

    return $html;

  }

}
