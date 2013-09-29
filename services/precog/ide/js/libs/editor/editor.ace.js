define([
      "require"
    , "ace/ace"
    , "util/ui"
    , "ace/mode/quirrel"
],

function(require, ace, ui) {
    return function(el, vertical) {
        var wrapper,
            editor = ace.edit($(el).get(0));

        function execute() {
            $(wrapper).trigger('execute', wrapper.get());
        }

        editor.commands.addCommand({
            bindKey: {
                win: 'Shift-Return',
                mac: 'Shift-Return|Command-Return',
                sender: 'editor|cli'
            },
            exec: execute
        });
        editor.setShowPrintMargin(false);
        var sess = editor.getSession();
        sess.setMode(new (require("ace/mode/quirrel").Mode)());
        sess.getSelection().on("changeCursor", function() {
            $(wrapper).trigger("changeCursor", editor.getCursorPosition());
        });
        sess.getSelection().on("changeSelection", function() {
            $(wrapper).trigger("changeSelection", editor.getSelection());
        });
        sess.on("change", (function() {
            var killChange;

            function trigger() {
                $(wrapper).trigger("change", wrapper.get());
            };

            return function() {
                clearInterval(killChange);
                killChange = setTimeout(trigger, 250);
            };
        })());

        var run = ui.button(el, {
            label : "run",
            text : true,
            icons : { primary : "ui-icon-circle-triangle-s" },
            handler : execute
        });

        function orientButton(vertical) {
            run.css({
                display: "block",
                position: "absolute",
                right: "25px",
                bottom: vertical ? "10px" : "25px",
                zIndex: 100
            });
            if(vertical)
                run.find(".ui-icon-circle-triangle-e").removeClass("ui-icon-circle-triangle-e").addClass("ui-icon-circle-triangle-s");
            else
                run.find(".ui-icon-circle-triangle-s").removeClass("ui-icon-circle-triangle-s").addClass("ui-icon-circle-triangle-e");
        }

        orientButton(vertical);

        wrapper = {
            get : function() {
                return sess.getValue(); //editor.getSession()
            },
            set : function(code) {
                sess.setValue(code);
            },
            setTabSize : function(size) {
                if(size === sess.getTabSize()) return;
                sess.setTabSize(size);
                $(wrapper).trigger("tabSizeChanged", size);
            },
            setUseSoftTabs : function(toogle) {
                if(toogle === sess.getUseSoftTabs()) return;
                sess.setUseSoftTabs(toogle);
                $(wrapper).trigger("useSoftTabsChanged", toogle);
            },
            getTabSize : function() {
                return sess.getTabSize();
            },
            getUseSoftTabs : function(toogle) {
                return sess.getUseSoftTabs();
            },
            setTheme : function(theme) {
                var path = "ace/theme/" + theme;
                require([path], function() {
                    editor.setTheme(path);
                });
            },
            resize : function() {
                editor.resize();
            },
            engine : function() {
                return "ace";
            },
            focus : function() {
                editor.focus();
            },
            triggerExecute : execute,
            orientButton : orientButton
        };

        return wrapper;
    }
});