//** LOAD
impressions

//** QUERY
ReportGrid.query
	.data(data())
	.split("age")
	.fold(function(dps, result) {
		var o = { count : 0, age : dps[0].age };
		result.push(o);
		return o;
	}, function(cum, dp, result){
		cum.count += dp.count;
		return cum;
	})
	.stackMerge()
	.sortValue("age")