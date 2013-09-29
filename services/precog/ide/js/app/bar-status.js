define([
    "order!util/ui"
    , "text!templates/toolbar.status.html"
    , "text!templates/menu.editor.status.html"
],

    function(ui, tplToolbar, tplMenu) {

        return function(el, editor, layout) {
            var wrapper;
            el.append(tplToolbar);

            var menu = ui.contextmenu(tplMenu);

            el.find('.pg-editor-settings-trigger').click(function() {
                if(menu.is(":visible")) {
                    menu.hide();
                    return;
                }
                var pos = $(this).offset();
                menu.css({
                    position : "absolute",
                    top : (pos.top - menu.outerHeight()) + "px",
                    left : (pos.left) + "px"
                }).show();
            });

            function updateTabSize() {
                var size = "" + editor.getTabSize();
                el.find('.pg-tab-size').text(size);

                menu.find('.pg-tab-size-option').each(function() {
                    if($(this).attr("data-tab-size") === size) {
                        $(this).addClass('ui-state-active');
                    } else {
                        $(this).removeClass('ui-state-active');
                    }
                });
            }

            menu.find('.pg-tab-size-option').click(function() {
                editor.setTabSize(parseInt($(this).attr("data-tab-size")));
            });

            function updateSoftTabs() {
                var toggle = editor.getUseSoftTabs();
                menu.find('.pg-soft-tabs').each(function() {
                    if(toggle) {
                        $(this).addClass('ui-state-active');
                    } else {
                        $(this).removeClass('ui-state-active');
                    }
                });
            }

            menu.find('.pg-soft-tabs').click(function() {
                editor.setUseSoftTabs(!editor.getUseSoftTabs());
            })

            menu.find('.pg-change-orientation').click(function() {
                layout.setIoVertical(!layout.isIoVertical());
            })

            $(editor).on("tabSizeChanged", updateTabSize);
            $(editor).on("useSoftTabsChanged", updateSoftTabs);

            $(editor).on("change", function(_, code) {
                el.find('.pg-words').text(code.split(/\b[a-z0-9]+?\b/gi).length-1);
                el.find('.pg-characters').text(code.length);
            });

            $(editor).on("changeCursor", function(_, pos) {
                el.find('.pg-line').text(pos.row+1);
                el.find('.pg-column').text(pos.column+1);
            });

            updateTabSize();
            updateSoftTabs();

            var elProgressBar = ui.progressbar(el.find(".pg-progressbar"));
            elProgressBar.hide();

            var elExecutionTime = el.find(".pg-execution-time");
            elExecutionTime.hide();

            var progress = {
                startTime : null,
                killProgress : null,
                lastExecution : 2000,
                start : function() {
                    clearInterval(progress.killProgress);
                    progress.startTime = new Date().getTime();
                    progress.update();
                    progress.killProgress = setInterval(function() { progress.update(); }, 50);
                    elExecutionTime.hide();
                    elProgressBar.show();
                },
                update : function() {
                    var delta = new Date().getTime() - progress.startTime,
                        percent = parseInt(delta / progress.lastExecution * 1000) / 10;
                    if(percent > 100)
                        percent = 100;
                    else if(percent < 0)
                        percent = 0;
                    elProgressBar.progressbar("value", percent);
                },
                end : function(success) {
                    if(success)
                    {
                        progress.lastExecution = new Date().getTime() - progress.startTime;
                        elExecutionTime.html("query time " + progress.lastExecution + " ms");
                    }
                    elProgressBar.hide();
                    elExecutionTime.show();
                    clearInterval(progress.killProgress);
                }
            }


            var lastRequest = 2;
            return wrapper = {
                startRequest : function() {
                    progress.start();
                },
                endRequest : function(success) {
                    progress.end(success);
                }
            }
        }
    });