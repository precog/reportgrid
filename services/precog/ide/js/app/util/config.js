define(["util/storagemonitor"], function(createStore) {
    var CONFIG_KEY = "pg-quirrel-ide-config",
        defaults = {
            theme : "gray",
            indentUsingSpaces : false,
            tabSize : 2,
            softTabs : true,
            disableClientCache : true,
            ioPanesVertical : true
        };

    return createStore(CONFIG_KEY, defaults);
});