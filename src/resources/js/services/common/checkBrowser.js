import { BROWSER } from '../../const/common.js';

export function checkBrowser() {
  const userAgent = window.navigator.userAgent.toLowerCase();

  if (userAgent.indexOf('msie') != -1 ||
    userAgent.indexOf('trident') != -1) {
    return BROWSER.IE;
  } else if (userAgent.indexOf('Edg') != -1) {
    return BROWSER.EDGE;
  } else if (userAgent.indexOf('chrome') != -1) {
    return BROWSER.CHROME;
  } else if (userAgent.indexOf('safari') != -1) {
    return BROWSER.SAFARI;
  } else if (userAgent.indexOf('firefox') != -1) {
    return BROWSER.FIREFOX;
  } else if (userAgent.indexOf('opera') != -1) {
    return BROWSER.OPERA;
  } else {
    return BROWSER.OTHER;
  }
}
