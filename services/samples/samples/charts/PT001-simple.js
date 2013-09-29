//** LOAD
fic-sales

//** VIZ
ReportGrid.pivotTable("#chart", {
	axes : ["model", "quarter", "market", "value"],
	datapoints : data()
});

//** CLASS
very-tall