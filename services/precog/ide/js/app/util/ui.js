define([
      "order!ui/jquery.ui.core"
    , "order!ui/jquery.ui.widget"
    , "order!ui/jquery.ui.mouse"
    , "order!ui/jquery.ui.button"
    , "order!ui/jquery.ui.tabs"
    , "order!ui/jquery.ui.menu"
    , "order!ui/jquery.ui.progressbar"
],

function() {
    return {
        button : function(el, o) {
            o = $.extend({
                disabled : false,
                label : "",
                text : false,
                handler : function() {},
                icons : null
            }, o);

            var options = {
                disabled : o.disabled,
                text: o.text,
                label: o.label,
                icons: o.icon ? { primary : o.icon } : o.icons
            };

            if(!options.icons) delete options.icons;

            var button = el.append('<button></button>')
                .find('button:last')
                .button(options)
                .click(function(e) {
                    o.handler.apply(button.get(0));
                    e.preventDefault(); return false;
                });

            return button;
        },
        menu : function(el, o) {
            o = $.extend({
                disabled : false
            }, o);
            return el.menu({
                disabled: o.disabled
            });
        },
        contextmenu : function(el, o) {
            if("string" === typeof el) {
                el = $("body").append(el).find("div:last ul");
            } else {
                el = $(el);
            }
            var parent = el.parent(),
                o = this.menu(el, o);
            parent.hide();
            parent.mouseleave(function() {
                parent.hide();
            }).click(function() {
                parent.hide();
            });
            return parent;
        },
        tabs : function(el, o) {
            return el.tabs(o);
        },
        radios : function(el, actions) { /* group, label, handler */
            if(actions) {
                this.uid = "undefined" == typeof this.uid ? 1 : this.uid + 1;
                el.find("*").remove();
                $(actions).each(function(i, action) {
                    var name = action.group,
                        id = "pg-buttonset-" + this.uid + "-" + i,
                        label = action.label;
                    var btn = el.append('<input type="radio" id="'+id+'" name="'+name+'" /><label for="'+id+'">'+label+'</label>').find("#"+id);
                    btn.click(function() {
                        action.handler(action);
                    });
                });
            }
            return el.buttonset();
        },
        buttonset : function(el) {
            return el.buttonset();
        },
        progressbar : function(el) {
            return el.progressbar();
        }
    };
});