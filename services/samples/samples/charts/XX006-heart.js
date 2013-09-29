//** DATA
function data() {
	return [
		{ x : 0,	y : 0 },
		{ x : 0.5,	y : 0.7 },
		{ x : 1,	y : 1 },
		{ x : 1.5,	y : 0.7 },
		{ x : 1.7,	y : 0 },
		{ x : 1.5,	y : -1 },
		{ x : 0,	y : -3 },
		{ x : -1.5,	y : -1 },
		{ x : -1.7,	y : 0 },
		{ x : -1.5,	y : 0.7 },
		{ x : -1,	y : 1 },
		{ x : -0.5,	y : 0.7 },
		{ x : 0,	y : 0 }
	];
}

//** VIZ
ReportGrid.lineChart("#chart", {
	axes : [
		{ type : "x", values : [-1.7,-1.5,-1,-0.5,0,0.5,1,1.5,1.7] },
		"y"],
	datapoints : data(),
	options : {
		effect : "dropshadow",
		interpolation : "basis",
		displayarea : true
	}
});

//** STYLE
.rg path.fill-0
{
	fill: #f00;
}

.rg path.stroke-0
{
	stroke: #f00;
}