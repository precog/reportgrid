define([
      "order!util/ui"
    , "app/editors"
    , "order!util/dialog-export"

    , "config/output-languages"
    , "text!templates/toolbar.editor.html"
],

function(ui, editors, openDialog, exportLanguages, tplToolbar) {

    return function(el) {
        el.append(tplToolbar);
        var elContext = el.find('.pg-toolbar-context'),
            autoGoToTab = false,
            tabs = ui.tabs(el.find('.pg-editor-tabs'), {
                tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'>Remove Tab</span></li>",
                add: function(event, ui) {
                    var index = ui.index;
                    if(autoGoToTab)
                    {
                        tabs.tabs("select", ui.index);
                        editors.activate(ui.index);
                    }
                }
            }),
            index = 0;

        tabs.on({
            click : function(){
                var index = $("li", tabs).index($(this).parent());
                editors.remove(index);
            }
        }, '.ui-icon-close');

        tabs.on({
            click : function() {
                var index = $("li", tabs).index($(this).parent());
                editors.activate(index);
            }
        }, 'li a');

        ui.button(elContext, {
            icon : "ui-icon-arrowthickstop-1-s",
            handler : function() {
                openDialog("Download Query", exportLanguages, editors.getCode());
            }
        });

        ui.button(elContext, {
            icon : "ui-icon-plus",
            handler : function() {
                autoGoToTab = true;
                editors.add();
                autoGoToTab = false;
            }
        });

        $(editors).on("added", function(e, editor) {
            tabs.tabs("add", "#pg-editor-tab-" + (++index), editor.name);
        });

        $(editors).on("removed", function(e, index) {
            tabs.tabs("remove", index);
        });

        $(editors).on("activated", function(e, index) {
            tabs.tabs("select", index);
        });
    }
});