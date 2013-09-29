//** QUERY
ReportGrid.query
	.data([{ event : "impression" }, { event : "click" }, { event : "conversion" }])
	.count({ path : pathvalue })

//** VIZ
ReportGrid.leaderBoard("#chart", {
	axes : ['event', 'count'],
	load : loader
})