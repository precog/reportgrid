//** LOAD
usa-population-and-area-1790-2000

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : [{ type : "population", variable : "dependent" }, "year"],
	datapoints : data(),
	options : {
		label : {
			axis : function(a) { return a },
			tickmark : function(v, a) { return a == 'year' ? v: ReportGrid.format(v); },
			datapointover : function(dp) {
				return dp.year + ": " + ReportGrid.format(dp.population) + " individuals";
			}
		}
	}
})