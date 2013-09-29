//** QUERY
ReportGrid.query
	.series({
		path : pathvalue,
		event : "impression",
		where : { 'browser' : 'safari', 'gender' : 'male' }
	})
