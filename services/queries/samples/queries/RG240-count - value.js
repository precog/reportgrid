//** QUERY
ReportGrid.query
	.properties({ path : pathvalue, event : "impression" })
	.values()
	.count()
