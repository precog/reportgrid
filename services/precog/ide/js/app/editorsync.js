define([

],

function() {

    return function(editor, editors, config) {
         function change(_, code) {
             editors.setCode("" + code);
         }

         function monitor(_, code) {
             editor.set("" + code);
         }

         $(editors).on("activated", function(_, index) {
             editor.set("" + editors.getCode());
             $(editor).on("change", change);
             editor.focus();

             editors.monitor.bind(editors.getKey(index)+".code", monitor);
         });

         $(editors).on("deactivated", function(_, index) {
             editors.monitor.unbind(editors.getKey(index)+".code", monitor);
             $(editor).off("change", change);
             editors.setCode(editor.get(), index);
         });
    }
});