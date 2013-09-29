define([],

function() {
    return {
        jsonToCsv : function(json) {
            if(!json) return "";
            var rows = [],
                o = json[0],
                values, key, keys = [],
                requote = /[",\n\r]/g,
                ren = /\n/g,
                rer = /\r/g,
                req = /"/g,
                i;

            function escape(s) {
                return s
                    .replace(ren, "\\n")
                    .replace(rer, "\\r")
                    .replace(req, '""')
                    ;
            }

            function value(v) {
                if("string" == typeof v) {
                    if(v.match(requote)) {
                        return '"' + escape(v) + '"';
                    } else {
                        return v;
                    }
                } else if(v instanceof Array || v instanceof Object) {
                    return value(JSON.stringify(v));
                } else {
                    return "" + v;
                }
            }

            values = [];
            if(o instanceof Object) {
                for(key in o) {
                    if(o.hasOwnProperty(key)) {
                        keys.push(key);
                        values.push(value(key));
                    }
                }
                rows.push(values.join(","));
                for(i = 0; i<json.length; i++) {
                    values = [];
                    o = json[i];
                    for(var j = 0; j < keys.length; j++) {
                        values.push(value(o[keys[j]]));
                    }
                    rows.push(values.join(","));
                }
            } else {
                rows.push(value("value"));
                for(i = 0; i<json.length; i++) {
                    rows.push(value(json[i]));
                }
            }

            return rows.join("\n");
        },

        quirrelToOneLine : function(code) {
            return code
                .replace(/--(.*)$/mg, '(- $1 -)')
                .replace(/(\s+)/mg, ' ')
                .replace(/"/g, '\\"')
                .trim()
                ;
        }
    }
});