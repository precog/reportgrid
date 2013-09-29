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
package rg.svg.chart;
import rg.svg.panel.Panel;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import thx.color.NamedColors;
import dhx.Selection;
import rg.svg.widget.Label;
import rg.svg.widget.GridAnchor;
import rg.svg.widget.DiagonalArea;
import rg.svg.widget.ElbowArea;
import rg.svg.widget.HookConnectorArea;
import rg.svg.widget.HookConnector;
import thx.graph.GraphLayout;
import thx.graph.GEdge;
import thx.graph.GNode;
import rg.axis.Stats;
import rg.util.RGColors;
using Arrays;
using Iterables;

// TODO wire labels

class Sankey extends Chart
{
	public var layerWidth : Float;
	public var nodeSpacing : Float;
	public var dummySpacing : Float;
	public var extraWidth : Float;
	public var backEdgeSpacing : Float;
	public var extraHeight : Float;
	public var extraRadius : Float;
	public var imageWidth : Float;
	public var imageHeight : Float;
	public var imageSpacing : Float;
	public var labelNodeSpacing : Float;

	public var stackbackedges : Bool;
	public var thinbackedges : Bool;

	public var labelEdge : { head : Dynamic, tail : Dynamic, edgeweight : Float, nodeweight : Float } -> Stats<Dynamic> -> String;
	public var labelEdgeOver : { head : Dynamic, tail : Dynamic, edgeweight : Float, nodeweight : Float } -> Stats<Dynamic> -> String;
	public var labelNode : Dynamic -> Stats<Dynamic> -> String;

	public var imagePath : Dynamic -> String;
	public var clickEdge : { head : Dynamic, tail : Dynamic, edgeweight : Float, nodeweight : Float } -> Stats<Dynamic> -> Void;

	public var nodeClass : Dynamic -> Stats<Dynamic> -> String;
	public var edgeClass : Dynamic -> Stats<Dynamic> -> String;
	public var displayEntry : Dynamic -> Stats<Dynamic> -> Bool;
	public var displayExit : Dynamic -> Stats<Dynamic> -> Bool;
	public var chunkWidth : Float;

	var layout : GraphLayout<NodeData, Dynamic>;
	var maxweight : Float;
	var availableheight : Float;
	var padBefore : Float;
	var padAfter : Float;
	var layerstarty : Array<Float>;

	var styleNode : String;
	var styleentry : String;
	var styleexit : String;
	var styleEdgeBackward : String;
	var styleEdgeForward : String;
	var dependentVariable : VariableDependent<Dynamic>;
	var mapelements : Map<String, Selection>;
	var maphi : Map<String, Selection>;

	public function new(panel : Panel)
	{
		super(panel);
		addClass("sankey");
		layerWidth = 61;
		nodeSpacing = 28;
		dummySpacing = 18;
		extraWidth = 28;
		backEdgeSpacing = 4.0;
		extraHeight = 5;
		extraRadius = 5;
		chunkWidth = 10;

		imageWidth = 60;
		imageHeight = 48;
		imageSpacing = 0;

		labelNodeSpacing = 4;

		styleNode = "0"; // 4
		styleentry = "4";
		styleexit = "6";
		styleEdgeBackward = "3";
		styleEdgeForward = "0";

		stackbackedges = true;
		thinbackedges = true;
	}

	public function setVariables(variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, data : Array<Dynamic>)
	{
		dependentVariable = variableDependents[0];
	}

	public function data(graphlayout : GraphLayout<NodeData, Dynamic>)
	{
		layout = graphlayout.clone();
		// remove nodes between back edges
		// - must be dummy
		// - must be directed right to left
		var nodes = Iterables.filter(layout.graph.nodes, function(node) return isdummy(node)).filter(function(node) {
			var edge = node.positives().next();
			if(null == edge)
				return false;
			var cellhead = layout.cell(edge.head),
				celltail = layout.cell(edge.tail);
			return celltail.layer > cellhead.layer;
		});
		var layers = layout.layers();

		for(node in nodes)
		{
			var cell  = layout.cell(node),
				ehead = node.positives().next(),
				etail = node.negatives().next();
			// remove from layout
			layers[cell.layer].splice(cell.position, 1);
			// create new replacement edge
			layout.graph.edges.create(etail.tail, ehead.head, ehead.weight, ehead.data);
			// remove the node (and the edges)
			node.remove();
		}

//		this.layout = graphlayout;

		redraw();
	}

