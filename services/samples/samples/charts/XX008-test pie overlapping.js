//** VIZ
ReportGrid.pieChart("#chart", {
	axes : ["label", "count"],
	datapoints : [
		{ label : "Small but long", count : 2},
		{ label : "Huge", count : 98}
	],
	options : {
		labelorientation : "horizontal"
	}
});
