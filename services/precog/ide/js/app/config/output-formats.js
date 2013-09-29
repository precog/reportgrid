define([
    "util/converters"
],

function(convert) {
    return [{
        token: "json",
        name : "Json",
        handler : function(json) {
            return JSON.stringify(json);
        }
    }, {
        token: "jsonf",
        name : "Formatted Json",
        handler : function(json) {
            return JSON.stringify(json, null, 2);
        }
    }, {
        token: "csv",
        name : "CSV",
        handler : function(json) {
            return convert.jsonToCsv(json);
        }
    }];
});