	function redraw()
	{
		mapelements = new Map ();
		maphi = new Map ();
		// space occupied by the node paddings
		maxweight = 0;
		layerstarty = [];
		for(i in 0...layout.length)
		{
			var v = layout.layer(i).reduce(function(cum, cur, _) return cum + cur.data.weight, 0);
			if(v > maxweight)
				maxweight = v;
		}

		var occupiedspace = 0.0;
		for(i in 0...layout.length)
		{
			var v = layout.layer(i).reduce(function(cum, cur, _){
				return cum + nodepadding(cur);
			}, 0.0);
			if(v > occupiedspace)
				occupiedspace = v;
		}
		availableheight = height - occupiedspace;

		// correct max available height and maxweight
		// remove space for back connections
		if(thinbackedges)
		{
			var count = stackbackedges
					? Iterators.filter(layout.graph.edges.iterator(), function(edge) { return layout.cell(edge.tail).layer >= layout.cell(edge.head).layer; }).length
					: 1;
			availableheight -= (1 + backEdgeSpacing) * count;
		} else {
			if(stackbackedges)
			{
				for(edge in layout.graph.edges)
				{
					if(layout.cell(edge.tail).layer < layout.cell(edge.head).layer)
						continue;
					availableheight -= backEdgeSpacing;
					maxweight += edge.weight;
				}
			} else {
				availableheight -= backEdgeSpacing;
				var v = 0.0;
				for(edge in layout.graph.edges)
				{
					if(layout.cell(edge.tail).layer < layout.cell(edge.head).layer)
						continue;
					if(edge.weight > v)
						v = edge.weight;
				}
				maxweight += v;
			}
		}
		availableheight -= extraRadius + extraHeight;


		var backedgesy  = 0.0;
		for(i in 0...layout.length)
		{
			var layer = layout.layer(i),
				t = 0.0;
			for(node in layer)
				t += nodepadding(node) + nheight(node.data.weight);
			layerstarty[i] = t;
			if(t > backedgesy)
				backedgesy = t;
		}

		for(i in 0...layerstarty.length)
		{
			layerstarty[i] = (backedgesy - layerstarty[i]) / 2; // STACK BOTTOM: backedgesy - layerstarty[i]
		}
		backedgesy += extraRadius + extraHeight;

		// nodeSpacing before
		padBefore = 0.0;
		if(thinbackedges) {
			for(node in layout.layer(0)) {
				var hasEntry = (null != displayEntry && displayEntry(node.data, dependentVariable.stats)),
					first = true,
					sum = 0.0;
				for(edge in node.negatives())
				{
					if(first) {
						first = false;
						sum += extraRadius + chunkWidth;
					} else
						sum += backEdgeSpacing + 2;
				}
				if(sum > padBefore)
					padBefore = sum;
				if(hasEntry && extraWidth > padBefore)
					padBefore = extraWidth;
			}
		} else {
			for(node in layout.layer(0))
			{
				var extra = Math.min(nheight(node.data.entry), extraWidth);
				for(edge in node.negatives())
				{
					var tail = edge.tail,
						parentweight = hafter(edge.id, node.negatives()) + nheight(edge.weight);
					if(parentweight > extra)
						extra = parentweight;
				}
				if(extra > padBefore)
					padBefore = extra;
			}

		}
		padBefore += 2; // TODO border border width

		// nodeSpacing after
		padAfter = 0.0;
		if(thinbackedges) {
			for(node in layout.layer(layout.length-1)) {
				var hasExit = (null != displayExit && displayExit(node.data, dependentVariable.stats)),
					first = true,
					sum = 0.0;
				for(edge in node.positives())
				{
					if(first) {
						first = false;
						sum += extraRadius + chunkWidth;
					} else
						sum += backEdgeSpacing + 2;
				}
				if(sum > padAfter)
					padAfter = sum;
				if(hasExit && extraWidth > padAfter)
					padAfter = extraWidth;
			}
		} else {
			for(node in layout.layer(layout.length-1))
			{
				var extra = Math.min(nheight(node.data.exit), extraWidth);
				for(edge in node.positives())
				{
					var head = edge.head,
						childweight = hafter(edge.id, node.positives()) + nheight(edge.weight) + Math.min(nheight(node.data.exit), extraWidth);
					if(childweight > extra)
						extra = childweight;
				}
				if(extra > padAfter)
					padAfter = extra;
			}
		}
		padAfter += 2; // TODO better border width

		// DRAW
		var edgescontainer = g.select("g.edges");
		if(edgescontainer.empty())
			edgescontainer = g.append("svg:g").attr("class").string("edges");
		else
			edgescontainer.selectAll("*").remove();

		var edges = Iterables.array(layout.graph.edges).order(function(ea, eb) {
			var lena = layout.cell(ea.tail).layer - layout.cell(ea.head).layer,
				lenb = layout.cell(eb.tail).layer - layout.cell(eb.head).layer,
				comp = Ints.compare(lenb, lena);
			if(comp != 0)
				return comp;
			else
				return Floats.compare(eb.weight, ea.weight);
		});

		layout.graph.nodes.each(function(node, _) {
			node.sortPositives(function(a, b) {
				var ca = layout.cell(a.head),
					cb = layout.cell(b.head);
				var t = cb.layer - ca.layer;
				if(t != 0)
					return t;
				return ca.position - cb.position;
			});
			node.sortNegatives(function(a, b) {
				var ca = layout.cell(a.tail),
					cb = layout.cell(b.tail);
				if(ca.layer > cb.layer)
					return 1;
				return ca.position - cb.position;
			});
		});

		var cedges = edges.copy();
		cedges.sort(function(a, b) {
			var ca = layout.cell(a.tail),
				cb = layout.cell(b.tail);
			return cb.position - ca.position;
		});

		// back edges
		if(thinbackedges)
		{
			cedges.each(function(edge, _) {
				if(edge.weight <= 0)
					return;
				var cellhead = layout.cell(edge.head),
					celltail = layout.cell(edge.tail);
				if(cellhead.layer > celltail.layer)
					return;
				var weight = nheight(edge.weight),
					before = 5 + cafter(edge.id, edge.tail.positives()) * (backEdgeSpacing + 1),
					after  = 5 + cafter(edge.id, edge.head.negatives()) * (backEdgeSpacing + 1),
					x1 = layerWidth / 2 + xlayer(celltail.layer),
					x2 = - layerWidth / 2 + xlayer(cellhead.layer),
					y1 = ynode(edge.tail) + ydiagonal(edge.id, edge.tail.positives()),
					y2 = nheight(edge.head.data.entry) + ynode(edge.head) + ydiagonal(edge.id, edge.head.negatives());

				var g = edgescontainer.append("svg:g");

				// chunk
				var chunkf = g.append("svg:rect")
					.attr("x").float(x1)
					.attr("y").float(y1)
					.attr("width").float(chunkWidth)
					.attr("height").float(weight)
					.attr("class").string("edge fill fill-" + styleEdgeBackward + " stroke stroke-"+styleEdgeBackward)
					.onNode("mouseover", onmouseoveredge.bind((x1 + x2) / 2, backedgesy, edge))
				;
				var chunkf = g.append("svg:rect")
					.attr("x").float(x2 - chunkWidth)
					.attr("y").float(y2)
					.attr("width").float(chunkWidth)
					.attr("height").float(weight)
					.attr("class").string("edge fill fill-" + styleEdgeBackward + " stroke stroke-"+styleEdgeBackward)
					.onNode("mouseover", onmouseoveredge.bind((x1 + x2) / 2, backedgesy, edge))
				;

				// hook
				var hook = new HookConnector(g, "stroke stroke-"+styleEdgeBackward);
				addToMap(edge.id, "edge", g);
				hook.update(
					x1 + chunkWidth,
					y1 + weight / 2,
					x2 - chunkWidth,
					y2 + weight / 2,
					backedgesy,
					before,
					after
				);
				hook.g.onNode("mouseover", onmouseoveredge.bind((x1 + x2) / 2, backedgesy, edge));
				if(null != edgeClass)
				{
					var cls = edgeClass({ head : edge.head.data, tail : edge.tail.data, edgeweight : edge.weight }, dependentVariable.stats);
					if(null != cls)
						hook.addClass(cls);
				}
				RGColors.storeColorForSelection(hook.g, "stroke", hook.line.style("stroke").get());
				if(null != clickEdge)
				{
					hook.g.onNode("click", edgeClickWithEdge.bind(edge));
				}
				if(stackbackedges)
					backedgesy += 1 + backEdgeSpacing;
			});
		} else {
			cedges.each(function(edge, _) {
				if(edge.weight <= 0)
					return;
				var cellhead = layout.cell(edge.head),
					celltail = layout.cell(edge.tail);
				if(cellhead.layer > celltail.layer)
					return;
				var weight = nheight(edge.weight),
					hook   = new HookConnectorArea(edgescontainer, "fill fill-"+styleEdgeBackward, "stroke stroke-"+styleEdgeBackward),
					before = hafter(edge.id, edge.tail.positives()) + Math.min(extraWidth, nheight(edge.tail.data.exit)),
					after  = hafter(edge.id, edge.head.negatives()),
					x1 = layerWidth / 2 + xlayer(celltail.layer),
					x2 = - layerWidth / 2 + xlayer(cellhead.layer),
					y1 = ynode(edge.tail) + ydiagonal(edge.id, edge.tail.positives()),
					y2 = nheight(edge.head.data.entry) + ynode(edge.head) + ydiagonal(edge.id, edge.head.negatives());
				addToMap(edge.id, "edge", hook.g);
				hook.update(
					x1,
					y1,
					x2,
					y2,
					weight,
					backedgesy,
					before,
					after
				);
				hook.g.onNode("mouseover", onmouseoveredge.bind((x1 + x2) / 2, backedgesy + weight / 2, edge));
				if(null != edgeClass)
				{
					var cls = edgeClass({ head : edge.head.data, tail : edge.tail.data, edgeweight : edge.weight }, dependentVariable.stats);
					if(null != cls)
						hook.addClass(cls);
				}
				RGColors.storeColorForSelection(hook.g, "fill", hook.area.style("fill").get());
				if(null != clickEdge)
				{
					hook.g.onNode("click", edgeClickWithEdge.bind(edge));
				}
				if(stackbackedges)
					backedgesy += weight + backEdgeSpacing;
			});
		}

// TODO edges must be ordered at the node level
		// forward edges
		edges.each(function(edge, _) {
			if(edge.weight <= 0)
				return;
			var head = edge.head,
				tail = edge.tail,
				cellhead = layout.cell(head),
				celltail = layout.cell(tail);
			if(cellhead.layer <= celltail.layer)
				return;
			var x1 = Math.round(layerWidth / 2 + xlayer(celltail.layer))-.5,
				x2 = Math.round(- layerWidth / 2 + xlayer(cellhead.layer))-.5,
				y1 = ynode(tail) + ydiagonal(edge.id, tail.positives()),
//				Iterators.array(tail.positives()).order(function(a, b){
//					return Floats.compare(b.weight, a.weight);
//				}).iterator()),
				y2 = ynode(head) + nheight(head.data.entry) + ydiagonal(edge.id, head.negatives()),
				weight = nheight(edge.weight),
				diagonal = new DiagonalArea(edgescontainer, "fill fill-"+styleEdgeForward, "stroke stroke-"+styleEdgeForward);
			diagonal.update(
				x1,
				y1,
//				ynode(tail) + hnode(tail) / 2,
				x2,
				y2,
//				ynode(head) + hnode(head) / 2,
				weight,
				weight
			);
			if(null != edgeClass)
			{
				var cls = edgeClass({ head : edge.head.data, tail : edge.tail.data, edgeweight : edge.weight }, dependentVariable.stats);
				if(null != cls)
					diagonal.addClass(cls);
			}
			addToMap(edge.id, "edge", diagonal.g);
			diagonal.g.onNode("mouseover", onmouseoveredge.bind((x1 + x2) / 2, (y1 + y2 + weight) / 2, edge));
			RGColors.storeColorForSelection(diagonal.g, "fill", diagonal.area.style("fill").get());
			if(null != clickEdge)
			{
				diagonal.g.onNode("click", edgeClickWithEdge.bind(edge));
			}
		});

		// exit
		function normMin(v : Float) return Math.max(0, Math.min(v - 3, extraRadius));
		layout.each(function(cell, node) {
			if(node.data.exit <= 0 || extraWidth <= 0 || (null != displayExit && !displayExit(node.data, dependentVariable.stats)))
				return;
			var elbow = new ElbowArea(edgescontainer, "fill fill-"+styleexit, "stroke stroke-"+styleexit),
				extra = nheight(node.data.exit),
				x = layerWidth / 2 + xlayer(cell.layer),
				y = ynode(node) + ydiagonal(null, node.positives()),
				minr = normMin(extra);
			elbow.update(
				RightBottom,
				extra,
				x,
				y + extra,
				minr,  // minr
				extraWidth, // maxweight
				0,  // before
				extraHeight  // after
			);

			if(null != labelEdge)
			{
				var label,
					text = labelEdge({ tail : node, head : null, nodeweight : node.data.weight, edgeweight : node.data.exit }, dependentVariable.stats),
					nodeSpacing = 0;

				label = new Label(edgescontainer, true, true, false);
				label.addClass("edge");
				label.place(
					x,
					y + extra / 2,
					0);
				label.anchor = GridAnchor.Left;
				label.text = text;
				if(label.getSize().height > extra * .75)
				{
					label.destroy();
				}
			}
			elbow.g.onNode("mouseover", onmouseoverexit.bind(x + minr + (-minr + Math.min(extraWidth, extra)) / 2, ynode(node) + hnode(node) + minr + extraHeight, node));
			if(null != edgeClass)
			{
				var cls = edgeClass({ head : null, tail : node.data, edgeweight : node.data.exit }, dependentVariable.stats);
				if(null != cls)
					elbow.addClass(cls);
			}
			RGColors.storeColorForSelection(elbow.g, "fill", elbow.area.style("fill").get());
			if(null != clickEdge)
			{
				elbow.g.onNode("click", edgeClickWithNode.bind(node, true));
			}
			addToMap(node.id, "exit", elbow.g);
		});

		// entry
		layout.each(function(cell, node) {
			if(node.data.entry <= 0 || extraWidth <= 0 || (null != displayEntry && !displayEntry(node.data, dependentVariable.stats)))
				return;
			var elbow = new ElbowArea(edgescontainer, "fill fill-"+styleentry, "stroke stroke-"+styleentry),
				extra = nheight(node.data.entry),
				minr = normMin(extra),
				x = - layerWidth / 2 + xlayer(cell.layer);
			elbow.update(
				LeftTop,
				extra,
				x,
				ynode(node), // + ydiagonal(null, node.positives()) + falloff
				minr,  // minr
				extraWidth, // maxweight
				0,  // before
				extraHeight  // after
			);

			if(null != labelEdge)
			{
				var label,
					text = labelEdge({ tail : null, head : node, nodeweight : node.data.weight, edgeweight : node.data.entry }, dependentVariable.stats),
					nodeSpacing = 0;

				label = new Label(edgescontainer, true, true, false);
				label.addClass("edge");
				label.place(
					x,
					ynode(node) + extra / 2,
					0);
				label.anchor = GridAnchor.Right;
				label.text = text;
				if(label.getSize().height > extra * .75)
				{
					label.destroy();
				}
			}
			elbow.g.onNode("mouseover", onmouseoverentry.bind(				x  - minr + (minr - Math.min(extraWidth, extra)) / 2,
				ynode(node) - minr - extraHeight,
				node));
			if(null != edgeClass)
			{
				var cls = edgeClass({ head : node.data, tail : null, edgeweight : node.data.entry }, dependentVariable.stats);
				if(null != cls)
					elbow.addClass(cls);
			}
			RGColors.storeColorForSelection(elbow.g, "fill", elbow.area.style("fill").get());
			if(null != clickEdge)
			{
				elbow.g.onNode("click", edgeClickWithNode.bind(node, false));
			}
			addToMap(node.id, "entry", elbow.g);
		});

		// edge labels
		if(null != labelEdge)
		{
			edges.each(function(edge, _) {
				if(edge.weight <= 0)
					return;
				// label inside
				var tail = edge.tail;
				if(isdummy(tail))
					return;
				var celltail = layout.cell(tail),
					weight = nheight(edge.weight),
					label,
					text = labelEdge(edgeData(edge), dependentVariable.stats),
					nodeSpacing = 2;

				label = new Label(edgescontainer, true, true, false);
				label.addClass("edge");
				label.place(
					layerWidth / 2 + xlayer(celltail.layer) + nodeSpacing,
					ynode(tail) + ydiagonal(edge.id, tail.positives()) + weight / 2,
					0);
				label.anchor = GridAnchor.Left;
				label.text = text;
				if(label.getSize().height > weight * .75)
				{
					label.destroy();
				}
			});
		}

		var rules = g.selectAll("g.layer").data(layout.layers())
			.enter()
				.append("svg:g").attr("class").string("layer")
				.append("svg:line")
					.attr("class").stringf(function(_, i) return "rule rule-"+i)
					.attr("x1").float(0)
					.attr("x2").float(0)
					.attr("y1").float(0)
					.attr("y2").float(height)
			.update()
				.attr("transform").stringf(function(_, i) {
					return "translate("+xlayer(i)+",0)";
				})
			.exit()
				.remove();

		var choice = rules.update()
			.selectAll("g.node").dataf(function(d : Array<Int>, i) return layout.layer(i));

		var cont = choice
			.enter()
				.append("svg:g").attr("class").string("node");

		if(layerWidth > 0)
		{
			var rect = cont.append("svg:rect")
				.attr("class").stringf(function(n, _) return "fill fill-" + (isdummy(n) ? styleEdgeForward + " nonode" : styleNode + " node"))
				.attr("x").float(-layerWidth / 2)
				.attr("y").float(0)
				.attr("width").float(Math.round(layerWidth))
				.attr("height").floatf(hnode);

			cont.each(function(node, _) {
				addToMap(node.id, "node", Selection.current);
				if(null != nodeClass)
				{
					var cls = nodeClass(node.data, dependentVariable.stats);
					if(null != cls)
						Selection.current.classed().add(cls);
				}
			});
			RGColors.storeColorForSelection(cast cont, "fill", rect.style("fill").get());


			cont.append("svg:line")
				.attr("class").stringf(function(n, _) return "node stroke stroke-" + (isdummy(n) ? styleEdgeForward : styleNode))
				.attr("x1").float(-layerWidth / 2)
				.attr("y1").float(0)
				.attr("x2").float(layerWidth / 2)
				.attr("y2").float(0);

			cont.append("svg:line")
				.attr("class").stringf(function(n, _) return "node stroke stroke-" + (isdummy(n) ? styleEdgeForward : styleNode))
				.attr("x1").float(-layerWidth / 2)
				.attr("y1").floatf(hnode)
				.attr("x2").float(layerWidth / 2)
				.attr("y2").floatf(hnode);
		}

		choice.update().attr("transform").stringf(function(n, i) {
			return "translate(0,"+ynode(n)+")";
		});

		cont.each(function(n : GNode<NodeData, Dynamic>, i) {
			var node = Selection.current;
			if(isdummy(n))
				return;
			var nodeheight = hnode(n),
				label;

			// label inside
			if(null != labelDataPoint)
			{
				var lines = labelDataPoint(n.data.dp, dependentVariable.stats).split("\n"),
					nodeSpacing = 3,
					prev : Label = null,
					text,
					pos = 0.0;
				for(i in 0...lines.length)
				{
					text = lines[i];
					label = new Label(node, true, true, false);
					label.addClass("node");
					if(i == 0)
						label.addClass("first");
					pos = nodeSpacing;
					if(null != prev)
					{
						pos += prev.y + prev.getSize().height;
					}
					label.place(-layerWidth / 2 + nodeSpacing * 2, pos, 0);
					label.anchor = GridAnchor.TopLeft;
					label.text = text;
					if(label.y + label.getSize().height > nodeheight)
					{
						label.destroy();
						break;
					}
					prev = label;
				}
			}

			var hasimage = false;
			// thumbnail
			if(null != imagePath && !isdummy(n))
			{
				var path = imagePath(n.data.dp);
				if(path != null)
				{
					hasimage = true;
					var container = node.append("svg:g")
						.attr("transform").string("translate("+(Math.round(-imageWidth/2))+","+(Math.round(-imageHeight-imageSpacing))+")");
					container.append("svg:image")
						.attr("preserveAspectRatio").string("xMidYMid slice")
						.attr("width").float(imageWidth)
						.attr("height").float(imageHeight)
						.attr("xlink:href").string(path);
				}
			}

			// label top
			if(null != labelNode)
			{
				if(hasimage)
					label = new Label(node, true, true, true);
				else
					label = new Label(node, true, false, false);
				label.anchor = GridAnchor.Bottom;
				label.place(0, -labelNodeSpacing, 0);
				label.text = labelNode(n.data.dp, this.dependentVariable.stats);
			}
		});

		cont.each(function(n : GNode<NodeData, Dynamic>, i) {
			var node = Selection.current;
			node.onNode("mouseover", onmouseovernode.bind(n));
			if(null != click)
			{
				node.onNode("click", nodeclick.bind(n));
			}
		});

		ready.dispatch();
	}

