//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		property : "gender",
		value : "female" ,
		start : "2 hours ago",
		end : "now"
	})
