define([
    'config/themes'
],

function(themes) {
    var UI_BASE_THEME_URL = "css/jquery/ui/",
        map = {},
        groups = {};

    $.each(themes, function() {
        map[this.token] = this;
        groups[this.group] = groups[this.group] || {};
        groups[this.group][this.token] = this;
    });

    function themeUrl(name) {
        return UI_BASE_THEME_URL + name + "/jquery-ui.css";
    }

    function pollCSS(url, callback) {
        function poll() {
            try {
                var sheets = document.styleSheets;
                for(var j=0, k=sheets.length; j<k; j++) {
                    if(sheets[j].href == url) {
                        sheets[j].cssRules;
                    }
                }
                // If you made it here, success!
                setTimeout(callback, 0);
            } catch(e) {
                // Keep polling
                setTimeout(poll, 50);
            }
        };
        poll();
    }

    function setUITheme(name, callback) {
        var url = themeUrl(name),
            cssLink = $('<link href="'+url+'" type="text/css" rel="Stylesheet" class="ui-theme" />');
        if($.browser.safari) {
            // no onload event
            pollCSS(url, callback);
        } else {
            cssLink.on("load", callback);
        }
        $("head").append(cssLink);


        if( $("link.ui-theme").size() > 3){
            $("link.ui-theme:first").remove();
        }
    }
    var theme = {
        current : null,
        set : function(name) {
            if(this.current === name) return;
            this.current = name;
            $(theme).trigger('change', name);
            setUITheme(map[name].ui, function() {
                $(theme).trigger('changed', name);
            });
        },
        list : function() { return themes; },
        map : function() { return map; },
        groups : function() { return groups; },
        getEditorTheme : function(name, editor) {
            return map[name].editor[editor];
        }
    };

    return theme;
});