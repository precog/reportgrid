//** QUERY
ReportGrid.query
	.histogram({
		event : "impression",
		path : pathvalue,
		property : "keywords",
		start : "yesterday"
	})
	.map(function(dp) {
		var keywords = [];
		for(keyword in dp.keywords)
			keywords.push(keyword);
		dp.keywords = keywords.join(", ");
		return dp;
	})
	.sortValue("count")
	.reverse()

//** VIZ
ReportGrid.leaderBoard("#chart", {
	axes : ['keywords', 'count'],
	load : loader
})