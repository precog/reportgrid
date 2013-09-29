//** QUERY
ReportGrid.query
	.values({
		path : pathvalue,
		event : "impression",
		property : "gender"
	})
	.series({
		periodicity : "hour",
		start : "24 hours ago"
	})

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : ['time:hour', 'count'],
	load : loader,
	options : {
		segmenton : "gender"
	}
})