//** QUERY
ReportGrid.query
	.values({
		path : pathvalue,
		event : "impression",
		property : "gender"
	})
	.count()

//** VIZ
ReportGrid.pieChart("#chart", {
	axes : ['gender', 'count'],
	load : loader
})