	function addToMap(id : Int, type : String, el : Selection)
	{
		mapelements.set(type+":"+id, el);
	}

	function isbackward(edge : GEdge<NodeData, Dynamic>)
	{
		return layout.cell(edge.head).layer <= layout.cell(edge.tail).layer;
	}

	function highlight(id : Int, type : String)
	{
		for(el in maphi)
			el.classed().remove("over");

		maphi = new Map ();

		var hiedgep = null,
			hinodep = null,
			hiedgen = null,
			hinoden = null;


		function hielement(id : Int, type : String)
		{
			var key = type+":"+id;
			maphi.set(key, mapelements.get(key).classed().add("over"));
		}

		function hientry(id : Int)
		{
			var key = "entry:"+id,
				extra = mapelements.get(key);
			if(null == extra)
				return;
			maphi.set(key, extra.classed().add("over"));
		}

		function hiexit(id : Int)
		{
			var key = "exit:"+id,
				extra = mapelements.get(key);
			if(null == extra)
				return;
			maphi.set(key, extra.classed().add("over"));
		}

		function ishi(id : Int, type : String)
		{
			return maphi.exists(type + ":" + id);
		}

		hiedgep = function(edge : GEdge<NodeData, Dynamic>)
		{
			if(ishi(edge.id, "edge"))
				return;
			hielement(edge.id, "edge");
			if(!isbackward(edge))
				hinodep(edge.head);
		}

		hinodep = function(node : GNode<NodeData, Dynamic>)
		{
			if(ishi(node.id, "node"))
				return;
			hielement(node.id, "node");
			hiexit(node.id);
			for(edge in node.positives())
				hiedgep(edge);
		}

		hiedgen = function(edge : GEdge<NodeData, Dynamic>)
		{
			if(!isbackward(edge))
				hinoden(edge.tail);
			if(ishi(edge.id, "edge"))
				return;
			if(!isbackward(edge))
				hielement(edge.id, "edge");
		}

		hinoden = function(node : GNode<NodeData, Dynamic>)
		{
			for(edge in node.negatives())
				hiedgen(edge);
			if(ishi(node.id, "node"))
				return;
			hielement(node.id, "node");
			hientry(node.id);
		}

		if(type == "edge")
		{
			hiedgep(layout.graph.edges.get(id));
			hiedgen(layout.graph.edges.get(id));
		} else if(type == "node")
		{
			hinodep(layout.graph.nodes.get(id));
			hinoden(layout.graph.nodes.get(id));
			hientry(id);
		}
		// descend

		// ascend
	}

