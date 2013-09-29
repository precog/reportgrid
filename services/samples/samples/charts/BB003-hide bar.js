//** LOAD
english-speakers

//** VIZ
ReportGrid.leaderBoard("#chart", {
	axes : ["country", "count"],
	datapoints : data(),
	options : {
		displaybar : false
	}
});