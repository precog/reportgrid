define([
      "util/querystring"
    , "https://api.reportgrid.com/js/precog.js"
],

function(qs){
// TODO basePath

    var config   = window.Precog.$.Config,
        params   = ["tokenId", "analyticsService", "basePath"],
        contexts = [null],
        reprecog = /(require|precog)[^.]*.js[?]/i;

    $('script').each(function() {
        if(!this.src || !reprecog.test(this.src)) return;
        contexts.push(this.src);
    });

    function appendConfig(ctx) {
        for(var i = params.length-1; i >= 0; i--) {
            var param = params[i],
                value = qs.get(param, ctx);
            if(value !== "") {
                config[param] = value;
                params.splice(i, 1);
            }
        }
    }

    while(contexts.length > 0 && params.length > 0) {
        appendConfig(contexts.shift());
    }

    var q = {
        query : function(text) {
            $(q).trigger("execute", [text, this.lastExecution]);
            var me = this,
                start = new Date().getTime();
            window.Precog.query(text, function(r) {
                me.lastExecution = new Date().getTime() - start;
                $(q).trigger("completed", [r]);
            }, function(code, e) {
                if("string" == typeof e) e = { message : e };
                $(q).trigger("failed", e);
            })
        },
        paths : function(parent, callback) {
            window.Precog.query(":ls " + parent, function(r) {
                callback(r.map(function(path) {
                    return path.substr(-1) === '/' && path.substr(0, path.length-1) || path;
                }).sort());
            }, function(code, e) {
                throw "Unable To Query Path API";
            })
        },
        config : config,
        lastExecution : 2000,
        cache : window.Precog.cache
    };

    return q;
});