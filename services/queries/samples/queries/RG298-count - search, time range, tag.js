//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		tag : "location",
		location : '/',
		where : { 'browser' : 'safari', 'gender' : 'male' },
		start : "4 hours ago",
		end : "now"
	})
