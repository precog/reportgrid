//** TOKEN
CC400D31-E7D0-4E0A-A364-3FB5AA2FD02E

//** VIZ
var analytics = {
		path : '/jtt/test9/1/151/152/',
		percent_bin_map : {
			"1101" : 20
		}
	},
	dp = {
		id : "1097"
	};
ReportGrid.cache.disable();
ReportGrid.barChart(
	"#chart",
	{
		axes :
		[
			{
				type : "progress_percentage_bin",
				values : attentionValues(analytics.percent_bin_map[dp.id])
			},
			{
				type : "count"
			}
		],
		load : ReportGrid.query
//			.data(attentionValues(analytics.percent_bin_map[dp.id]))
//			.map(function(v) {
//				return { value : v };
//			})
			.histogram({
				path : analytics.path,
				event : "attention",
				property : "progress_percentage_bin",
				where : { node_id : dp.id }
			})
/*
			.intersect({
				path : analytics.path,
				event : "attention",
				properties : [{ property : "progress_percentage_bin" },{ property : "node_id" }]
			})
			.filterValue("node_id", dp.id)
*/
	}
);

function attentionValues(step)
{
	var result = [];
	for(var i = 0; i <= 100; i += step)
	{
		result.push(''+i);
	}
	return result;
}