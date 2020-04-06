var Popup = function() {

    // This is private because it is not being return
    var _privateFunction = function(param1, param2) {
        return;
    }

    var function1 = function(param1, callback) {
        callback(err, results);    
    }

    var function2 = function(param1, param2, callback) {
        callback(err, results);    
    }

    return {
        function1: function1
       ,function2: function2
    }
}();

export default Popup;