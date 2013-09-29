//** LOAD
usa-population-and-area-1790-2000

//** VIZ
var max = 0,
	data = data();
data.forEach(function(dp) {
	if(dp.area > max)
		max = dp.area;
})

ReportGrid.scatterGraph("#chart", {
	axes : ["year", "population"],
	datapoints : data,
	options : {
//		labelorientation : "ortho"
		label : {
			tickmark : function(v, t) { return t == "year" ? v : ReportGrid.format(v); },
			axis : function(t) { return ReportGrid.humanize(t); },
			datapointover : function(dp, stats) {
				return "year: " + dp.year +
					", population: " + ReportGrid.format(dp.population) +
					", area: " + ReportGrid.format(dp.area);
			}
		},
		displayrules : true,
		symbol : function(dp) {
			return ReportGrid.symbol("circle", dp.area / max * 400);
		},
		labelangle : function(a) { return a == 'population' ? 0 : 45; }
	}
})