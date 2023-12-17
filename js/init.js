/**
 * Init
 * Author: Taigo Ito (https://qwel.design/)
 * Location: Fukui, Japan
 */

const url = '/wp-json/wp/v2/calendar';

import Schedule from './_schedule.js';
new Schedule({ url: url, startOnMon: true });
