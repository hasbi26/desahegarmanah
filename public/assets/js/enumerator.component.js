// Tiny enumerator UI component: renders list into a container and exposes simple methods
// Requires jQuery and ApiService

var EnumeratorComponent = (function () {
    function renderList(containerSelector, params) {
        params = params || {};
        if (typeof $ === 'undefined') return console.error('jQuery is required for EnumeratorComponent');
        var $c = $(containerSelector);
        if (!$c.length) return;
        $c.html('<div>Loading...</div>');
        ApiService.get('/api/enumerator', params).then(function (res) {
            var rows = res.data || [];
            if (!rows.length) {
                $c.html('<div>No data</div>');
                return;
            }
            var html = '<ul class="enumerator-list">';
            rows.forEach(function (r) {
                html += '<li data-id="' + r.id + '">' + (r.nama || '(no name)') + ' <small>' + (r.hp_telepon || '') + '</small></li>';
            });
            html += '</ul>';
            $c.html(html);
        }).catch(function (err) {
            var msg = (err && err.message) ? err.message : (err && err.status) ? JSON.stringify(err) : 'Request failed';
            $c.html('<div class="error">Error: ' + msg + '</div>');
        });
    }

    function init(containerSelector) {
        if (typeof $ === 'undefined') return console.error('jQuery is required for EnumeratorComponent');
        var $c = $(containerSelector);
        if (!$c.length) return;
        renderList(containerSelector);
        // simple click handler
        $c.off('click', '.enumerator-list li');
        $c.on('click', '.enumerator-list li', function () {
            var id = $(this).data('id');
            ApiService.get('/api/enumerator/' + id).then(function (res) {
                alert('Detail: ' + JSON.stringify(res.data || res));
            }).catch(function (err) {
                alert('Error: ' + (err && err.message ? err.message : JSON.stringify(err)));
            });
        });
    }

    return { renderList: renderList, init: init };
})();
