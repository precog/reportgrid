//** QUERY
ReportGrid.query
	.intersect({
		event : "impression",
		path : pathvalue,
		properties : ['age', 'browser']
	})
	.sortValues({
		age : true,
		browser : true
	})

//** VIZ
ReportGrid.heatGrid("#chart", {
	axes : ['age', 'browser', 'count'],
	load : loader
})