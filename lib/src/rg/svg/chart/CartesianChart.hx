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

package rg.svg.chart;
import rg.svg.panel.Layer;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.svg.panel.Panel;
import thx.error.AbstractMethod;
import rg.axis.Stats;
import thx.math.Equations;
import rg.svg.panel.Panels;
import rg.data.Variable;
import rg.axis.IAxis;

class CartesianChart<T> extends Chart
{
	public var yVariables : Array<Variable<Dynamic, IAxis<Dynamic>>>;
	public var xVariable : Variable<Dynamic, IAxis<Dynamic>>;

	public var labelDataPointVerticalOffset : Float;
	public var labelDataPointOutline : Bool;
	public var labelDataPointShadow : Bool;

	public function new(panel : Panel)
	{
		super(panel);
		labelDataPointVerticalOffset = 25;
		labelDataPointOutline = false;
		labelDataPointShadow = false;
	}

	public function setVariables(variables : Array<Variable<Dynamic, IAxis<Dynamic>>>, variableIndependents : Array<VariableIndependent<Dynamic>>, variableDependents : Array<VariableDependent<Dynamic>>, data :T)
	{
		this.xVariable  = variables[0];
		this.yVariables = variables.slice(1);
	}

	public function data(dps : T)
	{
		throw new AbstractMethod();
	}
}