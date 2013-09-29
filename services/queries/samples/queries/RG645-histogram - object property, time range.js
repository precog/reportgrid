//** QUERY
ReportGrid.query
	.histogram({
		path : pathvalue,
		event : "impression",
		property : "keywords",
		start : "yesterday",
		end : "now"
	})