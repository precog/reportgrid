//** QUERY
ReportGrid.query
	.count({
		path : pathvalue,
		event : "impression",
		tag : "location",
		property : 'browser',
		value : 'chrome',
		location : '/',
	})
