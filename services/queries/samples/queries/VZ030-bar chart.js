//** QUERY
ReportGrid.query
	.series({
		path : pathvalue,
		event : "impression",
		periodicity : "hour",
		start : "24 hours ago"
	})

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ['time:hour', 'count'],
	load : loader
})