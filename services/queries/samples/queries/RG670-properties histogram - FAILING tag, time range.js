//** QUERY
ReportGrid.query
	.propertiesHistogram({
		path : pathvalue,
		event : "impression",
		property : "keywords",
		tag : "location",
		start : "2 hours ago",
		end : "now"
	})