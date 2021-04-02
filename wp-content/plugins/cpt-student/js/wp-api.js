options.beforeSend = function(xhr) {
    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
 
    if (beforeSend) {
        return beforeSend.apply(this, arguments);
    }
};