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
package rg.html.widget;

import haxe.Timer;
import js.html.Element;
import dhx.Dom;
import dhx.Selection;
import haxe.ds.StringMap;

class Logo
{
	static var registry = new StringMap();

	public static function pageIsBranded()
	{
		for(logo in getLogos())
			if(!dhx.Dom.select('img[src="' + logo + '"]').empty())
				return true;
		return false;
	}

	public static function createLogo(container : Selection, padright : Int)
	{
		var id   = container.attr("id").get(),
			logo = registry.get(id);
		if(null == logo)
		{
			registry.set(id, logo = new Logo(container, padright));
		} else {
			logo.live();
		}
		return logo;
	}

	public var chartContainer(default, null) : Selection;
	static var _id = 0;
	static inline var LOGO_WIDTH = 194;
	static inline var LOGO_HEIGHT = 29;
	var container : Selection;
	var frame : Selection;
	var anchor : Selection;
	var image : Selection;
	var id : Int;
	var mapvalues : StringMap<Dynamic>;
	var padRight : Int;
	function new(container : Selection, padright : Int)
	{
		mapvalues = new StringMap();
		this.padRight = padright;
		id = ++_id;
		this.container = container;
		create();
		var timer = new Timer(5000);
		timer.run = live;
	}

	function live()
	{
		if(container.select('div.reportgridbrandcontainer').empty())
			createFrame();
		else
			updateFrame();
		if(Dom.select("body").select('a.reportgridbrandanchor'+id).empty())
			createAnchor();
		else
			updateAnchor();
		if(anchor.select('img').empty())
			createImage();
		else
			updateImage();
	}

	function create()
	{
		createFrame();
		createAnchor();
		createImage();
	}

	function createFrame()
	{
		chartContainer = container.select('*');
		frame = container.insert('div', chartContainer.node())
			.attr('class').string('reportgridbrandcontainer')
		;
		updateFrame();
	}

	function createAnchor()
	{
		anchor = Dom.select("body")
			.append('a')
			.attr('class').string('reportgridbrandanchor'+id)
			.attr('target').string('_blank');
		updateAnchor();
	}

	function createImage()
	{
		image = anchor.append('img');
		updateImage();
	}

	function updateFrame()
	{
		setStyle(frame, 'display', 'block');
		setStyle(frame, 'opacity', '1');
		setStyle(frame, 'width', '100%');
		setStyle(frame, 'height', LOGO_HEIGHT+'px');
		setStyle(frame, 'position', 'relative');
	}

	function setStyle(s : Selection, name : String, value : String)
	{
		var key = "style:"+name+":"+value,
			v : Dynamic;
		if(null != (v = mapvalues.get(key)) && v != s.style(name).get())
		{
			s.style(name).string(v, 'important');
		} else if(null == v) {
			s.style(name).string(value, 'important');
			mapvalues.set(key, s.style(name).get());
		}
	}

	function setAttr(s : Selection, name : String, value : String)
	{
		var key = "attr:"+name+":"+value,
			v : Dynamic;
		if(null != (v = mapvalues.get(key)) && v != s.attr(name).get())
		{
			s.attr(name).string(v);
		} else if(null == v) {
			s.attr(name).string(value);
			mapvalues.set(key, s.attr(name).get());
		}
	}

	function updateAnchor()
	{
		var body = js.Browser.document.body,
			len = body.childNodes.length;
		if(Dom.select("body :last-child").node() != anchor.node())
		{
			body.appendChild(anchor.node());
		}
		var pos = position(frame.node()),
			width = frame.style('width').getFloat();
		setAttr(anchor, 'title', 'Powered by ReportGrid');
		setAttr(anchor, 'href', 'http://www.reportgrid.com/charts/');
		setStyle(anchor, 'z-index', '2147483647');
		setStyle(anchor, 'display', 'block');
		setStyle(anchor, 'opacity', '1');
		setStyle(anchor, 'position', 'absolute');
		setStyle(anchor, 'height', LOGO_HEIGHT+'px');
		setStyle(anchor, 'width', LOGO_WIDTH+'px');
		setStyle(anchor, 'top', pos.y + 'px');
		setStyle(anchor, 'left', (pos.x - LOGO_WIDTH + width-padRight) + 'px');
	}

	function updateImage()
	{
		setAttr(image, 'src', getLogo());
		setAttr(image, 'title', 'Powered by ReportGrid');
		setAttr(image, 'height', ''+LOGO_HEIGHT);
		setAttr(image, 'width', ''+LOGO_WIDTH);
		setStyle(image, 'opacity', '1');
		setStyle(image, 'border', 'none');
		setStyle(image, 'height', LOGO_HEIGHT+'px');
		setStyle(image, 'width', LOGO_WIDTH+'px');
	}

	static function getLogo()
	{
		return getLogos()[0];
	}

	static function getLogos()
	{
		return [
			'http://api.reportgrid.com/css/images/reportgrid-clear.png',
			'http://api.reportgrid.com/css/images/reportgrid-cleart.png',
			'http://api.reportgrid.com/css/images/reportgrid-dark.png',
			'http://api.reportgrid.com/css/images/reportgrid-darkt.png',
			'https://api.reportgrid.com/css/images/reportgrid-clear.png',
			'https://api.reportgrid.com/css/images/reportgrid-cleart.png',
			'https://api.reportgrid.com/css/images/reportgrid-dark.png',
			'https://api.reportgrid.com/css/images/reportgrid-darkt.png'
		];
	}

	static function position(el : Element)
	{
		var p = { x : untyped el.offsetLeft || 0, y : untyped el.offsetTop || 0 };
        while (null != (el = el.offsetParent)) {
            p.x += el.offsetLeft;
            p.y += el.offsetTop;
        }
        return p;
	}
}