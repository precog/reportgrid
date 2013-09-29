//** LOAD
english-speakers

//** VIZ
ReportGrid.barChart("#chart", {
	axes : ["country","count"],
	datapoints : data(),
	options : {
		displayrules : true,
		barclass : function(dp) { return dp.country.toLowerCase(); }
	}
});

//** STYLE
rect.usa
{
	fill : #000000;
}

rect.uk
{
	fill : #ff0000;
}