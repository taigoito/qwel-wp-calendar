/**
 * Init
 * Author: Taigo Ito (https://qwel.design/)
 * Location: Fukui, Japan
 */

// Config
import { user, pw } from './config.js';

const url = '/wp-json/wp/v2/calendar?status=publish+future';

import Schedule from './_schedule.js';
new Schedule({
  url: url,
  user: user,
  pw: pw
});
