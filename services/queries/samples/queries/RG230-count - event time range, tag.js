//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		tag : "location",
		location : '/',
		start : "4 hours ago",
		end : "now"
	})
