//** QUERY
ReportGrid.query
	.values({
		path : pathvalue,
		event : "impression",
		property : "gender"
	})
	.series({
		periodicity : "hour",
		start : "10 hours ago"
	})

//** VIZ
ReportGrid.streamGraph("#chart", {
	axes : ['time:hour', 'count'],
	load : loader,
	options : {
		segmenton : "gender",
		interpolation : "monotone"
	}
})