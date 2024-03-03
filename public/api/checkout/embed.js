(function () {
    function framer(i, q, u, m, a, t) {
        this._i = i; //Id
        this._q = q; //queryString
        this._u = u || null; //baseUrl
        this._mW = m || null; //maxWidth
        this._a = a || null; //append to
        this._t = t || null; //title
        this._init = function () {
            this._cf();
        }
        this._cf = function () {
            this._i = document.getElementById(this._i) ? this._i + '_' + new Date().getTime() : this._i;
            var _c = '<ifr' + 'ame id="' + this._i + '" name="' + this._i + '" sandbox="allow-forms allow-modals allow-popups allow-same-origin allow-scripts allow-top-navigation allow-top-navigation-by-user-activation" title="' + this._t + '" allowTransparency="true" frameborder="0" scrolling="no" height="1700px" allow="geolocation; microphone; camera" allowfullscreen="true" style="max-width:' + this._mW + 'px !important;width:100%;border:none" src="' + this._u + '/?' + this._q + '&embed=' + encodeURIComponent(window.location.href) + '">' + this._t + '</ifr' + 'ame>';
            if (!this._a) {
                document.write(_c);
            } else {
                var tmp = document.createElement('div');
                tmp.innerHTML = _c;
                document.getElementById(this._a).appendChild(tmp.firstChild);
            }
            this.frame = document.getElementById(this._i);
        }
    }
    const urlSearchParams = new URLSearchParams(window.location.search);
    const params = Object.fromEntries(urlSearchParams.entries());
    serialize = function(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }
    var maxW = null;
    var queryString = '';
    var querystring = document.currentScript.src.substring( document.currentScript.src.indexOf("?") );
    var urlParams = new URLSearchParams( querystring );
    const result = splitStringByStartEnd(document.currentScript.src, '//', '/api');
    var key = urlParams.get('embed_code');
    var frameId = `checkout/${key}`;
    var base_url = `${result[0]+'//'+result[1]}/checkout/${key}`;
    var iframe = new framer(frameId, queryString, base_url, maxW, false, false);
    iframe._init();
    window.addEventListener("message", function (e) {
        if (!['dynamicHeight', 'redirectUrl'].includes(e.data.type)) return;
        if(e.data.type == 'redirectUrl') {
            window.open(e.data.url, '_parent');
        }else if(e.data.type == 'dynamicHeight') {
            var this_frame = document.getElementById(e.data.name);
            if (this_frame && this_frame.contentWindow === e.source) {
                this_frame.height = e.data.height + "px";
                this_frame.style.height = e.data.height + "px";
            }
        }
    })
    function splitStringByStartEnd(inputString, startString, endString) {
        const startIndex = inputString.indexOf(startString);
        const endIndex = inputString.indexOf(endString, startIndex + startString.length);
        if (startIndex === -1 || endIndex === -1) {
            return [];
        }
        return [
            inputString.slice(0, startIndex),
            inputString.slice(startIndex + startString.length, endIndex),
            inputString.slice(endIndex + endString.length)
        ];
    }
})();
