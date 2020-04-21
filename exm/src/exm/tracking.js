import Cookie from './cookie'

var Tracking = function () {

    var isDNT = navigator.doNotTrack == "yes" || navigator.doNotTrack == "1"
        || navigator.msDoNotTrack == "1" || window.doNotTrack == "1";
    var DAY = 24 * 60 * 60 * 1000;
    var HOUR = 60 * 60 * 1000;
    var MINUTE = 60 * 1000;

    var Context = {
        site: "",
        page: "",
        host: "",
        type: "",
        uid: "",
        rid: "",
        vid: "",
        pixelImage: null,
        custom_parameter : null
    }
   

    var init = function () {
        Context.uid = "";			// the userid
        Context.rid = _uuid();			// the requestid
        Context.vid = "";			// the visitid
        Context.pixelImage = new Image();
    };
    var setPage = function (page) {
        Context.page = page;
    };
    var setSite = function (page) {
        Context.page = page;
    };
    var setType = function (type) {
        Context.type = type
    };
    var setTrackerUrl = function (host) {
        console.log("set host: ", host)
        Context.host = host;
    };
    var setCustomParameters = function (customParameters) {
        Context.custom_parameter = customParameters;
    };
    var setCookieDomain = function (domain) {
        Cookie.setDomain(domain);
    };
    var optOut = function () {
        Cookie.set('_tma_trackingcookie', "opt-out", 365 * Context.DAY);
    };
    var dnt = function () {
        return Context.isDNT || document.cookie.indexOf("_tma_trackingcookie=opt-out") !== -1;
    }
    var register = function () {
        if (!dnt()) {
            track("pageview");
        }
    };
    var track = function (event) {
        if (!dnt()) {
            // opt-out cookie is not set
            var data = "event=" + event + _createDefaultParameters() + _createCustomParameters();
            _send(Context.host + "/tracking/pixel", data);
        }
    };

    var score = function (scores) {
        if (!dnt()) {
            var scoreParameters = "";
            for (var key in scores) {
                scoreParameters += "&score_" + key + "=" + scores[key];
            }
            var data = "event=score" + scoreParameters + _createDefaultParameters() + _createCustomParameters();
            _send(Context.host + "/tracking/pixel", data);
        }
    };

    let _createDefaultParameters = function () {
        Context.vid = _getUniqueID("_tma_vid", 1 * HOUR);
        Context.uid = _getUniqueID("_tma_uid", 365 * DAY);
        var currentDate = new Date();
        return "&site=" + Context.site
            + "&page=" + Context.page
            + "&type=" + Context.type
            + "&uid=" + Context.uid
            + "&reqid=" + Context.rid
            + "&vid=" + Context.vid
            + "&referrer=" + escape(document.referrer)
            + "&offset=" + currentDate.getTimezoneOffset()
            + "&_t=" + currentDate.getTime();
    };

    let _createCustomParameters = function () {
        var customParameterString = "";
        //var name = arguments.length === 1 ? arguments[0] + "_" : "";

        if (Context.custom_parameter != null) {
            var customParameters = Context.custom_parameter;
            if (customParameters !== null && typeof customParameters === 'object') {
                for (var p in customParameters) {
                    if (customParameters.hasOwnProperty(p)) {
                        var value = customParameters[p]
                        if (Array.isArray(value)) {
                            for (var item in value) {
                                customParameterString += "&c_" + p + '=' + value[item];
                            }
                        } else {
                            customParameterString += "&c_" + p + '=' + customParameters[p];
                        }
                    }
                }
            }
        }
        return customParameterString;
    };

    let _uuid = function () {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };
    let _getUniqueID = function (cookiename, expire) {
        var aid = Cookie.get(cookiename);
        if (aid === null || aid === "") {  
            aid = _uuid();
        }
        
        // update cookie on every request
        Cookie.set(cookiename, aid, expire);
        return aid;
    };
    let _send = function (url, data) {
        if (navigator.sendBeacon) {
            navigator.sendBeacon(url, data);
        } else if (XMLHttpRequest) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", url, true);
            xhr.send(data);
        } else {
            Context.pixelImage.src = url + "?" + data;
        }
    }

    return {
        init: init
        , setPage: setPage
        , setSite: setSite
        , setType: setType
        , setTrackerUrl: setTrackerUrl
        , setCustomParameters: setCustomParameters
        , setCookieDomain: setCookieDomain
        , optOut: optOut
        , dnt: dnt
        , register: register
        , track: track
        , score: score
    }
}();

export default Tracking;