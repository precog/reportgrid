//** QUERY
ReportGrid.query
	.values({
		path : pathvalue,
		event : "impression",
		property : "gender"
	})
	.count()

//** VIZ
ReportGrid.pieChart("#chart", {
	axes : ['gender', 'count'],
	load : loader,
	options : {
		label : {
			datapoint : function(dp) {
				return dp.gender;
			},
			datapointover : function(dp, stats) {
				var id = "tooltipid";
				haxe.Timer.delay(function() {
					var el = document.getElementById(id);
					var c = document.createElement("div");
					ReportGrid.lineChart(c, {
						axes : ['time:hour', 'count'],
						load : ReportGrid.query
							.series({
								path : '/query/test2',
								event : "impression",
								start : "24 hours ago",
								end : "now",
								periodicity : "hour",
								where : {
									gender : dp.gender
								}
							}),
						options : {
							width  : 180,
							height : 120,
							label  : {
								title : 'last 24 hours'
							},
							displayticklabel : false,
							effect : "none",
							displayarea : true,
							ready : function() {
								while(el.childNodes.length) el.removeChild(el.childNodes[0]);
								el.appendChild(c);
							}
						}
					})
				}, 0)
				return '<div id="'+id+'"><img src="http://api.reportgrid.com/css/images/spinner.gif"/></div>';
			}
		}
	}
})

//** STYLE
.rg.tooltip .layer.title text
{
	font-size: 10px;
	font-weight : bold;
}
.rg.tooltip .container
{
	max-width: 180px;
}