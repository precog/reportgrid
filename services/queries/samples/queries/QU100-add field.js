//** LOAD
impressions

//** QUERY
var year = (new Date()).getFullYear();
ReportGrid.query
	.data(data())
	.setValues({
		group  : "A",
		year   : function(ob) { return year - ob.age; }
	})