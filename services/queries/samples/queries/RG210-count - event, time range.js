//** QUERY
ReportGrid.query
	.count({
		path  : pathvalue,
		event : "impression",
		start : "2 hours ago",
		end   : "now"
	})
