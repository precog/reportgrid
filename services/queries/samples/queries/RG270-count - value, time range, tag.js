//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		tag : "location",
		property : 'browser',
		value : 'chrome',
		location : '/',
		start : "4 hours ago",
		end : "now"
	})
