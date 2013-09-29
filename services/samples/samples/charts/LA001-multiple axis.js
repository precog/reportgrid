//** LOAD
usa-population-and-area-1790-2000

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : ["year",
			{ type : "area", variable : "dependent" },
			{ type : "population", variable : "dependent" }],
	datapoints : data(),
	options : {
		label : {
			axis : function(a) { return a },
			tickmark : function(v, a) { return a == 'year' ? v: ReportGrid.format(v); },
			datapointover : function(dp, stats) {
				return ReportGrid.humanize(stats.type) + ": "
				+ ReportGrid.format(dp[stats.type]) + " in " + dp.year; }
		},
		labelangle : function(a) { return a == "year" ? 140 : 0; },
		labelanchor : function(a) {
			return (a == "population" || a == "year") ? "left" : "right"
		},
		displayarea : true
	}
})