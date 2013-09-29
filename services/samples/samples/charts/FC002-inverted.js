//** DATA
function data() {
	return [
		{ type : 'over 3,047 m runaway',  count :  189 }, // 189
		{ type : 'up to 3,047 m', count :  424 }, // 235
		{ type : 'up to 2,437 m runaway', count : 1903 }, // 1479
		{ type : 'up to 1,523 m runaway', count : 4219 }, // 2316
		{ type : 'under 914 m runaway',   count : 5194 }  // 975
	];
}

//** VIZ
ReportGrid.funnelChart("#chart", {
	axes : ["type", "count"],
	datapoints : data(),
	options : {
		label : {
			datapoint : function(dp) { return dp.type; }
		}
	}
});

//** CLASS
square