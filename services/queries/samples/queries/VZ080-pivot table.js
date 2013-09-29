//** QUERY
ReportGrid.query
	.intersect({
		path : pathvalue,
		event : "impression",
		properties : ["gender", "env", "browser"]
	})
	.sortValue("env")

//** VIZ
ReportGrid.pivotTable("#chart", {
	axes : ["gender", "env", "browser", 'count'],
	load : loader
})