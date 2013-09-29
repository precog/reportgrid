define([],

 function() {
    var isfullscreen,
        requestFullScreen,
        exitFullScreen;
    if(document.documentElement.requestFullscreen) {
        requestFullScreen = function(el) { el.requestFullscreen(); };
    } else if(document.documentElement.mozRequestFullScreen) {
        requestFullScreen = function(el) { el.mozRequestFullScreen(); };
    } else if (document.documentElement.webkitRequestFullScreen) {
        requestFullScreen = function(el) {
            el.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            if (!document.webkitCurrentFullScreenElement) {
                el.webkitRequestFullScreen();
            }
        };
    } else {
        setTimeout(function() { $('.pg-precog-ide .pg-fullscreen').hide(); }, 20);
        requestFullScreen = function() { console.log("your browser doesn't support the FullScreen option"); };
    }
    if(document.exitFullscreen) {
        exitFullScreen = function() { document.exitFullscreen(); };
    } else if(document.mozCancelFullScreen) {
        exitFullScreen = function() { document.mozCancelFullScreen(); };
    } else if (document.webkitCancelFullScreen) {
        exitFullScreen = function(el) {
            el.webkitRequestFullScreen(); // chrome doesn't behave correctly when the app is started fullscreen
            document.webkitCancelFullScreen();
        };
    } else {
        exitFullScreen = function() { console.log("your browser doesn't support the FullScreen option"); };
    }
    function toggle() {
        isfullscreen = (!window.screenTop && !window.screenY);
        $('.pg-precog-ide .pg-fullscreen span.k-link').text(isfullscreen ? "reduce" : "fullscreen");
    }
    if(document.addEventListener) {
        document.addEventListener("fullscreenchange", toggle, false);
        document.addEventListener("mozfullscreenchange", toggle, false);
        document.addEventListener("webkitfullscreenchange", toggle, false);
    }
    toggle();
    return {
        toggle : function(n) {
            n = n || document.documentElement;
            if(isfullscreen) {
                exitFullScreen(n);
            } else {
                requestFullScreen(n);
            }
        },
        isFullScreen : function() { return isfullscreen; }
    };
});