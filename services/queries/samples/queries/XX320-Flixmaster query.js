//** TOKEN
BC0777CC-A964-4851-99B4-6F882A185520

//** QUERY
var path   = '/jtt/test10/1/46/164',
	params = {
		path	: path,
		event	: "progression",
		property : "node_id"
	};
ReportGrid.cache.disable();
ReportGrid.query
	.data(params).histogram({
		where : { inbound_tracker : null }
	})
/*
	.intersect({
		path	: path,
		event	: "progression",
		properties	: [
			{ property	: "node_id" },
			{ property	: "inbound_tracker" }
		]
	})
	.filterValue("inbound_tracker", null)
*/
	.renameFields({
		node_id		: "id",
		count		: "count"
	})
	.stackStore().stackClear()
	.intersect({
		path	: path,
		event	: "progression",
		properties	: [
			{ property	: "node_id" },
			{ property	: "parent_id" },
			{ property	: "inbound_tracker" }
		]
	})
	.filterValue("inbound_tracker", null)
	.renameFields({
		node_id		: "head",
		parent_id	: "tail",
		count		: "count"
	})
	.stackRetrieve()

/*
ReportGrid.query
	.intersect({
		path	: path,
		event	: "progression",
		properties	: [
			{ property	: "node_id" },
			{ property	: "inbound_tracker" }
		]
	})
	.filterValue("inbound_tracker", null)
	.renameFields({
		node_id		: "id",
		count		: "count"
	})
	.stackStore().stackClear()
	.intersect({
		path	: path,
		event	: "progression",
		properties	: [
			{ property	: "node_id" },
			{ property	: "parent_id" },
			{ property	: "inbound_tracker" }
		]
	})
	.filterValue("inbound_tracker", null)
	.renameFields({
		node_id		: "head",
		parent_id	: "tail",
		count		: "count"
	})
	.stackRetrieve()
*/