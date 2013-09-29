define([
      "text!templates/dialog.export.html"
    , "order!util/ui"
    , "util/dom"
    , "util/notification"
    , "order!ui/jquery.ui.draggable"
    , "order!ui/jquery.ui.position"
    , "order!ui/jquery.ui.resizable"
    , "order!ui/jquery.ui.dialog"
    , "jlib/zclip/jquery.zclip"
], function(tplDialog, ui, dom, notification) {
    var downloadQueryService = "http://api.reportgrid.com/services/viz/proxy/download-code.php",
        elDialog = $('body')
            .append(tplDialog)
            .find('.pg-dialog-export')
            .dialog({
                  modal : true
                , autoOpen : false
                , resizable : false
                , width : 820
                , height : 480
                , dialogClass : "pg-el"
                , closeOnEscape: true
                , buttons : [{
                    text : "Copy",
                    click : function() {
                        elDialog.dialog("close");
                        return true;
                    }
                }, {
                    text : "Download",
                    click : function() {
                        notification.quick("code downloaded");
                        elForm.submit();
                        elDialog.dialog("close");
                    }
                }]
            }),
        elActions = elDialog.find(".pg-actions"),
        elText = elDialog.find(".pg-export textarea"),
        elForm = elDialog.find("form");

    elForm.attr("action", downloadQueryService);

    var clip;

    function selectCode() {
        setTimeout(function() { dom.selectText(elText.get(0)); }, 100);
    }

    elText.click(function() {
        selectCode();
    });

    function reposition() {
        elDialog.dialog("option", "position", "center");
    }

    elDialog.bind("dialogopen", function() { $(window).on("resize", reposition); });
    elDialog.bind("dialogclose", function() { $(window).off("resize", reposition); });

    return function(title, actions, code) {
        elActions.find("*").remove();

        function execute(action) {
            elDialog.find("input[name=name]").val("precog." + action.token);
            elText.text(action.handler(code));
            selectCode();
        }

        ui.radios(elActions, $(actions).map(function(i, action) {
            return {
                  label : action.name
                , handler : function() { execute(action); }
                , group : "actions"
            };
        }));

        execute(actions[0]);

        elActions.find(".ui-button:first").click();

        elDialog.dialog("option", "position", "center");
        elDialog.dialog("option", "title", title);
        elDialog.dialog("open");

        if(clip) {
            $(window).trigger("resize"); // triggers reposition of the Flash overlay
        } else {
            clip = elDialog.dialog("widget").find('.ui-dialog-buttonpane button.ui-button:first')
                .css({ zIndex : 1000000 })
                .zclip({
                    path:'js/libs/jquery/zclip/ZeroClipboard.swf',
                    copy:function(){
                        return ""+elText.val();
                    },
                    afterCopy : function() {
                        notification.quick("copied to clipboard");
                    }
                });
        }
    };
});