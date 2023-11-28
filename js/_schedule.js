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

    this.render(data);

  }


  render(data) {
    data.forEach((dt) => {
      const status = dt.status;
      if (status !== 'publish' && status !== 'future') return;

      const date = dt.date.slice(0, 10);
      const title = dt.title.rendered;
      //const content = dt.content.rendered;
      //const link = dt.link;
      const taxonomy = dt.taxonomy;

      const elem = document.querySelector(`[data-date="${date}"]`);
      if (!elem) return;

      const p = document.createElement('p');
      p.textContent = title;
      if (taxonomy && taxonomy.length > 0) {
        taxonomy.forEach((tax) => {
          p.classList.add(`--${tax.slug}`);
        });
      }
      elem.appendChild(p);

    });

  }

}
