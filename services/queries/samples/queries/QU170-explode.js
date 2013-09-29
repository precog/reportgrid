//** DATA
[{ "max" : 10, "min" : 2, "mean" : 5}]

//** QUERY
ReportGrid.query
	.data(data())
	.explode(function(dp) {
		return [{type:"max", value:dp.max},{type:"min", value:dp.min},{type:"mean", value:dp.mean}];
	})