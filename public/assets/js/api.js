// Simple AJAX helpers for CodeIgniter API endpoints
// Requires jQuery to be loaded on the page.

var API = (function () {
    var base = window.location.origin; // e.g. http://localhost

    function getEnumerators(success, error) {
        $.ajax({
            url: base + '/api/enumerators',
            method: 'GET',
            dataType: 'json'
        }).done(success).fail(function (jqXHR) {
            if (error) error(jqXHR);
        });
    }

    // Resource-style Enumerator endpoints (new)
    function enumeratorList(params, success, error) {
        params = params || {};
        $.ajax({
            url: base + '/api/enumerator',
            method: 'GET',
            data: params,
            dataType: 'json'
        }).done(success).fail(function (jqXHR) { if (error) error(jqXHR); });
    }

    function enumeratorGet(id, success, error) {
        $.ajax({
            url: base + '/api/enumerator/' + encodeURIComponent(id),
            method: 'GET',
            dataType: 'json'
        }).done(success).fail(function (jqXHR) { if (error) error(jqXHR); });
    }

    function enumeratorCreate(payload, success, error) {
        $.ajax({
            url: base + '/api/enumerator',
            method: 'POST',
            data: payload,
            dataType: 'json'
        }).done(success).fail(function (jqXHR) { if (error) error(jqXHR); });
    }

    function enumeratorUpdate(id, payload, success, error) {
        // use POST update endpoint (routes map update to POST for enumerator)
        $.ajax({
            url: base + '/api/enumerator/' + encodeURIComponent(id) + '/update',
            method: 'POST',
            data: payload,
            dataType: 'json'
        }).done(success).fail(function (jqXHR) { if (error) error(jqXHR); });
    }

    function enumeratorDelete(id, success, error) {
        $.ajax({
            url: base + '/api/enumerator/' + encodeURIComponent(id),
            method: 'DELETE',
            dataType: 'json'
        }).done(success).fail(function (jqXHR) { if (error) error(jqXHR); });
    }

    function getPenduduk(id, success, error) {
        $.ajax({
            url: base + '/api/penduduk/' + encodeURIComponent(id),
            method: 'GET',
            dataType: 'json'
        }).done(success).fail(function (jqXHR) {
            if (error) error(jqXHR);
        });
    }

    function postEcho(payload, success, error) {
        $.ajax({
            url: base + '/api/echo',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload),
            dataType: 'json'
        }).done(success).fail(function (jqXHR) {
            if (error) error(jqXHR);
        });
    }

    return {
        getEnumerators: getEnumerators,
        getPenduduk: getPenduduk,
        postEcho: postEcho
        ,enumeratorList: enumeratorList
        ,enumeratorGet: enumeratorGet
        ,enumeratorCreate: enumeratorCreate
        ,enumeratorUpdate: enumeratorUpdate
        ,enumeratorDelete: enumeratorDelete
    };
})();
