//** LOAD
usa-debt

//** VIZ
var o = {},
	data = data();

data.forEach(function(item){
	if(!o[item.date])
		o[item.date] = 0;
	o[item.date] += item.value;
});

var max = 0;
for(k in o)
{
	if(o[k] > max)
		max = o[k];
}

data.forEach(function(item){
	item.percent = item.value / o[item.date];
});

ReportGrid.barChart("#chart", {
	axes : ["date","percent"],
	datapoints : data,
	options : {
		segmenton : "country",
		label : {
			tickmark : function(v, a) {
				return a == 'date' ? v : ReportGrid.format(v * 100, "P:0");
			}
		},
		labelorientation : "aligned"
	}
});
