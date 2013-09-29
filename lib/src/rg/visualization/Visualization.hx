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

package rg.visualization;
import thx.error.AbstractMethod;
import rg.data.VariableDependent;
import rg.data.VariableIndependent;
import rg.data.Variable;
import rg.axis.IAxis;
import hxevents.Notifier;
import hxevents.Dispatcher;
import dhx.Selection;
using Arrays;

class Visualization
{
	public var independentVariables(default, null) : Array<VariableIndependent<Dynamic>>;
	public var dependentVariables(default, null) : Array<VariableDependent<Dynamic>>;
	public var variables(default, null) : Array < Variable < Dynamic, IAxis<Dynamic> >> ;
	public var container(default, null) : Selection;
	var ready : Notifier;
	var error : hxevents.Dispatcher<Dynamic>;
	var hasRendered : Bool;

	private function new(container : Selection)
	{
		this.container = container;
	}

	public function setVariables(variables : Array<Variable<Dynamic, IAxis<Dynamic>>>, independentVariables : Array<VariableIndependent<Dynamic>>, dependentVariables : Array<VariableDependent<Dynamic>>)
	{
		this.variables = variables;
		this.independentVariables = independentVariables;
		this.dependentVariables = dependentVariables;
		hasRendered = false;
		ready = new Notifier();
		ready.addOnce(function() hasRendered = true);
		error = new Dispatcher();
		error.addOnce(function(_) ready.dispatch());
	}

	public function init()
	{
		try {
			_init();
		} catch(e : Dynamic) {
			error.dispatch(e);
		}
	}

	function _init() {
		throw new AbstractMethod();
	}

	public function feedData(data : Array<Dynamic>)
	{
		try {
			_feedData(data);
		} catch(e : Dynamic) {
			error.dispatch(e);
		}
	}

	function _feedData(data : Array<Dynamic>)
	{

	}

	public function destroy()
	{

		try {
			_destroy();
		} catch(e : Dynamic) {
			error.dispatch(e);
		}
	}

	function _destroy()
	{

	}

	public function addReadyOnce(handler : Void -> Void)
	{
		ready.addOnce(handler);
		if (hasRendered)
			handler();
	}

	public function addReady(handler : Void -> Void)
	{
		ready.add(handler);
		if (hasRendered)
			handler();
	}

	public function removeReady(handler : Void -> Void)
	{
		ready.remove(handler);
	}

	public function addError(handler : Dynamic -> Void)
	{
		error.add(handler);
	}
}