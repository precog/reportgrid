//** QUERY
ReportGrid.query
	.summary({
		path     : pathvalue,
		event    : "impression",
		property : "age",
		type     : "mean",
		start    : "10 days ago",
		end      : "now"
	})