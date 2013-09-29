define([
      "text!templates/layout.full.html"
    , "order!util/ui"
    , "order!ui/jquery.ui.core"
    , "order!ui/jquery.ui.widget"
    , "order!ui/jquery.ui.mouse"
    , "order!ui/jquery.ui.draggable"
    , "order!jlib/layout/jquery.layout"
    , "domReady!"
],

 function(template, ui) {
    var toolbarMainHeight = 38,
        toolbarHeight = 36,
        statusbarHeight = 24;
    return function(container, isvertical) {
        var layout, layouts = [];

        if((container === true || container === false) && "undefined" === typeof isvertical)
        {
            isvertical = container;
            container = $('body');
        } else {
            container = (container && $(container)) || $('body');
        }

        container.append(template);
        layouts.push(container.layout());

        var defaults = {
                  initClosed : false
                , resizable : true
                , slidable : true
            },
            toolbar = {
                  resizable : false
                , closable : false
                , slidable : false
                , size: toolbarHeight
                , spacing_open: 0
                , spacing_closed: 0
            },
            statusbar = $.extend({}, toolbar, { size : statusbarHeight });

        function refreshLayouts() {
            for(var i = 0; i < layouts.length; i++) {
                layouts[i].resizeAll();
            }
        }

        // main seperation
        layouts.push(container.find('.pg-ide').layout({
            defaults : defaults,
            north : $.extend({}, toolbar, { size : toolbarMainHeight }),
            west : {
                  size : 200
                , initClosed : false
            }
        }));


        // system separation
        layouts.push(container.find('.pg-system').layout({
            defaults : defaults,
            south : {
                  size : "50%"
                , initClosed : true
            }
        }));

        // folder-system separation
        layouts.push(container.find('.pg-folders').layout({
            defaults : defaults,
            north : toolbar
        }));

        // folder-system separation
        layouts.push(container.find('.pg-queries').layout({
            defaults : defaults,
            north : toolbar
        }));

        // console separation
        layouts.push(container.find('.pg-main').layout({
            defaults : defaults,
            south : {
                  size : "15%"
                , initClosed : true
            }
        }));

        // editor-support separation
        layouts.push(container.find('.pg-editor-support').layout({
            defaults : defaults,
            east : {
                  size : "30%"
                , initClosed : true
            }
        }));

        // editor separation
        layouts.push(container.find('.pg-editor').layout({
            defaults : defaults,
            south : statusbar
        }));

        // io separation
        var lio, linput, loutput;

        function buildIO(vertical) {
            var panels;
            if(lio) {
                layouts.splice(layouts.indexOf(lio), 1);
                layouts.splice(layouts.indexOf(linput), 1);
                layouts.splice(layouts.indexOf(loutput), 1);
                lio.destroy();
            }
            if(vertical) {
                container.find('.pg-output').removeClass('ui-layout-east').addClass('ui-layout-south');
                panels = {
                    defaults : defaults,
                    south : {
                          size : "50%"
                        , closable : false
                    }
                };
            } else {
                container.find('.pg-output').removeClass('ui-layout-south').addClass('ui-layout-east');
                panels = {
                    defaults : defaults,
                    east : {
                          size : "50%"
                        , closable : false
                    }
                };
            }

            layouts.push(lio = container.find('.pg-io').layout(panels));

            // output separation
            layouts.push(loutput = container.find('.pg-output').layout({
                defaults : defaults,
                north : toolbar
            }));

            // input separation
            layouts.push(linput = container.find('.pg-input').layout({
                defaults : defaults,
                north : toolbar,
                onresize : function() {
                    $(layout).trigger("resizeCodeEditor");
                }
            }));
//            container.find(".pg-pane").addClass("ui-widget-content");
            container.find(".ui-layout-resizer")
                .addClass("ui-widget-shadow")
            ;

            isvertical = vertical;
            $(layout).trigger("resizeCodeEditor");
            $(layout).trigger("ioOrientationChanged", isvertical);
        }

        buildIO(isvertical);

        // wire styling to JQuery UI
        container.addClass("ui-widget-content");
        container.find(".pg-pane").addClass("ui-widget-content");
        container.find(".ui-layout-toggler")
            .mouseenter(function() { $(this).addClass("ui-state-hover"); })
            .mouseleave(function() { $(this).removeClass("ui-state-hover"); })
            .addClass("ui-widget-header")
        ;
//        container.find(".ui-layout-resizer")
//            .addClass("ui-widget-shadow")
//        ;

        container.find(".ui-layout-resizer-dragging")
            .addClass("ui-state-hover")
        ;

        return layout = {
            container : container,
            refresh : refreshLayouts,
            getBarEditor  : function() { return container.find('.pg-input .pg-toolbar'); },
            getBarMain    : function() { return container.find('.pg-mainbar'); },
            getCodeEditor : function() { return container.find('.pg-input .pg-code-editor'); },
            getOutput     : function() { return container.find('.pg-output'); },
            getStatusBar  : function() { return container.find('.pg-statusbar'); },
            getSystem     : function() { return container.find('.pg-folders'); },
            setIoVertical : buildIO,
            isIoVertical  : function() { return isvertical; }
        };
    };
});