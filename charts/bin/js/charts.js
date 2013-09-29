$(document).ready(function(){
	var service = API.samplesService;
	var callService = function(action, handler, data)
	{
		data = data || {};
		data.action = action;
		$.getJSON(service, data, handler);
	};

	var lastsampleclass;
	var displaySample = function(info)
	{
		var source = info['viz'] + "\n\n" + info['data'];
		source = source.replace(/\t/g, "  ");
		if(lastsampleclass)
			$("#samplevisualization").removeClass(lastsampleclass);
		if(info['class'])
		{
			$("#samplevisualization").addClass(lastsampleclass = info['class']);
		}
		var url = service + "?action=display&sample=" + encodeURI(info.sample);
		$('#samplevisualization iframe').attr('src', url);
		$('#samplecode').html(source);
		$('#samplecurrent').attr('href', url);

		var doc = info['doc'];
		if(doc)
		{
			$('#sampledoc').html(doc);
			$('#docpanel').show();
		} else {
			$('#docpanel').hide();
		}
	};

	var lastcategory;
	var changeCategory = function(el, item)
	{
		if(lastcategory)
			lastcategory.toggleClass('active');
		el.toggleClass('active');
		lastcategory = el;
		callService('options', displayOptions, { category : item.code });
	};

	var lastoption;
	var changeVisualization = function(el, sample)
	{
		if(lastoption)
			lastoption.toggleClass('active');
		el.toggleClass('active');
		lastoption = el;
		callService('info', displaySample, { sample : sample });
	};

	var displayOptions = function(values)
	{
		var ul = $('#sampleoptions').html("");
		for(var i = 0; i < values.length; i++)
		{
			var value = values[i],
				li = $('<li>'+value.title+'</li>');
			ul.append(li);
			li.click(value, function(e){
				changeVisualization($(this), e.data.sample);
			});
			if(i == 0)
				changeVisualization(li, value.sample);
		}
	};

	callService('categories', function(values){
		var ul = $('#samplecategories').html("");
		for(var i = 0; i < values.length; i++)
		{
			var value = values[i],
				li = $('<li>'+value.category+'</li>');
			ul.append(li);
			li.click(value, function(e){
				changeCategory($(this), e.data);
			});
			if(i == 0)
				changeCategory(li, value);
		}

	});
})