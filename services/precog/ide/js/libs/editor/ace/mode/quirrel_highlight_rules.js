define(
function(require, exports, module) {
    "use strict";

    var oop = require("../lib/oop");
    var lang = require("../lib/lang");
    var TextHighlightRules = require("./text_highlight_rules").TextHighlightRules;

    var QuirrelHighlightRules = function() {

        var keywords = lang.arrayToMap(
            ("new|where").split("|")
        );

        var builtinConstants = lang.arrayToMap(
            ("true|false").split("|")
        );

        var builtinFunctions = lang.arrayToMap(
            ("with|count|dataset|load|max|mean|median|min|mode|stdDev|sum").split("|")
        );

        this.$rules = {
            "start" : [ {
                token : "comment",
                regex : "--.*$"
            }, {
                token : "comment",
                regex : "\\(-.*?-\\)"
            }, {
                token : "string",           // " string
                regex : '".*?"'
            }, {
                token : "constant.numeric", // float
                regex : "[+-]?\\d+(?:(?:\\.\\d*)?(?:[eE][+-]?\\d+)?)?\\b"
            }, {
                token : "variable",
                regex : "'[a-zA-Z_][a-zA-Z0-9_]*\\b"
            }, {
                token : function(value) {
                    if (keywords.hasOwnProperty(value))
                        return "keyword";
                    else if (builtinConstants.hasOwnProperty(value))
                        return "constant.language";
                    else if (builtinFunctions.hasOwnProperty(value))
                        return "support.function";
                    else
                        return "identifier";
                },
                regex : "[a-zA-Z_][a-zA-Z0-9_]*\\b"
            }, {
                token : "constant",
                regex : "\\/(?:\\/[a-zA-Z0-9-]+)+"
            }, {
                token : "invalid",
                regex : "//"
            }, {
                token : "keyword.operator",
                regex : "::|:=|\\+|\\/|\\-|\\*|%|<|>|<=|=>|!=|<>|="
            }
            ]
        };
    };

    oop.inherits(QuirrelHighlightRules, TextHighlightRules);

    exports.QuirrelHighlightRules = QuirrelHighlightRules;
});
