//** QUERY
ReportGrid.query
	.histogram({
		path : pathvalue,
		event : "impression",
		property : "browser",
		top : 3
	})