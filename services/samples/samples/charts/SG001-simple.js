//** LOAD
usa-deathrate-by-race

//** VIZ
ReportGrid.streamGraph("#chart", {
	axes : ["year", "deathRate"],
	datapoints : data(),
	options : {
		label : {
			axis : function(a) { return ReportGrid.humanize(a); },
			tickmark : function(v, a) { return a == 'year' ? v: ReportGrid.format(v); },
			datapointover : function(dp, stats) {
				return ReportGrid.humanize(stats.type) + " for "
					+ ReportGrid.humanize(dp['race']) + " race in " + dp.year
					+ ": " + ReportGrid.format(dp[stats.type]);
			}
		},
		segmenton : "race"
	}
})

//** CLASS
wide