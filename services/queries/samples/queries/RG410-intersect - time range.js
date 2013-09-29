//** QUERY
ReportGrid.query
	.intersect({
		path : pathvalue,
		event : "impression",
		properties : [{ property : "browser" }],
		start : "2 hours ago",
		end : "now"
	})