	function edgeData(edge : GEdge<NodeData, Dynamic>)
	{
		var head = edge.head,
			tail = edge.tail;
		while(isdummy(head))
			head = head.positives().next().head;
		while(isdummy(tail))
			tail = tail.negatives().next().tail;
		return {
			head : head.data.dp,
			tail : tail.data.dp,
			edgeweight : edge.weight,
			nodeweight : tail.data.weight
		};
	}

	function edgeDataWithNode(node : GNode<NodeData, Dynamic>, out : Bool) 
	{
		return {
			tail : out ? node.data.dp : null,
			head : out ? null : node.data.dp,
			edgeweight : out ? node.data.exit : node.data.entry,
			nodeweight : node.data.weight
		};
	}

	function nodeclick(node : GNode<NodeData, Dynamic>, el : js.html.Element, i : Int)
	{
		click(node.data.dp, dependentVariable.stats);
	}

	function edgeclick(data : { head : Dynamic, tail : Dynamic, edgeweight : Float, nodeweight : Float }, el : js.html.Element, i : Int)
	{
		clickEdge(data, dependentVariable.stats);
	}

	function edgeClickWithEdge(edge : GEdge<NodeData, Dynamic>, el : js.html.Element, i : Int)
	{
		edgeclick(edgeData(edge), el, i);
	}

