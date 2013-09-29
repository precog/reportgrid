define([],

function() {
	return [{
@for(i in 0...items.length)
{
	@if(i > 0) { @("}, {") }
	@{ var item = items[i]; }
		"name" : "@item.name",
		"colors" : ["@item.colors.join('", "')"]
}
	}];
});