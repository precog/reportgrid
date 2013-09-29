define([],

function() {

    var elPanel = $('<div class="ui-widget"><div class="ui-content ui-state-error ui-corner-all"></div></div>'),
        elError = elPanel.find('.ui-state-error');

    return {
        type : "error",
        name : "Error",
        display : false,
        panel : function() {
            return elPanel;
        },
        update : function(error) {
            var message = '<p>'+error.message+'</p>';
            if("undefined" !== typeof error.lineNum) {
                message += '<p>Error at line '+error.lineNum+', column '+(error.colNum+1)+':</p><br>';
/*
                var indicator = [];
                for(var i = 0; i < error.colNum; i++)
                {
                    indicator.push(' ');
                }
                indicator.push('\u2B06');

                var line = error.line.replace(/\t/g, ' ');

                message += '<pre>'+(line || "&nbsp;")+'\n'+indicator.join('')+'</pre><br>';
*/
                message += '<pre>'+error.detail+'</pre>';
            }
            elError.html(message);
        }
    };
});

// "line":"//","lineNum":1,"colNum":1,"detail":"error:1: expected operator or path or expression\n  //\n   ^"}
