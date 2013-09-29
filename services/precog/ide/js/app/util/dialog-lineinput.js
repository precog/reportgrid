define([
      "text!templates/dialog.lineinput.html"
    , "order!util/ui"
    , "util/dom"
    , "order!ui/jquery.ui.draggable"
    , "order!ui/jquery.ui.position"
    , "order!ui/jquery.ui.resizable"
    , "order!ui/jquery.ui.dialog"
], function(tplDialog, ui, dom) {
    var currentHandler,
        currentValidator,
        elDialog = $('body')
            .append(tplDialog)
            .find('.pg-dialog-lineinput:last')
            .dialog({
                  modal : true
                , autoOpen : false
                , resizable : false
                , dialogClass : "pg-el"
                , width : "400px"
                , closeOnEscape: true
                , buttons : [{
                    text : "Close",
                    click : function() {
                        elDialog.dialog("close");
                        return true;
                    }
                }, {
                    text : "OK",
                    click : function(e) {
                        elDialog.find(".pg-error").hide()
                        var value = elDialog.find(".pg-lineinput input[type=text]").val();
                        if(currentValidator) {
                            var message = currentValidator(value);
                            if(message) {
                                elDialog.find(".pg-error").html(message).show();
                                e.preventDefault(); return false;
                            }
                        }
                        if(currentHandler)
                            currentHandler(value);
                        elDialog.dialog("close");
                    }
                }]
            })
    ;
    function reposition() {
        elDialog.dialog("option", "position", "center");
    }

    elDialog.bind("dialogopen", function() { $(window).on("resize", reposition); });
    elDialog.bind("dialogclose", function() { $(window).off("resize", reposition); });
    return function(title, message, label, defaultInput, validator, handler) {
        currentValidator = validator;
        currentHandler = handler;
        elDialog.find(".pg-message").html(message || "");
        elDialog.find(".pg-lineinput input[type=text]").val(defaultInput || "");
        elDialog.find(".pg-error").hide();
        elDialog.find("label").html((label && (label + ":")) || "");
        elDialog.dialog("option", "position", "center");
        elDialog.dialog("option", "title", title);
        elDialog.dialog("open");
    };
});