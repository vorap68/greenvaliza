// skip-link-focus-fix.js
document.addEventListener('DOMContentLoaded', () => {
  const isWebkit = navigator.userAgent.toLowerCase().includes('webkit');
  const isOpera  = navigator.userAgent.toLowerCase().includes('opera');
  const isIE     = navigator.userAgent.toLowerCase().includes('msie');

  if ((isWebkit || isOpera || isIE) && document.getElementById && window.addEventListener) {
    window.addEventListener('hashchange', function () {
      const id = location.hash.substring(1);
      if (id) {
        const element = document.getElementById(id);
        if (element) {
          if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
          }
          element.focus();
        }
      }
    }, false);
  }
});
