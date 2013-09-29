define([],

    function() {
        return {
            selectText : function(element) {
                var range;
                if (document.body.createTextRange) { // ms
                    range = document.body.createTextRange();
                    range.moveToElementText(element);
                    range.select();
                } else if (window.getSelection) {
                    var selection = window.getSelection();
                    if (selection.setBaseAndExtent) { // webkit
                        selection.setBaseAndExtent(element, 0, element, 1);
                    } else { // moz, opera
                        range = document.createRange();
                        range.selectNodeContents(element);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                }
            }
        }
    });