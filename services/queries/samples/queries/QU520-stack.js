//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.split("gender")
	.stackRotate("age")
	.renameFields({
		count : "count",
		gender : "gender",
		browser : "browser"
	})
	.fold(0, function(acc, dp, result) {
		dp.y0 = acc;
		result.push(dp);
		return dp.count;
	})

