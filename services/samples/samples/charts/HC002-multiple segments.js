//** LOAD
usa-agestructure

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ["gender","count"],
	datapoints : data(),
	options : {
		segmenton : "age",
		stacked : false,
		displayrules : true,
		horizontal : true
	}
});
