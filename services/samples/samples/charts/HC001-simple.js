//** LOAD
english-speakers

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ["country","count"],
	datapoints : data(),
	options : {
		displayrules : true,
		horizontal : true
	}
});