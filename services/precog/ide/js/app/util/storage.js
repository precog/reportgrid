define([
      "order!util/traverse"
    , "order!jlib/jstorage/jstorage"
],

function(traverse) {
    return function(key, defaults) {
        var dirty  = false,
            params = $.extend({}, defaults);
        function save() {
            $.jStorage.set(key, params)
            dirty = false;
        }

        function load() {
            if(enableDebug)
                console.log("Load Storage Data");
            $.jStorage.reInit();
            var value = $.jStorage.get(key);
            $.extend(params, value);
        }

        var delayedSave = function() {
            dirty = true;
            clearInterval(this.killDelayedSave);
            this.killDelayedSave = setTimeout(save, 100);
        };

        load();

        var enableDebug = false;

        function debug(action, key, value) {
            if(!enableDebug) return;
            var s = ((("undefined" !== typeof value) && JSON.stringify(value)) || ""),
                len = 100,
                ellipsis = '...';
            if(s.length > len - ellipsis.length) {
                s = s.substr(0, len - ellipsis.length) + ellipsis;
            }
            console.log(((action && (action + " ")) || "") + key + ((s && ": " + s) || ""));
        }

        var storage = {
                get : function(key, alternative) {
                    var v = traverse.get(params, key);

                    debug("get", key, v);

                    if("undefined" === typeof v)
                        return alternative;
                    else
                        return v;
                },
                set : function(key, value) {
                    if(traverse.set(params, key, value))
                    {
                        delayedSave();
                        debug("set", key, value);
                    }
                },
                remove : function(key) {
                    debug("del", key);
                    traverse.remove(params, key);
                    delayedSave();
                },
                keys : function(key) {
                    var ref = traverse.get(params, key);
                    if(ref && "object" === typeof ref) {
                        var result = [];
                        for(var k in ref) {
                            if (ref.hasOwnProperty(k)) {
                                result.push(k);
                            }
                        }
                        return result;
                    } else {
                        return [];
                    }
                },
                save : function(instant) {
                    if(instant)
                        save();
                    else
                        delayedSave();
                },
                load : function() {
                    load();
                },
                clear : function() {
                    $.jStorage.flush();
                },
                toString : function() {
                    return JSON.stringify(params);
                },
                all : function() {
                    return params;
                },
                dirty : function() {
                    return dirty;
                }
            };

        return storage;
    };
});