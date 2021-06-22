/**
 * Imports
 */
importScripts('/public-assets/utils');

/**
 * Sistema de cache de ficheros JS
 */
const CACHE_JS_NOMBRE = 'cache-js-v1';

const CACHE_JS_FICHEROS = [
    '/public-assets/js?path=home',
    '/public-assets/js?path=404',
    '/public-assets/js?path=offline'
];

/**
 * Sistema de cache de ficheros css
 */
const CACHE_CSS_NOMBRE = 'cache-css-v1';

const CACHE_CSS_FICHEROS = [
    '/public-assets/css?path=home',
    '/public-assets/css?path=404',
    '/public-assets/css?path=offline'
];

/**
 * Sistema de cache de imagenes fijas
 */
const CACHE_IMG_ESTATICAS_NOMBRE = 'img-estaticas-v1';

const CACHE_IMG_ESTATICAS_FICHEROS = [
    '/public-assets/imagenes?path=logo_portada.png',
    '/public-assets/imagenes?path=fondo.jpg',
    '/public-assets/imagenes?path=servicios.jpg',
    '/public-assets/imagenes?path=patron.jpg',
    '/public-assets/imagenes?path=construccion.webp',
    '/public-assets/imagenes?path=logo_mascota.webp',
];

/**
 * Sistema de cache de Model Views
 */
const CACHE_MV_NOMBRE = 'cache-mv-v1';

const CACHE_MV_FICHEROS = [
    '/',
    '/404',
    '/offline',
];

/**
 * Sistema de cache de recursos PWA
 */
const CACHE_RECURSOS_NOMBRE = 'cache-recursos-v1';

const CACHE_RECURSOS_FICHEROS = [
    '/manifest.json',
    '/public-assets/app',
    '/public-assets/utils'  
];

/**
 * Sistema de cache documentos externos
 */
const CACHE_EXTERNOS_NOMBRE = 'cache-externos-v1'

const CACHE_EXTERNOS_FICHEROS = [
    'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css',
    'https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@100&display=swap',
    'https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@100&display=swap'
];

/**
 * Instalacion de la aplicacion en el navegador
 */
self.addEventListener('install', event => {
    /*
    const cacheJs = caches.open(CACHE_JS_NOMBRE)
        .then(cache => {
            cache.addAll(CACHE_JS_FICHEROS)
        });

    const cacheCss = caches.open(CACHE_CSS_NOMBRE)
        .then(cache => {
            cache.addAll(CACHE_CSS_FICHEROS)
        });

    const cacheImgEstaticas = caches.open(CACHE_IMG_ESTATICAS_NOMBRE)
        .then(cache => {
            cache.addAll(CACHE_IMG_ESTATICAS_FICHEROS)
        });
    
    const cacheMv = caches.open(CACHE_MV_NOMBRE)
        .then(cache => {
            cache.addAll(CACHE_MV_FICHEROS)
        });

    const cacheRecursos = caches.open(CACHE_RECURSOS_NOMBRE)
        .then(cache => {
            cache.addAll(CACHE_RECURSOS_FICHEROS)
        });

    const cacheExternos = caches.open(CACHE_EXTERNOS_NOMBRE)
        .then(cache => {
            cache.addAll(CACHE_EXTERNOS_FICHEROS)
        });

    event.waitUntil(Promise.all([cacheJs, cacheCss, cacheImgEstaticas, cacheMv, cacheRecursos, cacheExternos]))
    */
});

/**
 * Se ejecuta cuando se activa el sw
 */
self.addEventListener('activate', event => {
    /*
    const limpiar = caches.keys().then(keys => {
        keys.forEach(key => {
            if(key !== CACHE_CSS_NOMBRE && key.includes('css'))
                return caches.delete(key)
            if(key !== CACHE_JS_NOMBRE && key.includes('js'))
                return caches.delete(key)
            if(key !== CACHE_IMG_ESTATICAS_NOMBRE && key.includes('img'))
                return caches.delete(key)
            if(key !== CACHE_MV_NOMBRE && key.includes('mv'))
                return caches.delete(key)
            if(key !== CACHE_RECURSOS_NOMBRE && key.includes('recursos'))
                return caches.delete(key)
            if(key !== CACHE_EXTERNOS_NOMBRE && key.includes('externos'))
                return caches.delete(key)
        })
    });
    event.waitUntil(limpiar);
    */
});

/**
 * Se ejecuta cuando se realiza una peticion http
 */
self.addEventListener('fetch', event => {
    /*
    const respuesta = caches.match(event.request)
        .then( resp => {
            
            if(resp) return resp;

            console.log(event.request)

            return fetch(event.request).then(newResponse => {
                
                return newResponse;
            })
        })
    event.respondWith(respuesta)
    */
})

/**
 * Se ejecuta cuando se recupera la conexion
 */
self.addEventListener('sync', event => {
    //...
})

/**
 * Se ejecuta cuando existe una notificacion push
 */
self.addEventListener('push', event => {
    //...
})