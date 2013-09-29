//** LOAD
usa-agestructure

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ["gender","count"],
	datapoints : data(),
	options : {
		segmenton : "age",
		label : {
			datapointover : function(dp) {
				return ReportGrid.format(dp.count) + " individuals in the years range "+dp.age;
			}
		},
		horizontal : true
	}
});
