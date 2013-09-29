//** LOAD
boulder-weather-2011-1Q

//** VIZ

ReportGrid.lineChart("#chart", {
	axes : ["time:day", "tAverage"],
	datapoints : data(),
	options : {
		effect: "none"
	}
})

//** CLASS
wide