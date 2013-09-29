//** LOAD
usa-deathrate-by-race

//** VIZ
ReportGrid.heatGrid("#chart", {
	axes : ["race","year","deathRate"],
	datapoints : data(),
	options : {
		color : "i:#00f,#0ff,#0f0,#ff0,#f00",
		label : {
			tickmark : function(v, t) { return v; },
			datapointover : function(dp) {
				return "death rate for " + dp.race + " in " 
					+ dp.year + ": " + ReportGrid.format(dp.deathRate); 
			}
		}
	}
});

//** CLASS
square