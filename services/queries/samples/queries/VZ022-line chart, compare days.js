//** QUERY
ReportGrid.query
	.data({
		path : pathvalue,
		event : "impression",
		periodicity : "hour"
	})
	.stackStore("params")
	.series({
		start : "2 days ago midnight",
		end : "yesterday midnight"
	})
	.mapValues({
		'time:hour' : function(v) { return v + 24 * 60 * 60000; },
		"group" : "yesterday"
	})
	.stackStore("yesterday")
	.stackClear()
	.stackRetrieve("params")
	.series({
		start : "yesterday midnight",
		end : "midnight"
	})
	.setValue("group", "today")
	.stackRetrieve("yesterday")

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : ['time:hour', 'count'],
	load : loader,
	options : {
		segmenton : "group"
	}
})