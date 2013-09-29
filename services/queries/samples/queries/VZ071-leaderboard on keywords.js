//** QUERY
ReportGrid.query
	.propertiesHistogram({
		event : "impression",
		path : pathvalue,
		property : "keywords"
	})
	.sortValue("count", false)

//** VIZ
ReportGrid.leaderBoard("#chart", {
	axes : ['keywords', 'count'],
	load : loader
})