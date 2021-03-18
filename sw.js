// proper initialization
if( 'function' === typeof importScripts) {

importScripts('/jscript/workbox/workbox-sw.js');

workbox.setConfig({
  modulePathPrefix: '/jscript/workbox/'
});

workbox.routing.registerRoute(
  // Cache JS files.
  /\.js$/,
  // Use cache but update in the background.
  new workbox.strategies.NetworkFirst({
    // Use a custom cache name.
    cacheName: 'js-cache',
  })
);

workbox.routing.registerRoute(
  // Cache CSS files.
  /\.css$/,
  // Use cache but update in the background.
  new workbox.strategies.NetworkFirst({
    // Use a custom cache name.
    cacheName: 'css-cache',
  })
);

workbox.routing.registerRoute(
  // Cache image files.
  /\.(?:png|jpg|jpeg|svg|gif|ico)$/,
  // Use the cache if it's available.
  new workbox.strategies.NetworkFirst({
    // Use a custom cache name.
    cacheName: 'image-cache',
  })
);

workbox.routing.registerRoute(
  // Cache font files.
  /\.(?:ttf|woff|woff2|eot)$/,
  // Use the cache if it's available.
  new workbox.strategies.CacheFirst({
    // Use a custom cache name.
    cacheName: 'font-cache',
  })
);

workbox.routing.registerRoute(
  // Cache pages.
  /\//,
  // Use cache but update in the background.
  new workbox.strategies.NetworkFirst({
    // Use a custom cache name.
    cacheName: 'page-cache',
  })
);


var FALLBACK_HTML_URL = "/db_error.htm";

workbox.precaching.precacheAndRoute([FALLBACK_HTML_URL]);

workbox.routing.setDefaultHandler(new workbox.strategies.NetworkOnly());

workbox.routing.setCatchHandler(({event}) => {
  switch (event.request.destination) {
    case "document":
      return caches.match(FALLBACK_HTML_URL);
      break;
    default:
      return Response.error();
  }
});

}