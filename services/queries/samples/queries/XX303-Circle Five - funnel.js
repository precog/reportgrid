//** TOKEN
9F7B43FE-FCA6-4CB0-9D3B-2C93DF56F28B

//** VIZ
var path = '/40/591';
ReportGrid.funnelChart("#chart", {
	axes : ["event", "count"],
	load : ReportGrid.query
		.data([{
			event : "survey_initiated"
		}, {
			event : "survey_submitted"
		}])
		.count({
			path : path
		})
})