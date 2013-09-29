//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		tag : "location",
		location : '/',
		where : { 'browser' : 'safari', 'gender' : 'male' }
	})
