//** QUERY
ReportGrid.query
	.series({
		path : pathvalue,
		event : "impression",
		where : {
			"gender" : "male",
			"browser" : "safari"
		},
		timezone : "2"
	})
