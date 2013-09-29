//** QUERY
ReportGrid.query
	.intersectSeries({
		path        : pathvalue,
		event       : "impression",
		properties  : [{ property : "browser" }],
		start       : "24 hours ago",
		end         : "now",
		periodicity : "minute",
		groupby     : "hour"
	})