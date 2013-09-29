//** QUERY
ReportGrid.query
	.rawEvents({
		path : pathvalue,
		event : "impression",
		properties : "browser,age"
	})
	.unique()
	.sortValues({ age : true, browser : true })