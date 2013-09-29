//** QUERY
ReportGrid.query
	.histogram({
		path : pathvalue,
		event : "impression",
		property : "browser",
		tag : "location",
		location : '/usa',
		start : "2 hours ago",
		end : "now",
		top : 3
	})