	function edgeClickWithNode(node : GNode<NodeData, Dynamic>, out : Bool, el : js.html.Element, i : Int)
	{
		edgeclick(edgeDataWithNode(node, out), el, i);
	}

	function onmouseovernode(node : GNode<NodeData, Dynamic>, el : js.html.Element, i : Int)
	{
		highlight(node.id, "node");
		if(isdummy(node))
		{
			if(null == labelEdgeOver)
				return;
			var text = labelEdgeOver(edgeData(node.positives().next()), dependentVariable.stats);
			if(untyped __js__("false === text"))
			{} // do nothing
			else if (null == text)
				tooltip.hide();
			else
			{
				var cell = layout.cell(node);
				tooltip.anchor("bottomright");
				tooltip.html(text.split("\n").join("<br>"));
				moveTooltip(
					xlayer(cell.layer),
					ynode(node) + hnode(node) / 2,
					RGColors.extractColor(el)
				);
			}
		} else {
			if(null == labelDataPointOver)
				return;
			var text = labelDataPointOver(node.data.dp, dependentVariable.stats);
			if(untyped __js__("false === text"))
			{} // do nothing
			else if (null == text)
				tooltip.hide();
			else
			{
				var cell = layout.cell(node);
				tooltip.anchor("bottomright");
				tooltip.html(text.split("\n").join("<br>"));
				moveTooltip(
					xlayer(cell.layer),
					ynode(node) + hnode(node) / 2,
					RGColors.extractColor(el)
				);
			}
		}
	}

