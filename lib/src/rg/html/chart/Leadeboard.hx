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
/**
 * ...
 * @author Franco Ponticelli
 */

package rg.html.chart;
import rg.axis.Stats;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.util.Properties;
import thx.culture.FormatNumber;
import dhx.Selection;
import rg.util.DataPoints;
import thx.math.Equations;
import dhx.Dom;
import hxevents.Notifier;
using Arrays;

// TODO MOVE SORTING TO AXIS
class Leadeboard
{
	var variableIndependent : VariableIndependent<Dynamic>;
	var variableDependent : VariableDependent<Dynamic>;

	public var animated : Bool;
	public var animationDuration : Int;
	public var animationDelay : Int;
	public var animationEase : Float -> Float;
	public var click : Dynamic -> Void;
	public var sortDataPoint : Dynamic -> Dynamic -> Int;
	public var displayGradient : Bool;
	public var useMax : Bool;
	public var colorScale : Bool;
	public var ready(default, null) : Notifier;

	public var displayBar : Bool;

	var container : Selection;
	var list : Selection;

	var _created : Int;
	var stats : StatsNumeric;
	public function new(container : Selection)
	{
		ready = new Notifier();
		this.container = container;
		animated = true;
		animationDuration = 1500;
		animationEase = Equations.elasticf();
		animationDelay = 150;
		_created = 0;
		displayGradient = true;
		useMax = false;
		colorScale = false;
	}

	public dynamic function labelDataPoint(dp : Dynamic, stats : StatsNumeric)
	{
		return Properties.humanize(DataPoints.value(dp, variableIndependent.type));
	}

	public dynamic function labelDataPointOver(dp : Dynamic, stats : StatsNumeric)
	{
		return Floats.format(100*DataPoints.value(dp, stats.type)/(useMax ? stats.max : stats.tot), "P:1");
	}

	public dynamic function labelRank(dp : Dynamic, i : Int, stats : StatsNumeric)
	{
		return "" + (i+1);
	}

	public dynamic function labelValue(dp : Dynamic, stats : StatsNumeric)
	{
		return Properties.formatValue(stats.type, dp);
	}

	public function init()
	{
		var div = container
			.append("div")
			.attr("class").string("leaderboard");
		list = div.append("ul");
		div.append("div").attr("class").string("clear");
	}

	public function setVariables(variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>)
	{
		variableDependent = variableDependents[0];
		variableIndependent = variableIndependents[0];
	}

	function backgroundSize(dp, i)
	{
		return (100 * DataPoints.value(dp, variableDependent.type) / (useMax ? stats.max : stats.tot)) + "%";
	}

	public function data(dps : Array<Dynamic>)
	{
		var name = variableDependent.type;
		if (null != sortDataPoint)
			dps.sort(sortDataPoint);
		if (null == variableDependent.stats)
			return;

		var stats = this.stats = cast(variableDependent.stats, StatsNumeric);

		var choice = list.selectAll("li").data(dps, id);

		// enter
		var enterli = choice.enter().append("li");
		// title
		enterli.attr("title").stringf(lTitle);

		//background
		enterli.append("div").attr("class").stringf(function(_, i) {
			 return i % 2 == 0 ? "rg_background fill-0" : "rg_background";
		});

		var enterlabels = enterli.append("div").attr("class").string("rg_labels");

		// rank
		if(null != labelRank)
		{
			var rank = enterlabels.append("div")
				.text().stringf(lRank);
			if(colorScale)
				rank.attr("class").stringf(function(_, i) return "rg_rank fill fill-"+i);
			else
				rank.attr("class").string("rg_rank");
		}

		// datapoint
		if(null != labelDataPoint)
		{
			enterlabels.append("span")
				.attr("class").string("rg_description color-0")
				.text().stringf(lDataPoint);
		}

		// value
		if(null != labelValue)
		{
			enterlabels.append("span")
				.attr("class").string("rg_value color-2")
				.text().stringf(lValue);
		}

		enterli.append("div").attr("class").string("clear");

		// bar
		if(displayBar)
		{
			var barpadding = enterli.append("div").attr("class").string("rg_barpadding"),
				enterbar = barpadding.append("div")
				.attr("class").string("rg_barcontainer");
			enterbar.append("div")
				.attr("class").string("rg_barback fill-0");
			enterbar.append("div")
				.attr("class").string("rg_bar fill-0")
				.style("width").stringf(backgroundSize);
			enterli.append("div").attr("class").string("clear");
		}

		if (null != click)
			enterli.on("click.user", onClick);
		if (animated)
		{
			enterli.style("opacity").float(0).eachNode(fadeIn);
		} else {
			enterli.style("opacity").float(1);
		}

		// exit
		if (animated)
		{
			choice.exit()
				.transition().ease(animationEase).duration(animationDuration)
				.style("opacity").float(0)
				.remove();
		} else {
			choice.exit().remove();
		}
		ready.dispatch();
	}

	function onClick(dp : Dynamic, ?_)
	{
		click(dp);
	}

	function fadeIn(n, i)
	{
		var me = this;
		Dom.selectNodeData(n)
			.transition().ease(animationEase).duration(animationDuration)
				.delay(animationDelay * (i - _created))
				.attr("opacity").float(1)
				.endNode(function(_, _) {
					me._created++;
				});
	}


	function lRank(dp, i)
	{
		return labelRank(dp, i, stats);
	}

	function lValue(dp, i)
	{
		return labelValue(dp, stats);
	}

	function lDataPoint(dp, i)
	{
		return labelDataPoint(dp, stats);
	}

	function lTitle(dp, i)
	{
		return labelDataPointOver(dp, stats);
	}

	function id(dp : Dynamic, ?_) return DataPoints.id(dp, [variableDependent.type]);
}