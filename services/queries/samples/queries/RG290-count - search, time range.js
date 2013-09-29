//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		where : { 'browser' : 'safari', 'gender' : 'male' },
		start : "2 hours ago",
		end : "now"
	})
