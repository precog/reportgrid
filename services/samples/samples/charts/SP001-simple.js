//** LOAD
usa-deathrate-by-gender-and-race

//** VIZ
var symbolmap = {
	"White" : "circle",
	"Black" : "star",
	"Asian or Pacific Islander" : "square",
	"American Indian, Eskimo, Aleut" : "diamond"
};
var colormap = {
	male : "blue",
	female : "pink"
}

ReportGrid.scatterGraph("#chart", {
	axes : ["year", "deathRate"],
	datapoints : data(),
	options : {
//		labelorientation : "ortho"
		label : {
			tickmark : function(v, t) { return t == "year" ? v : ReportGrid.format(v); },
			axis : function(t) { return ReportGrid.humanize(t); },
			datapointover : function(dp, stats) {
				return "gender: " + dp.gender +
					", race: " + dp.race +
					", death rate: " + ReportGrid.format(dp.deathRate);
			}
		},
		displayrules : true,
		symbol : function(dp) {
			return ReportGrid.symbol(symbolmap[dp.race], 40);
		},
		symbolstyle : function(dp) {
			return "stroke:#666;fill:" + colormap[dp.gender];
		}
	}
})