//** TOKEN
CC400D31-E7D0-4E0A-A364-3FB5AA2FD02E

//** VIZ
var path  = '/jtt/test9/1/124/150/';
ReportGrid.cache.disable();
ReportGrid.sankey("#chart", {
	axes : ["count"],
	load : ReportGrid.query.intersect({
			path : path,
			event : "progression",
			properties : [{
				property : 'node_id'
			}]
		})
		.renameFields({
			node_id : 'id',
			count : 'count'
		})
		.store().clear()
		.intersect({
			path : path,
			event : "progression",
			properties : [{
				property : 'node_id'
			},
			{
				property : 'parent_id'
			}]
		})
		.renameFields({
			node_id : 'head',
			parent_id : 'tail',
			count : 'count'
		})
		.retrieve(),
	options : 
	{
//		label : 
//		{
//			datapoint : dataPointLabel,
//			datapointover : dataPointOverLabel,
//			node : nodeLabel,
//			edge : edgeLabel,
//			edgeover : edgeOverLabel
//		},
		imagewidth : 60,
		imageheight : 40,
		imagespacing : 1,
//		imagepath : imagePath,
//		click : nodeClick,
		layoutmap : {
			layers : [["967"], ["666", "#1", "968", "970", "#2"], ["971", "969", "966"]],
			dummies : [["967", "#1", "971"], ["967", "#2", "966"]]
		}
	}
});

//** STYLE
#chart {
    width: 960px;
    height: 640px;
    float: left;
}