if (typeof _exm !== 'object') {
    _exm = [];
}
console.log(_exm);
(function () {

    function apply(functionObj) {
        if ('undefined' === typeof functionObj) {
            return
        }
        let function_name = functionObj.shift();
        console.log(function_name, typeof EXM.Tracking[function_name], functionObj)
        if ('function' === typeof EXM.Tracking[function_name]) {
            EXM.Tracking[function_name].apply(EXM.Tracking, functionObj)
        }
    }

    var applyFirst = ['init', 'setTrackerUrl', 'setCookieDomain', 'setSite', 'setPage', 'setType', 'setCustomParameters'];
    console.log(_exm);

    for (let i = 0; i < _exm.length; i++) {
        apply(_exm[i])
    }

    EXM.Tracking.register()


})();