//** QUERY
ReportGrid.query
	.rawEvents({
		path : pathvalue,
		event : "impression",
		tag : "location",
		start: "7 days ago",
		location : '/italy'
	})