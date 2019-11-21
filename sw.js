// proper initialization
if( 'function' === typeof importScripts) {

importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

workbox.routing.registerRoute(
  // Cache JS files.
  /\.js$/,
  // Use cache but update in the background.
  new workbox.strategies.StaleWhileRevalidate({
    // Use a custom cache name.
    cacheName: 'js-cache',
  })
);

workbox.routing.registerRoute(
  // Cache CSS files.
  /\.css$/,
  // Use cache but update in the background.
  new workbox.strategies.StaleWhileRevalidate({
    // Use a custom cache name.
    cacheName: 'css-cache',
  })
);

workbox.routing.registerRoute(
  // Cache image files.
  /\.(?:png|jpg|jpeg|svg|gif|ico)$/,
  // Use the cache if it's available.
  new workbox.strategies.CacheFirst({
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

}