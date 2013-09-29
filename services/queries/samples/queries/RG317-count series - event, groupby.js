//** QUERY
ReportGrid.query
	.series({
		path        : pathvalue,
		event       : "impression",
		start       : "24 hours ago",
		end         : "now",
		periodicity : "minute",
		groupby     : "hour"
	})
