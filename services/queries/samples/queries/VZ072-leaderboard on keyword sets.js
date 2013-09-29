//** QUERY
ReportGrid.query
	.histogram({
		path : pathvalue,
		event : "impression",
		property : "keywords"
	})
	.map(function(dp) {
		var keywords = [];
		for(keyword in dp.keywords)
			keywords.push(keyword);
		dp.keywords = keywords.join(", ");
		return dp;
	})
	.sortValue("count", false)

//** VIZ
ReportGrid.leaderBoard("#chart", {
	axes : ['keywords', 'count'],
	load : loader
})