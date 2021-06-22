/**
 * Archivo de utilidades para el Serviceworker
 */
function actualizarCahceDinamico(cacheNombre, req, res){
    if(res.ok){
        return caches.open(cacheNombre).then(cache => {
            cache.put(req, res.clone());

            return res.clone();
        })
    } else {
        return res;
    }
}