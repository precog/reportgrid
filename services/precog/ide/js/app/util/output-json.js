define([],

function() {
    var elPanel = $('<div class="ui-widget"><pre class="json ui-content"></pre></div>'),
        elOutput = elPanel.find('.json');

    var formatted = true,
        spaces = 2;

    return {
        type : "json",
        name : "Json",
        panel : function() { return elPanel; },
        update : function(data) {
            var json = formatted ? JSON.stringify(data, null, spaces) : JSON.stringify(data);
            elOutput.text(json);
        }
    };
});