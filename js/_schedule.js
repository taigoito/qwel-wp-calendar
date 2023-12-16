/**
 * Schedule
 * Author: Taigo Ito (https://qwel.design/)
 * Location: Fukui, Japan
 */

import Calendar from './_calendar.js';

export default class Schedule extends Calendar {
  makeCalendar(year, month) {
    super.makeCalendar(year, month);
    this.fetch(this.options.url);
  }

  async fetch(url) {
    const res = await fetch(`${url}`);
    const data = await res.json();

    console.log(data);

    this.render(data);

  }


  render(data) {
    data.forEach((dt) => {
      const status = dt.status;
      if (status !== 'publish' && status !== 'future') return;

      //const date = dt.date.slice(0, 10);
      const startDate = new Date(dt.attributes['start_date']);
      const endDate = new Date(dt.attributes['end_date']);
      const title = dt.title.rendered;
      //const content = dt.content.rendered;
      //const link = dt.link;
      const colors = dt.attributes.colors;

      const len = (endDate - startDate) / 86400000;
      if (len >= 0) {
        for (let i = 0; i <= len; i++) {
          // 開始～終了期間内の日にち要素を取得
          const date = startDate.toJSON().slice(0, 10);
          const elem = document.querySelector(`[data-date="${date}"]`);

          // カレンダーの内容を表示
          if (elem) {
            const p = document.createElement('p');
            p.textContent = title;
            if (colors && colors.length > 0) {
              colors.forEach((color) => {
                p.classList.add(`--${color.slug}`);
              });
            }
            elem.appendChild(p);
          }

          // 次の日にちへ
          startDate.setDate(startDate.getDate() + 1);
        }
      }
    });

  }

}
