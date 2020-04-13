var Cookie = function () {

	var cookie_domain = null;

	var setDomain = (domain) => {
		cookie_domain = domain
	};

	var set = (name, value, expire) => {
		var d = new Date();
        d.setTime(d.getTime() + expire);
        var expires = "expires=" + d.toUTCString();
        var domain = "";
        if (cookie_domain != null) {
            domain = ";domain=" + cookie_domain;
        }
        document.cookie = name + "=" + value + "; " + expires + ";path=/" + domain + ";SameSite=Strict";
	};

	var get = (name) => {
		if (document.cookie.length > 0) {
            var c_start = document.cookie.indexOf(name + "=");
            if (c_start !== -1) {
                c_start = c_start + name.length + 1;
                var c_end= document.cookie.indexOf(";", c_start);
                if (c_end === -1) {
                    c_end = document.cookie.length;
                }
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
	}

	return {
		setDomain: setDomain,
		set: set,
		get: get
	}
}();

export default Cookie;