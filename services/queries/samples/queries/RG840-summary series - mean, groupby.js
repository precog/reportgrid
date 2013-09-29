//** QUERY
ReportGrid.query
	.summarySeries({
		path : pathvalue,
		event : "impression",
		property : "age",
		start       : "24 hours ago",
		end         : "now",
		periodicity : "minute",
		groupby     : "hour"
	})