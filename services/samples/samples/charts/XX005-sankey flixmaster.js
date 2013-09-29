//** VIZ
var start = new Date();
ReportGrid.sankey("#chart", {
	axes : ["count"],
	data : [

//	{head : "XXX", tail : "1285", count : 10},
//	{head : "XXX", tail : "XXX", count : 2},
	{head : "1296", tail : "1289", count : 1}, {head : "1295", tail : "1289", count : 1}, {head : "1294", tail : "1288", count : 2}, {head : "1292", tail : "1287", count : 1}, {head : "1291", tail : "1287", count : 1}, {head : "1289", tail : "1295", count : 1}, {head : "1289", tail : "1286", count : 3}, {head : "1288", tail : "1286", count : 2}, {head : "1287", tail : "1292", count : 1}, {head : "1287", tail : "1286", count : 3}, {head : "1286", tail : "1296", count : 1}, {head : "1286", tail : "1294", count : 1}, {head : "1286", tail : "1289", count : 1}, {head : "1286", tail : "1287", count : 2}, {head : "1286", tail : "1285", count : 4}, {head : "1285", tail : null, count : 4}, {id : "1296", count : 1}, {id : "1295", count : 1}, {id : "1294", count : 2}, {id : "1292", count : 1}, {id : "1291", count : 1}, {id : "1289", count : 4}, {id : "1288", count : 2}, {id : "1287", count : 5}, {id : "1286", count : 9}, {id : "1285", count : 4+10}],
	options : {
		layoutmap : {
			layers: [
				["1285"],
				["1286" /*, "XXX"*/],
				["1287", "1288", "1289"],
				["1290", "1291", "1292", "1293", "1294", "1295", "1296"]
			],
			dummies:[]
		},
		ready : function()
		{
			var end = new Date();
			console.log("execution time: " + (+end - (+start)) + "ms");
		}
	}
});

//** HTML
<div id="chart" class="chart"></div>

//** STYLE
#chart
{
	width:  960px;
	height: 600px;
}