//** QUERY
ReportGrid.query
	.summarySeries({
		path : pathvalue,
		event : "impression",
		property : "age",
		type : "mean",
		start : "10 hours ago",
		end : "now",
		periodicity : "hour",
		timezone : 2
	})