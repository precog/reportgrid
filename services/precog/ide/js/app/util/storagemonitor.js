define([
      "util/traverse"
    , "util/storage"
],

function(traverse, buildStorage) {
    return function(key, defaults) {
        var storage = buildStorage(key, defaults),
            monitor;

        function equals(a, b) {
            if(typeof a !== typeof b)
                return false;
            else if(a instanceof Array) {
                if(a.length != b.length)
                    return false;
                for(var i = 0; i < a.length; i++) {
                    if(!equals(a[i], b[i]))
                        return false;
                }
                return true;
            } else if(a instanceof Object) {
                var akeys = $.map(a, function(value, key) { return key }),
                    bkeys = $.map(b, function(value, key) { return key });
                if(!equals(akeys, bkeys))
                    return false;
                for(var i = 0; i < akeys.length; i++) {
                    if(!equals(a[akeys[i]], b[akeys[i]]))
                        return false;
                }
                return true;
            } else {
                return a === b;
            }
        }

        storage.monitor = monitor = (function() {
            var killMonitor = null,
                last = {},
                paths = [],
                pathsCounter = {};

            function loop() {
                if(paths.length == 0 || storage.dirty()) return;
                $.jStorage.reInit();
                var params = storage.all(),
                    len = paths.length,
                    cached = $.jStorage.get(key, {}),
                    path,
                    cvalue;
                for(var i = 0; i < len; i++) {
                    path = paths[i];
                    cvalue = traverse.get(cached, path);
                    if("undefined" === typeof last[path]) {
                        last[path] = cvalue;
                        continue;
                    }

                    if(equals(last[path], cvalue)) continue;
                    if(equals(cvalue, traverse.get(params, path))) continue; // value has not changed
                    last[path] = cvalue;
                    traverse.set(params, path, cvalue);
                    $(storage).trigger(path, [cvalue]);
                }
            }

            loop();

            return {
                start : function(delay) {
                    delay = delay || 2500;
                    if(this.monitoring()) {
                        this.end();
                        this.start(delay);
                    } else {
                        killMonitor = setInterval(loop, delay);
                    }
                },
                end : function() {
                    clearInterval(killMonitor);
                    killMonitor = null;
                },
                monitoring : function() {
                    return null !== killMonitor;
                },
                bind : function(path, handler) {
                    pathsCounter[path] = (pathsCounter[path] && (++pathsCounter[path])) || 1;
                    if(pathsCounter[path] === 1) paths.push(path);
                    $(storage).on(path, handler);
                },
                unbind : function(path, handler) {
                    if(!pathsCounter[path]) return;
                    pathsCounter[path]--;
                    if(pathsCounter[path] === 0) paths.splice(paths.indexOf(path), 1);
                    $(storage).off(path, handler);
                }
            }
        }());

        monitor.start();

        return storage;
    };
});