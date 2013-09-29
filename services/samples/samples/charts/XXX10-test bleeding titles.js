//** DATA
function data() {
	return [
		{ x : 0, y : 0.2 },
		{ x : 1, y : 0.6000000000000000000001 },
		{ x : 2, y : 0.79 },
		{ x : 3, y : 0.35 },
		{ x : 4, y : 0.5 }
	];
}

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : [ "x", "y"],
	datapoints : data(),
	options : {
		effect : "dropshadow",
		label : {
			title : "Hello World!",
			axis : function(axis) { return axis; }
		}
	}
});