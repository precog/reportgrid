define([
    "jlib/pnotify/jquery.pnotify"
], function() {
    var timeout = 5000,
        shorttimeout = 2500,
        longtimeout  = 10000;
    return {
        success : function(title, o) {
            o = o || {};

            var options = {
                  pnotify_title : title
//                , pnotify_animation: 'show'
                , pnotify_delay: timeout
                , pnotify_sticker : true
                , pnotify_sticker : false
            };

            if(o.text) options.pnotify_text = o.text;
            if(o.type) options.pnotify_type = o.type;
            if(o.icon) options.pnotify_notice_icon = 'ui-icon ' + o.icon;
            if("undefined" !== typeof o.timeout) options.pnotify_delay = o.timeout;
            if("undefined" !== typeof o.hide) options.pnotify_hide = o.hide;
            if(o.before_open)  options.pnotify_before_open  = o.before_open;
            if(o.before_close) options.pnotify_before_close = o.before_close;
            if("undefined" !== typeof o.history) options.pnotify_history = o.history;
            if("undefined" !== typeof o.sticker) options.pnotify_sticker = o.sticker;

            return $.pnotify(options);
        },
        quick : function(title, o) {
            o = o || {};
            o.timeout = shorttimeout;
            return this.success(title, o);
        },
        progress : function(title, o) {
            var cur_value = 1,
                pnotify,
                $progress,
                $message,
                text = o.text || "";
            // progress
            // complete

            var k;

            o.hide = false;
            o.text = '<div class="pg-message">'+text+'</div><div class="pg-progress-bar"></div>';
            o.before_open = function(pn) {
                pnotify = pn;
                $progress = pn.find("div.pg-progress-bar");
                $message = pn.find("div.pg-message");
            };

            o.progressStart = function(message) {
                clearInterval(k);
                pnotify.show();
                $message.removeClass("ui-state-error")
                $message.html(message);
                $progress.show();
                $progress.progressbar({
                    value : 0
                });
            };

            o.progressStep = function(value) {
                var v = value * 100;
                if(v > 100) v = 100;
                $progress.progressbar({
                    value : v
                });
            };

            o.progressComplete = function(message) {
                $message.html(message);
                $progress.hide();
                k = setTimeout(function() {
                    pnotify.hide();
                }, longtimeout);
            };

            o.progressError = function(err) {
                $progress.hide();
                $message.addClass("ui-state-error").html(err);
                k = setTimeout(function() {
                    pnotify.hide();
                }, longtimeout);
            };

            return o.el = this.success(title, o);
        }
    }
});