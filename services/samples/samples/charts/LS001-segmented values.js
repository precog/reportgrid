//** LOAD
usa-deathrate-by-race

//** VIZ

var years = {},
	max = 6000,
	data = data(),
	v;
// inject the value for the positioning the bottom of the area correctly
data.forEach(function(item) {
	item.y0 = (v = years[item.year]) ? v : 0;
	years[item.year] = item.y0 + item.deathRate;
});

ReportGrid.lineChart("#chart", {
	axes : ["year", { type : "deathRate" }],
	datapoints : data,
	options : {
		label : {
			axis : function(a) { return ReportGrid.humanize(a); },
			tickmark : function(v, a) { return a == 'year' ? v: ReportGrid.format(v); },
			datapointover : function(dp, stats) {
				return ReportGrid.humanize(stats.type) + " for "
					+ ReportGrid.humanize(dp['race']) + " people in "
					+ dp.year + ": " + ReportGrid.format(dp[stats.type], "I"); }
		},
		segmenton : "race",
		displayarea : true,
		y0property : "y0",
		effect: "dropshadow"
	}
})