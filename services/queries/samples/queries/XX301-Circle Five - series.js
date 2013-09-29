//** TOKEN
9F7B43FE-FCA6-4CB0-9D3B-2C93DF56F28B

//** VIZ
var path = '/';
ReportGrid.lineChart("#chart", {
	axes : ["time:week", "count"],
	load : ReportGrid.query
		.data([{
			event : "survey_initiated"
		}, {
			event : "survey_submitted"
		}, {
			event : "survey_viewed"
		}])
		.series({
			path : path,
			start : "12 weeks ago",
			end : "2012-03-20",
			periodicity : "week"
		}),
	options : {
		segmenton : "event"
	}
})