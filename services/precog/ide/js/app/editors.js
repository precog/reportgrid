define([
      "util/precog"
    , "util/md5"
    , "util/storagemonitor"
    , "util/utils"
],

function(precog, md5, createStore, utils) {
    var STORE_KEY = "pg-quirrel-editors-"+md5(precog.config.tokenId),
        store = createStore(STORE_KEY, {
            list : [],
            editors : {}
        });

    store.monitor.start(500);

    function createId() {
        return md5(""+Math.random()).substr(0, 8);
    }

    var list = [];

    var last = (function() {
        var re = /query #(\d+)$/, m;
        function extractNumber(s) {
            if(m = re.exec(s)) {
                return parseInt(m[1]);
            } else {
                return 0;
            }
        }

        return function() {
            if(list.length == 0) return 0;
            var max = 0;
            $.each(list, function(_, id) {
                var name = store.get(editorKey(id)+".name");
                if(!name) return;
                var v = extractNumber(name);
                if(v > max)
                    max = v;
            });
            return max;
        };
    })();

    function anonymousName() {
        return "*query #" + (1 +last());
    }

    function createEditor(o) {
        o = $.extend({
            name : null
        }, o);
        if(!o.name) o.name = anonymousName();
        if(!o.id) o.id = createId();
        return o;
    }

    function editorKey(id) {
        return "editors."+id;
    }

    var currentIndex = null,
        editors = {
            add : function(options) {
                var editor = createEditor(options);
                store.set(editorKey(editor.id), editor);
                list.push(editor.id);
                store.set("list", list);
                $(editors).trigger("added", editor);
                return editor;
            },
            remove : function(index) {
                // can't remove the last available tab
                if(list.length == 1) return;
                if(index === currentIndex)
                {
                    this.activate(index === 0 ? index+1 : index-1);
                }
                var editor = list[index];
                if(editor)
                    store.remove(editorKey(editor.id));
                list.splice(index, 1);
                store.set("list", list);
                $(editors).trigger("removed", index);
                return editor;
            },
            list : function() {
                return list.copy();
            },
            count : function() {
                return list.length;
            },
            get : function(index) {
                return store.get(this.getKey(index));
            },
            getById : function(id) {
                return this.get(list.indexOf(id));
            },
            getKey : function(index) {
                if("undefined" === typeof index) index = this.current();
                return editorKey(list[index]);
            },
            load : function() {
                var cached = store.get("list"),
                    values = $.map(cached, function(v) { return store.get(editorKey(v)); });
                for(var i = 0; i < cached.length; i++) {
                    editors.add(values[i]);
                }
            },
            activate : function(index) {
                this.deactivate(currentIndex);
                currentIndex = index;
                $(editors).trigger("activated", index);

            },
            deactivate : function(index) {
                if(null === currentIndex) return;
                currentIndex = null;
                $(editors).trigger("deactivated", index);

            },
            current : function() {
                return currentIndex;
            },
            setField : function(field, value, index) {
                store.set(this.getKey(index) + "." + field, value);
            },
            getField : function(field, alt, index) {
                return store.get(this.getKey(index) + "." + field, alt);
            },
            getCode : function(index) {
                return this.getField("code", "", index);
            },
            setCode : function(code, index) {
                this.setField("code", code, index);
            },
            getOutputResult : function(index) {
//                console.log("GET DATA " + JSON.stringify(this.getField("output.result", null, index)));
                return this.getField("output.result", null, index);
            },
            setOutputResult : function(result, index) {
                this.setField("output.result", result, index);
            },
            getOutputType : function(index) {
                return this.getField("output.type", null, index);
            },
            setOutputType : function(type, index) {
                this.setField("output.type", type, index);
            },
            getOutputOptions : function(index) {
                return this.getField("output.options", null, index);
            },
            setOutputOptions : function(options, index) {
                this.setField("output.options", options, index);
            },
            monitor : store.monitor
        };

    store.monitor.bind("list", function(_, values) {
        var removed = utils.arrayDiff(list, values),
            added   = utils.arrayDiff(values, list);

        if(removed.length + added.length == 0) return;
        store.load();
        var removedIndexes = $.map(removed, function(v) { return list.indexOf(v); });
        for(var i = 0; i < removedIndexes.length; i++) {
            editors.remove(removedIndexes[i]);
        }
        for(var i = 0; i < added.length; i++) {
            editors.add(store.get(editorKey(added[i])));
        }
    });

    return editors;
});