/**
 * Init
 * Author: Taigo Ito (https://qwel.design/)
 * Location: Fukui, Japan
 */

const url = '/wp-json/wp/v2/calendar?per_page=1000';

import Schedule from './_schedule.js';
new Schedule({ url: url, startOnMon: true });
