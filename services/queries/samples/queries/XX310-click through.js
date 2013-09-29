//** QUERY
ReportGrid.query
	.series({
		path : pathvalue,
		event : "click",
		start : "2 months ago",
		periodicity : "day"
	})
	.stackStore("click")
	.stackClear()
	.series({
		path : pathvalue,
		event : "impression",
		start : "2 months ago",
		periodicity : "day"
	})
	.stackRetrieve("click")
	.stackMerge()
	.split("time:day")
	.transform(function(dataset) {
		if(!dataset[0].count)
			return [];
		else
			return [{
				ctr : 100 * dataset[1].count / dataset[0].count,
				"time:day" : dataset[0]["time:day"]
			}];
	})
	.stackMerge()

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : ["time:day", "ctr"],
	load : loader
})