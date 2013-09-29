//** QUERY
ReportGrid.query
	.histogram({
		path : pathvalue,
		event : "impression",
		property : "browser",
		tag : "location",
		location : '/usa'
	})