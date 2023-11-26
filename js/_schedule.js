/**
 * Schedule
 * Author: Taigo Ito (https://qwel.design/)
 * Location: Fukui, Japan
 */

export default class Schedule {
  constructor(options = {}) {
    this.options = options;

    // データを取得
    this.fetch(this.options.url);

  }


  async fetch(url) {
    const res = await fetch(`${url}`);
    const data = await res.json();

    console.log(data);

  }

}
