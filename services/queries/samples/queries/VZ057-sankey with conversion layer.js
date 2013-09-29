//** QUERY
ReportGrid.query
	.intersect({
		path : "/test/clipmaster/t4/",
		event : "impression",
		properties : ['clip']
	})
	.renameFields({
		clip : "id",
		count : "impressions"
	})
	.stackStore()
	.stackClear()
		.intersect({
			path : "/test/clipmaster/t4/",
			event : "impression",
			properties : ['clip', 'parent']
		})
		.renameFields({
			clip   : "head",
			parent : "tail",
			count  : "impressions"
		})
	.stackRetrieve()

//** VIZ
// clip_07 is a conversion node
var convmap = {
	"clip_07" : true,
	"#3" : true,
	"#4" : true,
	"#5" : true,
};

function isConversion(id)
{
	return convmap[id];
}

function dataPointOver(dp, stats)
{
	if(isConversion(dp.id))
		return;
	var el = document.getElementById('nodechart');
	if(el) el.parentNode.removeChild(el);
	setTimeout(function(){
		renderNodeChart(dp);
	}, 10);
	return '<span>Viewer Drop-off</span><div id="nodechart"></div>';
}

function renderNodeChart(dp) {
	var el = document.getElementById('nodechart');
	if(!el) return;
	ReportGrid.barChart(el, {
		axes : ["attention_bin", "count"],
		load : ReportGrid.query
			.data(Ints.range(0, 110, 10).map(function(v) {
				return {
					attention_bin : v,
					count : Math.round(Math.random() * 100)
				}
			})),
		options	:
		{
			label : {
				datapointover : function(dp, stats) {
					return false;
				},
			},
			barpadding : 2,
			height: 120,
			width : 200
		}
	});
}

ReportGrid.sankey("#chart", {
	axes : ["impressions"],
	load : loader,
	options : {
		layoutmap : layoutmap(),
		nodeclass : function(dp) {
			return isConversion(dp.id) ? "conversion" : null;
		},
		edgeclass : function(dp) {
			return dp.head && isConversion(dp.head.id) ? "conversion" : null;
		},
		displayentry : function(dp) {
			return true;
		},
		displayexit : function(dp) {
			return !isConversion(dp.id);
		},
		nodespacing : 63,
		imagewidth : 60,
		imageheight : 40,
		imagespacing : 1,
		imagepath : function(dp)
		{
			if(dp.id == "clip_07")
				return null;
			var id = dp.id.split("_").pop().substr(1);
			return "http://www.reportgrid.com/charts/samples/images/clip_"
				+ id
				+ ".png";
		},
		label : {
			datapointover : dataPointOver,
			datapoint : function(dp, stats) {
				return dp.impressions + "\n" + (isConversion(dp.id) ? "conversions" : "impressions");
			},
			node : function(dp, stats) {
				return dp.id;
			},
			edge : function(dp, stats) {
				return ReportGrid.format(dp.edgeweight / dp.nodeweight * 100, "P:0");
			}
		}
	}
});


function layoutmap() {
 	return {
		layers : [["clip_01"], ["clip_03", "clip_02", "clip_04"], ["#1", "#2", "clip_05", "#3"], ["clip_06", "#4", "#5"], ["clip_07"]],
		dummies : [
			["clip_03", "#1", "clip_06"],
			["clip_02", "#2", "clip_06"],
			["clip_05", "#4", "clip_07"],
			["clip_04", "#3", "#5", "clip_07"]
		]
	};
}

//** STYLE
#chart
{
	width: 800px;
	height : 500px;
}

.rg .conversion rect, .rg .conversion path.fill
{
	fill: #060;
}

.rg .sankey .elbow .fill-4
{
	fill: #444;
}

.rg .sankey line.rule-4
{
	stroke-width: 120;
	stroke: rgba(150,255,150,0.125);
	stroke-dasharray: 0;
}

.rg.tooltip .rg_container
{
	max-width: 200px;
	width: 200px;
}

.rg.tooltip
{
	transition: all 0;
	-webkit-transition: all 0;
	-moz-transition: all 0;
	-ms-transition: all 0;
	-o-transition: all 0;
	pointer-events:none;
}