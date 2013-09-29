//** DATA
function data() { 
	return [
		{ event : 'impression', count : 125800 },
		{ event : 'click',      count :  31000 },
		{ event : 'conversion', count :   8360 }
	];
}

//** VIZ
ReportGrid.funnelChart("#chart", {
	axes : ["event", "count"],
	datapoints : data()
});

//** CLASS
square