//** VIZ
function data()
{
	var r = [],
		v = 1;
	for(var i = 1; i < 20; i++)
	{
		r.push({
			"time:day" : new Date(2012, 2, i, 0, 0, 0).getTime(),
			count : v *= 1.1
		});
	}
	return r;
}

ReportGrid.lineChart("#chart", {
	axes : ["time:day", "count"],
	data : data()
});
