//** LOAD
usa-deathrate-by-gender

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : ["year", "deathRate"],
	datapoints : data(),
	options : {
		label : {
			axis : function(a) { return ReportGrid.humanize(a); },
			tickmark : function(v, a) { return a == 'year' ? v: ReportGrid.format(v); },
			datapointover : function(dp, stats) {
				return ReportGrid.humanize(stats.type) + " for "
					+ ReportGrid.humanize(dp['gender']) + "s in " + dp.year + ": "
					+ ReportGrid.format(dp[stats.type]);
			}
		},
		displayrules : true,
		segmenton : "gender"
	}
})