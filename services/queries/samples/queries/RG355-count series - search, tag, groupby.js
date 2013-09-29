//** QUERY
ReportGrid.query
	.series({
		path        : pathvalue,
		event       : "impression",
		where       : { 'browser' : 'safari', 'gender' : 'male' },
		start       : "24 hours ago",
		end         : "now",
		periodicity : "minute",
		groupby     : "hour",
		tag         : "location",
		location    : "usa"
	})
