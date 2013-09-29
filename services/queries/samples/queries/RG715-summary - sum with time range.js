//** QUERY
ReportGrid.query
	.summary({
		path     : pathvalue,
		event    : "impression",
		property : "age",
		type     : "sum",
		start    : "2 days ago",
		end      : "now"
	})