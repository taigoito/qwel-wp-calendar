/**
 * Init
 * Author: Taigo Ito (https://qwel.design/)
 * Location: Fukui, Japan
 */

const url = '/wp-json/wp/v2/calendar';

import Calendar from './_calendar.js';
new Calendar();

import Schedule from './_schedule.js';
new Schedule({ url: url });
