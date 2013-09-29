define([],

function() {

    var elPanel = $('<div class="ui-widget"><div class="pg-message ui-content ui-state-highlight ui-corner-all"></div></div>'),
        elMessage = elPanel.find('.pg-message');

    return {
        type : "message",
        name : "Message",
        display : false,
        panel : function() {
            return elPanel;
        },
        update : function(result) {
            var message = '<p>'+result.message+'</p>';
            elMessage.html(message);
        }
    };
});

// "line":"//","lineNum":1,"colNum":1,"detail":"result:1: expected operator or path or expression\n  //\n   ^"}
