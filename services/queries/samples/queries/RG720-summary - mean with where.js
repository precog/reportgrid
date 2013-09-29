//** QUERY
ReportGrid.query
	.summary({
		path     : pathvalue,
		event    : "impression",
		property : "age",
		type     : "mean",
		where    : { gender : "female" }
	})