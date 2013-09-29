/*
 *  ___ ___ ___  ___  ___ _____ ___ ___ ___ ___           ReportGrid (R)
 * | _ \ __| _ \/ _ \| _ \_   _/ __| _ \_ _|   \          Advanced HTML5 Charting Library
 * |   / _||  _/ (_) |   / | || (_ |   /| || |) |         Copyright (C) 2010 - 2013 SlamData, Inc.
 * |_|_\___|_|  \___/|_|_\ |_| \___|_|_\___|___/          All Rights Reserved.
 *
 *
 * This program is free software: you can redistribute it and/or modify it under the terms of the 
 * GNU Affero General Public License as published by the Free Software Foundation, either version 
 * 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See 
 * the GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with this 
 * program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
package rg.visualization;
import rg.info.InfoSankey;
import thx.graph.EdgeSplitter;
import rg.svg.layer.Title;
import rg.svg.chart.Sankey;
import thx.graph.LongestPathLayer;
import thx.graph.Graph;
import thx.graph.GraphLayout;
import thx.graph.GEdge;
import thx.graph.SugiyamaMethod;
import thx.graph.HeaviestNodeLayer;
import thx.graph.GreedySwitchDecrosser;
import rg.util.DataPoints;
using Arrays;

class VisualizationSankey extends VisualizationSvg
{
	public var info : InfoSankey;
	var title : Null<Title>;
	var chart : Sankey;

	override function _init()
	{
		// TITLE
		if (null != info.label.title)
		{
			var panelContextTitle = layout.getContext("title");
			if (null == panelContextTitle)
				return;
			title = new Title(panelContextTitle.panel, null, panelContextTitle.anchor);
		}

		// CHART
		var panelChart = layout.getPanel(layout.mainPanelName);
		chart = new Sankey(panelChart);
		baseChart = chart;
		chart.ready.add(function() ready.dispatch());
	}

	override function _feedData(data : Array<Dynamic>)
	{
//trace(data);
		chart.setVariables(independentVariables, dependentVariables, data);
		if (null != title)
		{
			if (null != info.label.title)
			{
				title.text = info.label.title(variables, data, variables.map(function(variable) return variable.type));
				layout.suggestSize("title", title.idealHeight());
			} else
				layout.suggestSize("title", 0);
		}
		var layout = (null != info.layoutmap) ? layoutDataWithMap(data, info.layoutmap) : layoutData(data, info.layoutmethod);

		if(null != info.layerWidth)
			chart.layerWidth = info.layerWidth;
		if(null != info.nodeSpacing)
			chart.nodeSpacing = info.nodeSpacing;
		if(null != info.dummySpacing)
			chart.dummySpacing = info.dummySpacing;
		if(null != info.extraWidth)
			chart.extraWidth = info.extraWidth;
		if(null != info.backEdgeSpacing)
			chart.backEdgeSpacing = info.backEdgeSpacing;
		if(null != info.extraHeight)
			chart.extraHeight = info.extraHeight;
		if(null != info.extraRadius)
			chart.extraRadius = info.extraRadius;
		if(null != info.imageWidth)
			chart.imageWidth = info.imageWidth;
		if(null != info.imageHeight)
			chart.imageHeight = info.imageHeight;
		if(null != info.imageSpacing)
			chart.imageSpacing = info.imageSpacing;
		if(null != info.labelNodeSpacing)
			chart.labelNodeSpacing = info.labelNodeSpacing;
		if(null != info.chunkWidth)
			chart.chunkWidth = info.chunkWidth;

		chart.stackbackedges = info.stackbackedges;
		chart.thinbackedges  = info.thinbackedges;

		chart.labelDataPoint = info.label.datapoint;
		chart.labelDataPointOver = info.label.datapointover;
		chart.labelNode = info.label.node;
		chart.labelEdge = info.label.edge;
		chart.labelEdgeOver = info.label.edgeover;
		chart.imagePath = info.imagePath;
		chart.click = info.click;
		chart.clickEdge = info.clickEdge;

		chart.nodeClass = info.nodeclass;
		chart.edgeClass = info.edgeclass;
		chart.displayEntry = info.displayentry;
		chart.displayExit  = info.displayexit;

		chart.init();
		chart.data(layout);
	}

	function layoutDataWithMap(data : Array<Dynamic>, map : { layers : Array<Array<String>>, dummies : Array<Array<String>> }, ?idf : NodeData -> String, ?weightf : Dynamic -> Float, ?edgesf : Dynamic -> Array<{ head : String, tail : String, weight : Float}>)
	{
		var graph = createGraph(data, idf, weightf, edgesf);
		var layers = map.layers.map(function(layer : Array<String>) return layer.map(function(id) {
			var n = graph.nodes.getById(id);
			if(null == n)
			{
				n = graph.nodes.create({
					id : id,
					weight : 0.0,
					entry : 0.0,
					exit : 0.0,
					dp : { id : id }
				});
			}
			return n.id;
		}));

		for(path in map.dummies)
		{
			var tail   = graph.nodes.getById(path.first()),
				head   = graph.nodes.getById(path.last()),
				npath  = [tail],
				edge   = tail.connectedBy(head),
				weight = null == edge ? 0.0 : edge.weight;

			// add dummy nodes
			for(i in 1...path.length-1)
			{
				var id = path[i],
					d = {
						id : id,
						weight : weight,
						entry : 0.0,
						exit : 0.0,
						dp : null
					};
				npath.push(graph.nodes.create(d));
			}
			npath.push(head);
			// add dummy edges
			for(i in 0...npath.length-1)
			{
				graph.edges.create(npath[i], npath[i+1], weight);
			}
			if(null != edge)
				edge.remove();
		}

		// convert layers
		var layers = map.layers.map(function(layer : Array<String>) return layer.map(function(id) {
			var n = graph.nodes.getById(id);
			if(null == n)
			{
				n = graph.nodes.create({
					id : id,
					weight : 0.0,
					entry : 0.0,
					exit : 0.0,
					dp : { id : id }
				});
			}
			return n.id;
		}));

		return new GraphLayout(graph, layers);
	}

	function createGraph(data : Array<Dynamic>, idf : NodeData -> String, weightf : Dynamic -> Float, edgesf : Dynamic -> Array<{ head : String, tail : String, weight : Float}>) : Graph<NodeData, Dynamic>
	{
		idf = defaultIdf(idf);
		edgesf = defaultEdgesf(idf, edgesf);
		weightf = defaultWeightf(weightf);
		var graph = new Graph(idf);

		var nodes : Array<NodeData> = cast extractNodes(data),
			edges = extractEdges(data);

		for(dp in nodes)
		{
			graph.nodes.create({
				dp     : dp,
				id     : idf(dp),
				weight : weightf(dp),
				entry  : 0.0,
				exit   : 0.0
			});
		}

		for(edge in edges)
		{
			var head = graph.nodes.getById(edge.head),
				tail = graph.nodes.getById(edge.tail);

			if(head == null)
			{
				var dp     = { id : edge.head },
					weight = weightf(edge);
				Reflect.setField(dp, dependentVariables[0].type, weight);
				head = graph.nodes.create({
					dp     : dp,
					id     : edge.head,
					weight : weight,
					entry  : 0.0,
					exit   : 0.0
				});
			}
			if(tail == null)
			{
				var dp = { id : edge.tail },
					weight = weightf(edge);
				Reflect.setField(dp, dependentVariables[0].type, weight);
				tail = graph.nodes.create({
					dp     : dp,
					id     : edge.tail,
					weight : weight,
					entry  : 0.0,
					exit   : 0.0
				});
			}

			graph.edges.create(tail, head, weightf(edge));
		}

		for(node in graph.nodes)
		{
			var win  = node.negativeWeight(),
				wout = node.positiveWeight();
			if(node.data.weight == 0)
			{
				node.data.weight = win;
			}
			node.data.entry  = Math.max(0, node.data.weight - win);
			node.data.exit = Math.max(0, node.data.weight - wout);
		}

		return graph;
	}

	function extractNodes(data : Array<Dynamic>)
	{
		var nodes = data.filter(function(dp) {
			return dp.id != null;
		});
		if(nodes.length == 0)
		{
			// try getting nodes from edges
			var type  = dependentVariables[0].type,
				map   = new Map <String, { node : { id : String }, positive : Float, negative : Float }>(),
				edges = data.filter(function(dp) return Reflect.hasField(dp, "head") || Reflect.hasField(dp, "tail"));

			function nodize(name : String, istail : Bool, weight : Float)
			{
				if(null == name)
					return;
				var n = map.get(name);
				if(null == n)
				{
					n = { node : { id : name }, positive : 0.0, negative : 0.0 };
					map.set(name, n);
				}
				if(istail)
					n.positive += weight;
				else
					n.negative += weight;
			}

			edges.each(function(dp, i) {
				var v = Reflect.field(dp, type);
				nodize(dp.tail, true, v);
				nodize(dp.head, false, v);
			});

			nodes = Iterables.array(map).map(function(n) {
				var node = n.node;
				Reflect.setField(node, type, Math.max(n.positive, n.negative));
				return node;
			});
		}
		return nodes;
	}

	function extractEdges(data : Array<Dynamic>)
	{
		return data.filter(function(dp) {
			return dp.head != null && dp.tail != null;
		});
	}

	function layoutData(data : Array<Dynamic>, method : String, ?idf : NodeData -> String, ?nodef : GEdge<NodeData, Dynamic> -> Dynamic, ?weightf : Dynamic -> Float, ?edgesf : Dynamic -> Array<{ head : String, tail : String, weight : Float}>) : GraphLayout<NodeData, Dynamic>
	{
		var graph = createGraph(data, idf, weightf, edgesf);

		nodef = defaultNodef(nodef);
		switch(method)
		{
			case "weightbalance":
				return weightBalance(graph, nodef);
			default:
				return sugiyama(graph, nodef);
		}
	}

	function weightBalance(graph : Graph<NodeData, Dynamic>, nodef : GEdge<NodeData, Dynamic> -> Dynamic)
	{
		var layout : GraphLayout<NodeData, Dynamic> = new GraphLayout(graph, new HeaviestNodeLayer().lay(graph));
		layout = new EdgeSplitter().split(layout, [], nodef);
		layout = cast GreedySwitchDecrosser
			.best()
			.decross(cast layout);
		return layout;
	}

	function sugiyama(graph : Graph<NodeData, Dynamic>, nodef : GEdge<NodeData, Dynamic> -> Dynamic)
	{
		return new SugiyamaMethod().resolve(graph, nodef);
	}

	static function defaultIdf(?idf : NodeData -> String)
	{
		if(idf == null)
			return function(data : NodeData) return data.id;
		else
			return idf;
	}

	static function defaultNodef(?nodef : GEdge<NodeData, Dynamic> -> Dynamic)
	{
		if(nodef == null)
		{
			var dummynodeid = 0;
			return function(edge : GEdge<NodeData, Dynamic>) {
				return {
					id : "#" + (++dummynodeid),
					weight : edge.weight,
					entry : 0.0,
					exit : 0.0
				};
			};
		} else
			return nodef;
	}

	static function defaultEdgesf(idf : NodeData -> String, ?edgesf : Dynamic -> Array<{ head : String, tail : String, weight : Float}>)
	{
		if(edgesf == null)
		{
			return function(dp : Dynamic) {
				var r = [],
					id = idf(dp);
				for(parent in Reflect.fields(dp.parents))
				{
					r.push(cast {
						head : id,
						tail : parent,
						weight : Reflect.field(dp.parents, parent)
					});
				}
				return r;
			};
		} else
			return edgesf;
	}

	function defaultWeightf(?weightf : Dynamic -> Float)
	{
		if(null == weightf)
		{
			var type = this.dependentVariables[0].type;
			return function(dp) {
				var v = DataPoints.value(dp, type);
				return null != v  ? v : 0.0;
			};
		} else
			return weightf;
	}

	override public function _destroy()
	{
		chart.destroy();
		if (null != title)
			title.destroy();
		super._destroy();
	}
}