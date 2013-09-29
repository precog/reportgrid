//** LOAD
usa-debt

//** VIZ
var o = {},
	data = data();

data.forEach(function(item){
	if(!o[item.date])
		o[item.date] = { value : 0, percent : 0 };
	o[item.date].value += item.value;
});

data.forEach(function(item){
	item.percent = 100 * item.value / o[item.date].value;
	item.y0 = o[item.date].percent;
	o[item.date].percent += item.percent;
});

ReportGrid.lineChart("#chart", {
	axes : ["date", { type : "percent", view : [0, 100] }],
	datapoints : data,
	options : {
		segmenton : "country",
		label : {
			tickmark : function(v, a) {
				return a == 'date' ? v : ReportGrid.format(v, "P:0");
			},
			datapointover : function(dp) {
				return dp.country + " on " + dp.date + ": " + dp.value;
			}
		},
		labelorientation : "aligned",
		labelanchor : function(a) { return a == 'date' ? 'left' : 'right'; },
		displayarea : true,
		effect : "none",
		y0property : "y0"
	}
});
