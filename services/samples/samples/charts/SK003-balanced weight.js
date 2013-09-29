//** LOAD
fic-clips

//** VIZ
ReportGrid.sankey("#chart", {
	axes : ["count"],
	datapoints : data(),
	options : {
		layoutmethod : "weightbalance"
	}
});

//** CLASS
big