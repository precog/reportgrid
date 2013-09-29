//** QUERY
ReportGrid.query
	.events({ path : pathvalue })
	.values({
		property : "browser",
		start : "5 hours ago",
		end : "now"
	})
