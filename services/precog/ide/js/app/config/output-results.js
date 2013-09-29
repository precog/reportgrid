define([
      "util/output-table"
    , "util/output-json"
    , "util/output-error"
    , "util/output-message"
],

function() {
    var formats = arguments,
        empties = [{
            name : "update",
            f : function() {
                return function(_) {  };
            }
        }, {
            name : "panel",
            f : function() {
                return function() { return $("<div></div>"); };
            }
        }, {
            name : "toolbar",
            f : function() {
                return function() { return $("<div></div>"); };
            }
        }, {
            name : "activate",
            f : function() { return function() {}; }
        }, {
            name : "deactivate",
            f : function() { return function() {}; }
        }, {
            name : "display",
            f : function() { return true; }
        }, {
            name : "resize",
            f : function() {
                return function() {  };
            }
        }];

    $.each(formats, function(_, format) {
        $.each(empties, function(_, empty) {
            if("undefined" === typeof format[empty.name])
            {
//                console.log("assigning " + empty.name + " to " + format.name);
                format[empty.name] = empty.f();
            }
        });
    });

    return formats;
});