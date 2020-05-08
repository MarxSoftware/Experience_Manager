if (typeof _exm !== 'object') {
    _exm = [];
}
(function () {

    function apply(functionObj) {
        if ('undefined' === typeof functionObj) {
            return
        }
        let function_name = functionObj.shift();
        if ('function' === typeof EXM.Tracking[function_name]) {
            EXM.Tracking[function_name].apply(EXM.Tracking, functionObj)
        }
    }

    for (let i = 0; i < _exm.length; i++) {
        apply(_exm[i])
    }

    EXM.Tracking.register()


})();