//** QUERY
ReportGrid.query
	.rawEvents({
		path : pathvalue,
		event : "impression",
		where : { gender : "male", age : 18 }
	})