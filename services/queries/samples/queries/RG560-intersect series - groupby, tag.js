//** QUERY
ReportGrid.query
	.intersectSeries({
		path        : pathvalue,
		event       : "impression",
		properties  : [{ property : "browser" }],
		start       : "10 days ago",
		end         : "now",
		periodicity : "hour",
		groupby     : "day",
		tag         : "location",
		location    : "/"
	})