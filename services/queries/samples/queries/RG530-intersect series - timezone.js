//** QUERY
ReportGrid.query
	.intersectSeries({
		path : pathvalue,
		event : "impression",
		properties : [{ property : "browser" }],
		timezone : "2"
	})