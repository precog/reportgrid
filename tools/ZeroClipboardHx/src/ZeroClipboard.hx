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
import flash.display.Stage;
import flash.display.Sprite;
import flash.display.LoaderInfo;
import flash.display.StageScaleMode;
import flash.events.MouseEvent;
import flash.events.Event;
import flash.display.StageAlign;
import flash.display.StageScaleMode;
import flash.external.ExternalInterface;
import flash.system.Security;
//import flash.utils.*;
import flash.system.System;

class ZeroClipboard extends Sprite {

	static var id:String = '';
	static var button:Sprite;
	static var clipText:String = '';

	static function main() {
		if(null == flash.Lib.current.stage)
			haxe.Timer.delay(main, 15);
		else
			init();
	}

	static function init() {
		// constructor, setup event listeners and external interfaces
		flash.system.Security.allowDomain("*");

		// import flashvars
		var flashvars = flash.Lib.current.loaderInfo.parameters;
		id = flashvars.id;

		// invisible button covers entire stage
		button = new Sprite();
		button.buttonMode = true;
		button.useHandCursor = true;
		button.graphics.beginFill(0xCCFF00);
		button.graphics.drawRect(0, 0, Math.floor(flashvars.width), Math.floor(flashvars.height));
		button.alpha = 0.0;
		flash.Lib.current.addChild(button);
		button.addEventListener(MouseEvent.CLICK, clickHandler);

		button.addEventListener(MouseEvent.MOUSE_OVER, function(event:Event) {
			ExternalInterface.call( 'ZeroClipboard.dispatch', id, 'mouseOver', null );
		} );
		button.addEventListener(MouseEvent.MOUSE_OUT, function(event:Event) {
			ExternalInterface.call( 'ZeroClipboard.dispatch', id, 'mouseOut', null );
		} );
		button.addEventListener(MouseEvent.MOUSE_DOWN, function(event:Event) {
			ExternalInterface.call( 'ZeroClipboard.dispatch', id, 'mouseDown', null );
		} );
		button.addEventListener(MouseEvent.MOUSE_UP, function(event:Event) {
			ExternalInterface.call( 'ZeroClipboard.dispatch', id, 'mouseUp', null );
		} );

		// external functions
		ExternalInterface.addCallback("setHandCursor", setHandCursor);
		ExternalInterface.addCallback("setText", setText);

		// signal to the browser that we are ready
		ExternalInterface.call( 'ZeroClipboard.dispatch', id, 'load', null );
	}

	static public function setText(newText) {
		// set the maximum number of files allowed
		clipText = newText;
	}

	static public function setHandCursor(enabled:Bool) {
		// control whether the hand cursor is shown on rollover (true)
		// or the default arrow cursor (false)
		button.useHandCursor = enabled;
	}

	static private function clickHandler(event:Event) {
		// user click copies text to clipboard
		// as of flash player 10, this MUST happen from an in-movie flash click event
		System.setClipboard( clipText );
		ExternalInterface.call( 'ZeroClipboard.dispatch', id, 'complete', StringTools.urlEncode(clipText) );
	}
}