//** QUERY
ReportGrid.query
	.histogram({
		path : pathvalue,
		event : "impression",
		property : "browser",
		start : "2 hours ago",
		end : "now",
		top : 3
	})