	function onmouseoveredge(x : Float, y : Float, edge : GEdge<NodeData, Dynamic>, el : js.html.Element, i : Int)
	{
		highlight(edge.id, "edge");
		if(null == labelEdgeOver)
			return;
		var text = labelEdgeOver(edgeData(edge), dependentVariable.stats);
		if (null == text)
			tooltip.hide();
		else
		{
			tooltip.anchor("bottomright");
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(x, y, RGColors.extractColor(el));
		}
	}

	function onmouseoverentry(x : Float, y : Float, node : GNode<NodeData, Dynamic>, el : js.html.Element, i : Int)
	{
		highlight(node.id, "node");
		if(null == labelEdgeOver)
			return;
		var text = labelEdgeOver(edgeDataWithNode(node, false), dependentVariable.stats);
		if (null == text)
			tooltip.hide();
		else
		{
			tooltip.anchor("bottomright");
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(x, y, RGColors.extractColor(el));
		}
	}

	function onmouseoverexit(x : Float, y : Float, node : GNode<NodeData, Dynamic>, el : js.html.Element, i : Int)
	{
		highlight(node.id, "node");
		if(null == labelEdgeOver)
			return;
		var text = labelEdgeOver(edgeDataWithNode(node, true), dependentVariable.stats);
		if (null == text)
			tooltip.hide();
		else
		{
			tooltip.anchor("topleft");
			tooltip.html(text.split("\n").join("<br>"));
			moveTooltip(x, y, RGColors.extractColor(el));
		}
	}

