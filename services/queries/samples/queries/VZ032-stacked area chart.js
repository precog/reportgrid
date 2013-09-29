//** QUERY
ReportGrid.query
	.values({
		path : pathvalue,
		event : "impression",
		property : "gender"
	})
	.series({
		periodicity : "hour",
		start : "1 day ago"
	})
	.split("gender")
	.stackRotate('time:hour')
	.fold(0, function(acc, dp, result) {
		dp.y0 = acc;
		result.push(dp);
		return acc+dp.count;
	})

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : ['time:hour', { type : 'count' }],
	load : loader,
	options : {
		segmenton : "gender",
		displayarea : true,
		y0property : "y0",
		effect : "none",
		interpolation : "cardinal-0.8"
	}
})