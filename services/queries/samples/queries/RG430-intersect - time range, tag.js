//** QUERY
ReportGrid.query
	.intersect({
		path : pathvalue,
		event : "impression",
		properties : [{ property : "browser" }],
		tag : "location",
		location : '/',
		start : "4 hours ago",
		end : "now"
	})
