//** TOKEN
87984064-827D-4C42-8BAF-42A748BA6DCA

//** VIZ
var path  = '/se12014/timzon-snapabug-widget/',
	start = "7 days ago",
	end   = "now";

ReportGrid.lineChart("#osestime", {
    axes : ["time:day", "count"],
    load : ReportGrid.query
         .values({
            path : path,
            event : "case",
            property : "os",
         })
        .series({
            periodicity : "day",
            start : start,
            end : end
        })
 		.split("os")
 		.stackOperation(function(a ,b) {
 			if(null == a.y0) a.y0 = 0;
 			b.y0 = a.y0 + a.count;
 		}, "time:day")
 		.stackReverse(),
    options : {
        segmenton : "os",
        displayrules : function(type) { return type == "count" },
        interpolation : "monotone",
		displayarea : true,
		y0property : "y0",
		effect : "none"
    }
});

ReportGrid.lineChart("#browserstime", {
    axes : ["time:day", "count"],
    load : ReportGrid.query
         .values({
            path : path,
            event : "case",
            property : "browser",
         })
        .series({
            periodicity : "day",
            start : start,
            end : end
        })
 		.split("browser")
 		.stackOperation(function(a ,b) {
 			if(null == a.y0) a.y0 = 0;
 			b.y0 = a.y0 + a.count;
 		}, "time:day")
 		.stackReverse(),
    options : {
        segmenton : "browser",
        displayrules : function(type) { return type == "count" },
        interpolation : "monotone",
		displayarea : true,
		y0property : "y0",
		effect : "none"
    }
});

//** HTML
<div id="osestime" class="chart"></div>
<div id="browserstime" class="chart"></div>

//** STYLE
.chart {
    width: 600px;
    height: 400px;
    float: left;
}