//** TOKEN
CC400D31-E7D0-4E0A-A364-3FB5AA2FD02E

//** VIZ
var path = "/jtt/test9/1/194/195";
ReportGrid.sankey("#chart", {
	axes	: ["count"],
	data : [
		{head : "4301", tail : "4298", count : 13},
		{head : "4300", tail : "4299", count : 36},
		{head : "4299", tail : "4300", count : 25},
		{head : "4299", tail : "4299", count : 84},
		{head : "4299", tail : "4293", count : 28},
		{head : "4299", tail : "4291", count : 58},
		{head : "4298", tail : "4301", count : 9},
		{head : "4298", tail : "4298", count : 5},
		{head : "4298", tail : "4291", count : 35},
		{head : "4298", tail : "4290", count : 17},
		{head : "4297", tail : "4297", count : 15},
		{head : "4297", tail : "4291", count : 32},
		{head : "4295", tail : null, count : 134},
		{head : "4294", tail : "4297", count : 19},
		{head : "4293", tail : "4299", count : 43},
		{head : "4291", tail : "4301", count : 4},
		{head : "4291", tail : "4300", count : 7},
		{head : "4291", tail : "4299", count : 27},
		{head : "4291", tail : "4298", count : 16},
		{head : "4291", tail : "4297", count : 13},
		{head : "4291", tail : "4295", count : 82},
		{head : "4291", tail : "4293", count : 5},
		{head : "4291", tail : "4290", count : 2},
		{head : "4290", tail : "4298", count : 23},
		{id : "4301", count : 13},
		{id : "4300", count : 36},
		{id : "4299", count : 195},
		{id : "4298", count : 71},
		{id : "4297", count : 61},
		{id : "4295", count : 134},
		{id : "4294", count : 19},
		{id : "4293", count : 43},
		{id : "4291", count : 164},
		{id : "4290", count : 23}
	],
	options : {
		layoutmap : {
			dummies:
				[
					["4295", "#4295.1", "4291"],
					["4290", "#4290.2", "4298"]
				],
			layers:
				[
					["4295"],
					["4290", "#4295.1"],
					["#4290.2", "4291"],
					["4298", "4297", "4299"],
					["4301", "4296", "4294", "4292", "4293", "4300"]
				]
			}
		}

/*
		load	: ReportGrid.query
					.intersect({
						path	: path,
						event	: "progression",
						properties	: [
							{ property	: "node_id", top : 100 }
						]
					})
					.renameFields({
						node_id		: "id",
						count		: "count"
					})
					.stackStore().stackClear()
					.intersect({
						path	: path,
						event	: "progression",
						properties	: [
							{ property	: "node_id", top : 100 },
							{ property	: "parent_id", top : 100 }
						]
					})
					.console()
					.renameFields({
						node_id		: "head",
						parent_id	: "tail",
						count		: "count"
					})
					.stackRetrieve()
					.console()//,
*/
//		options	: options
	}
);

//** HTML
<div id="chart" class="chart"></div>

//** STYLE
#chart
{
	width:  960px;
	height: 800px;
}