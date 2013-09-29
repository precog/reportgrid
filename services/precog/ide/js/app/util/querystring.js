define([], function() {
    var params = {};

    function getCtx(ctx) {
        if(!ctx) {
            return window.location.search.substr(1);
        } else if(ctx.substr(0, "http://".length) === "http://" || ctx.substr(0, "https://".length) === "https://") {
            var arr = ctx.split("?");
            arr.shift();
            return arr.join("?");
        } else if(ctx.substr(0, 1) === "?") {
            return ctx.substr(1);
        } else {
            return ctx;
        }
    }

    function getParameterByName(name, ctx)
    {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "(?:^|&)" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(ctx);
        if(results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    function getAll(ctx) {
        var values = {},
            e,
            a = /\+/g,  // Regex for replacing addition symbol with a space
            r = /([^&=]+)=?([^&]*)/g,
            d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
            q = ctx.substring(1);

        while (e = r.exec(q))
            values[d(e[1])] = d(e[2]);

        return values;
    }

    return {
        get : function(name, ctx) {
            ctx = getCtx(ctx);
            return getParameterByName(name, ctx);
        },

        all : function(ctx) {
            ctx = getCtx(ctx);
            if(!params[ctx])
            {
                params[ctx] = getAll(ctx);
            }

            return params[ctx];
        }
    }
});