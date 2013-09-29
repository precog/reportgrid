//** QUERY
ReportGrid.query
	.propertiesHistogram({
		path : pathvalue,
		event : "impression",
		property : "keywords",
		start : "2 hours ago",
		end : "now"
	})