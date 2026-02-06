<?php if (!defined('ABSPATH')) exit; ?>(function(g,e,o,id,t,a,r,ge,tl,y,s){
  g.getElementsByTagName(o)[0].insertAdjacentHTML('afterbegin','<style id="georedirect<?php echo esc_js($resourceId) ?>style">body{opacity:0.0 !important;}</style>');
  s=function(){g.getElementById('georedirect<?php echo esc_js($resourceId) ?>style').innerHTML='body{opacity:1.0 !important;}';};
  t=g.getElementsByTagName(o)[0];y=g.createElement(e);y.async=true;
  y.src='https://g10102301085.co/gr?id=<?php echo esc_js($resourceId) ?>&refurl='+g.referrer+'&winurl='+encodeURIComponent(window.location);
  t.parentNode.insertBefore(y,t);y.onerror=function(){s()};
  georedirectLoaded="undefined" != typeof georedirectLoaded ? georedirectLoaded:{};
  georedirectLoaded['<?php echo esc_js($resourceId) ?>'] = function(redirect){var to=0;if(redirect){to=5000};setTimeout(function(){s();},to)};
  setTimeout(function(){s();}, 8000);
})(document,'script','head');