//** LOAD
boulder-weather-2011

//** VIZ
function toC(v) {
	return (v - 32) / 9 * 5;
}

function transform(dp) {
	return [{
		"time:day" : dp["time:day"],
		"celsius" : toC(dp.tMin),
		type : "tMin"
	}, {
		"time:day" : dp["time:day"],
		"celsius" : toC(dp.tMax),
		type : "tMax"
	}, {
		"time:day" : dp["time:day"],
		"celsius" : toC(dp.tAverage),
		type : "tAverage"
	}, {
		"time:day" : dp["time:day"],
		snowCM : Math.round(dp.snow * 2.54 * 2) / 2,
		type : "snow"
	}, {
		"time:day" : dp["time:day"],
		precipitationCM : Math.round(dp.precipitation * 2.54 * 20) / 20,
		type : "precipitation"
	}];
}

var tmp = data(), data = [];
tmp = tmp.map(transform);
tmp.forEach(function(arr) { data = data.concat(arr); });

ReportGrid.lineChart("#chart", {
	axes : ["time:day",
			{ type : "celsius", variable : "dependent" },
			{ type : "precipitationCM", variable : "dependent" }],
	datapoints : data,
	options : {
		effect : "none",
		segmenton : "type",
		displayrules : true
	}
});

//** CLASS
wide

//** STYLE
.rg .layer.line-chart g.group path.line.noeffect
{
	stroke-width: 1px;
}