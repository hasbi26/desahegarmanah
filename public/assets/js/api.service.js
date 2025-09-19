// Small API service using jQuery.ajax and returning Promises
// Usage: ApiService.get('/api/enumerator', {page:1}).then(res => ...)
var ApiService = (function () {
    // Use relative paths by default so service works under virtual hosts and proxied setups
    var base = '';

    function getCsrfToken() {
        try {
            var meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : null;
        } catch (e) {
            return null;
        }
    }

    function request(method, path, data, options) {
        options = options || {};
        if (typeof $ === 'undefined') {
            return Promise.reject(new Error('jQuery is required by ApiService'));
        }

        var ajaxOptions = {
            url: (path.indexOf('http') === 0) ? path : (base + path),
            method: method,
            dataType: options.dataType || 'json',
            headers: $.extend({}, options.headers || {}, { 'X-Requested-With': 'XMLHttpRequest' })
        };

        var csrf = getCsrfToken();
        if (csrf) ajaxOptions.headers['X-CSRF-TOKEN'] = csrf;

        if (method === 'GET' || method === 'DELETE') {
            ajaxOptions.data = data || {};
        } else {
            // default: send as form data; allow callers to override to JSON
            if (options.json) {
                ajaxOptions.contentType = 'application/json; charset=utf-8';
                ajaxOptions.data = JSON.stringify(data || {});
                ajaxOptions.processData = false;
            } else {
                ajaxOptions.data = data || {};
            }
        }

        return new Promise(function (resolve, reject) {
            $.ajax(ajaxOptions).done(function (res) { resolve(res); }).fail(function (jqXHR, textStatus, errorThrown) {
                var err = jqXHR && jqXHR.responseJSON ? jqXHR.responseJSON : { status: 'error', message: jqXHR.responseText || errorThrown || textStatus };
                reject(err);
            });
        });
    }

    return {
        get: function (path, params, options) { return request('GET', path, params, options); },
        post: function (path, payload, options) { return request('POST', path, payload, options); },
        put: function (path, payload, options) { return request('PUT', path, payload, options); },
        delete: function (path, params, options) { return request('DELETE', path, params, options); }
    };
})();
