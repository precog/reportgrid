//** QUERY
ReportGrid.query
	.series({
		path        : pathvalue,
		event       : "impression",
		property    : "gender",
		value       : "male",
		start       : "24 hours ago",
		end         : "now",
		periodicity : "minute",
		groupby     : "hour",
		tag         : "location",
		location    : "usa"
	})