	function nheight(v : Float)
	{
		if(0 == v)
			return 0;
		return Math.round(v / maxweight * availableheight);
	}

	function ydiagonal(id : Int, edges : Iterator<GEdge<NodeData, Dynamic>>)
	{
		var weight = 0.0;
		for(edge in edges)
		{
			if(edge.id == id)
				break;
			weight += edge.weight;
		}
		return nheight(weight);
	}

	function cafter(id : Int, edges : Iterator<GEdge<NodeData, Dynamic>>)
	{
		var found = false,
			count = 0;
		for(edge in edges)
		{
			if(!found)
			{
				if(edge.id == id)
					//	continue;
					found = true;
				continue;
			}
			count++;
		}
		return count;
	}

	function hafter(id : Int, edges : Iterator<GEdge<NodeData, Dynamic>>)
	{
		var found = false,
			pad = backEdgeSpacing / nheight(1),
			weight = pad;
		for(edge in edges)
		{
			if(!found)
			{
				if(edge.id == id)
					//	continue;
					found = true;
				continue;
			}
			weight += edge.weight + pad;
		}
		return nheight(weight);
	}

	function xlayer(pos : Int, ?_)
	{
		if(layout.length <= 1)
			return width / 2;
		return Math.round((width - padBefore - padAfter - layerWidth) / (layout.length - 1) * pos + (layerWidth / 2) + padBefore); // + 0.5;
	}

	function ynode(node : GNode<NodeData, Dynamic>, ?_)
	{
		var cell = layout.cell(node),
			before = 0.0 + layerstarty[cell.layer];
		for(i in 0...cell.position)
		{
			var prev = layout.nodeAt(cell.layer, i);
			before += hnode(prev) + nodepadding(prev);
		}
		before += nodepadding(node);
		return Math.round(before) + 0.5;
	}

	function nodepadding(node : GNode<NodeData, Dynamic>)
	{
		return isdummy(node) ? dummySpacing : nodeSpacing;
	}

	function isdummy(node : GNode<NodeData, Dynamic>)
	{
		return node.data.id.substr(0, 1) == "#";
	}

	function hnode(node : GNode<NodeData, Dynamic>, ?_)
	{
		return nheight(node.data.weight);
	}
}

typedef NodeData =
{
	dp       : Dynamic,
	id       : String,
	weight   : Float,
	entry    : Float,
	exit     : Float
}