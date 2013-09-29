define([
      "util/ui"
    , "config/output-results"
    , "config/output-formats"
    , "order!util/dialog-export"
    , "text!templates/toolbar.output.html"
],

function(ui, formats, exportLanguages, openDialog, tplToolbar) {
    var map = {};

    $.each(formats, function(_, format) {
        map[format.type] = format;
    });

    var radioIndex = this.radioIndex = ("undefined" !== typeof this.radioIndex && this.radioIndex || 0) + 1;

    return function(el, editors) {
        var wrapper,
            last = {
                result : null,
                type : null,
                current : null
            },
            elToolbar = el.find('.pg-toolbar').append(tplToolbar),
            elToolbarTypeContext = el.find('.pg-toolbar-context .pg-toolbar-result-type'),
            elToolbarMainContext = el.find('.pg-toolbar-context .pg-toolbar-result-general'),
            elOutputs = elToolbar.find('.pg-output-formats'),
            elResult  = el.find('.pg-result');

        ui.button(elToolbarMainContext, {
            icon : "ui-icon-arrowthickstop-1-s",
            handler : function() {
                openDialog("Download Query", exportLanguages, editors.getOutputResult());
            }
        });

        $.each(formats, function(i, format) {
            if(format.display)
            {
                var id = "pg-output-type-radio-" + radioIndex + "-" + (++i);
                format.display = elOutputs.append('<input type="radio" id="'+ id
                    + '" name="radio" data-format="'
                    + format.type
                    + '" /><label for="'+id+'">'
                    + format.name
                    + '</label>').find("#"+id);
                format.display.click(function() {
                    if(format.type === last.type)
                    {
                        last.current = format.type;
                        return;
                    }
                    wrapper.set(last.result, format.type);
                });
            }

            format.panel = format.panel();
            elResult.append(format.panel);
            format.toolbar = format.toolbar();
            elToolbarTypeContext.append(format.toolbar);

            $(format.toolbar).hide();
            $(format.panel).hide();
            $(format).on("update", function() {
                wrapper.set();
            });
            $(format).on("optionsChanged", function(_, options) {
                $(wrapper).trigger("optionsChanged", options);
            });
        });


        ui.buttonset(elOutputs);

        function resize() {
            if(map[last.type]) {
                var el = map[last.type].panel;
                el.css({
                    width  : el.parent().width() + "px",
                    height : el.parent().height() + "px"
                });
                map[last.type].resize();
            }
        }

        function activatePanel(result, type, options) {
            if(type !== last.type) {
                if(last.type && map[last.type])
                {
                    map[last.type].deactivate();
                    $(map[last.type].toolbar).hide();
                    $(map[last.type].panel).hide();
                }
                $(map[type].toolbar).show();
                $(map[type].panel).show();
                map[type].activate();
                clearTimeout(this.killActivatePanel);
                this.killActivatePanel = setTimeout(resize, 0);
            }
            if(map[type].display) {
                map[type].display[0].checked = true;
                map[type].display.button("refresh");
            }
            map[type].update(result, options);
        }

        return wrapper = {
            set : function(result, type, options) {
                if("undefined" === typeof result)
                    result = result || last.result || null;
                type = type || last.current || 'table';

                if(result == null) {
                    activatePanel({ message : "please, type and execute a query" }, type = "message", options);
                } else if(result instanceof Array && result.length == 0) {
                    activatePanel({ message : "empty dataset" }, type = "message", options);
                } else if(map[type]) {
                    activatePanel(result, type, options);
                } else {
                    activatePanel({ message : "invalid result type: " + type }, type = "error", options);
                }

                if(result) last.result = result;
                if(last.type != type) {
                    last.type = type;
                    $(wrapper).trigger("typeChanged", type);
                }
                if(map[type] && map[type].display) {
                    last.current = type;
                }

                elOutputs.find("input[type=radio]").each(function() {
                    $(this).attr("checked", $(this).attr("data-format") === type);
                });
                elOutputs.buttonset("refresh");
            },
            last : last,
            resize : resize
        };
    }
});