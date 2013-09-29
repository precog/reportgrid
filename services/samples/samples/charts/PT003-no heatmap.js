//** LOAD
fic-sales

//** VIZ
ReportGrid.pivotTable("#chart", {
	axes : ["model", "quarter", "market", "value"],
	datapoints : data(),
	options : {
		columnaxes : 2,
		displayheatmap : false
	}
});

//** CLASS
big