//** QUERY
ReportGrid.query
	.summarySeries({
		path : pathvalue,
		event : "impression",
		property : "age",
		type : "standardDeviation",
		start : "30 minutes ago",
		end : "now",
		periodicity : "minute"
	})