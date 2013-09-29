//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		where : { 'browser' : 'safari', 'gender' : 'male' }
	})
