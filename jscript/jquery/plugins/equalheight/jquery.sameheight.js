/*

 Name: jQuery sameHeight 1.4.0
 Author: giorgio.beggiora@gmail.com

 requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel
 https://gist.github.com/paulirish/1579671

 Optional dependency: CSS-Element-Queries
 http://marcj.github.io/css-element-queries/

 This plugin sets all the matched elements' height to the highest one,
 waiting for images in them to have their height setted (i.e. when they're loaded).
 It's compatible with elements in a container with the css property column-count
 greater than 1.

 Options:

 - compact (boolean) [default = false] : each row will have its own height.

 - responsive (boolean) [default = true] : if true, the max height depends
 from the elements' content, from css otherwise.

 - target: if an element is given, the height will be its one.

 - debounce: debounce in milliseconds, rounded by requestAnimationFrame.

 - observe (window/DOM element) [default = window]: elements which size changes
   must be detected.

 - columnCount (number/string) [default = 1]: closest ancestor's CSS column-count
   property's value ('auto' is not supported).
   If set to 'calc', each time the resize event is triggered the DOM will be traversed
   upward until an element with a column-count value greater than 1 will be found,
   so it's better to avoid it and explicitly set a number.

Returns:

An instance of the observer with the stop() method to stop listening the resize event (similar to the jQuery's off() method).

 */

if (!Number.isFinite) Number.isFinite = function(value) {
	return typeof value === 'number' && isFinite(value);
}

if (!Number.isInteger) Number.isInteger = function(value) {
	return typeof value === 'number' && isFinite(value) && Math.floor(value) === value;
}

;(function() {

	if (!window.requestAnimationFrame) {
		window.requestAnimationFrame = window.mozRequestAnimationFrame
	    || window.webkitRequestAnimationFrame
	    || window.msRequestAnimationFrame
	    || function(f){return setTimeout(f, 1000/60)}
	}

	if (!window.cancelAnimationFrame) {
		window.cancelAnimationFrame = window.mozCancelAnimationFrame
		|| function(requestID){clearTimeout(requestID)}
	}

}());

(function ( $ ) {

	const win = this;
	var eventResizeHandler = null;

	var elementResizeHandlers = [];
	var windowObserverHandlers = null;
	var windowObserverHandlersLen = 0;
	var windowObserverHandlersAI = 0;

	var rAFTimeoutHandlers = {};
	var rAFTimeoutHandlersNextId = 0;
	var windowObserverHandlerId = 0;

	function setRAFTimeout(callback, ms) {

		var id, h, now = Date.now();
		if (arguments.length > 2) {
			id = arguments[2];
			h = rAFTimeoutHandlers[id];
		} else {
			id = rAFTimeoutHandlersNextId++ ;
			h = { id: id, start: now };
			rAFTimeoutHandlers[id] = h;
		}

		if ( h ) {
			if ( now - h.start < ms ) {
				requestAnimationFrame(setRAFTimeout.bind(win, callback, ms, id));
			} else {
				delete rAFTimeoutHandlers[id];
				callback();
			}
		}

		return id;
	}

	function clearRAFTimeout (id) {
		delete rAFTimeoutHandlers[id];
	}

	function sameHeightObserver (options) {

		this.$el = options.$el;
		this.settings = options.settings;

		this.debounceHandler = null; // handler del debouncer
		this.observerHandler = null; // handler dell'observer
		var observeMethod = options.observeMethod;

		if (observeMethod === 'Window') {
			this.windowObserverHandlerId = windowObserverHandlerId;
		}

		this.debouncedResize = debouncedResize.bind(this);

		this.stop = function () {
			var clearHandler = function () {} ;
			switch (observeMethod) {
				case 'Window':
					delete windowObserverHandlers[this.windowObserverHandlerId];
					windowObserverHandlersLen -= 1;
				break;
				case 'ResizeObserver':
					this.observerHandler.disconnect();
				break;
				case 'ResizeSensor':
					this.observerHandler.detach();
				break;
				case 'requestAnimationFrame':
					clearRAFTimeout(this.observerHandler);
				break;
			}
		}

	}

	function debouncedResize() {
		if (this === win) {
			for (id in windowObserverHandlers) {
				var instance = windowObserverHandlers[id];
				clearRAFTimeout(instance.debounceHandler);
				instance.debounceHandler = setRAFTimeout(doTheMagic.bind(instance), instance.settings.debounce);
			}
		} else {
			var instance = this;
			clearRAFTimeout(instance.debounceHandler);
			instance.debounceHandler = setRAFTimeout(doTheMagic.bind(instance), instance.settings.debounce);
		}
	}

	function doTheMagic () {

		var $el = this.$el;
		var settings = this.settings;

		// - Check if asynchronous elements have an height...
		var images = $el.find('img, input[type="image"]').toArray();
		var allImagesHaveHeight = images.every(function(img){
			return !! ( img.complete || img.height || parseInt(getComputedStyle(img).height) );
		});

		// ...If not, continue but schedule another loop.
		if (!allImagesHaveHeight) {
			clearRAFTimeout(this.debounceHandler);
			this.debounceHandler = setRAFTimeout(this.debouncedResize, settings.debounce);
		}

		// - Check if target exists...
		var $target = $(settings.target)

		// ...If yes, use its height, end this loop and schedule another one.
		if($target.length){
			$el.height($target.height());
			clearRAFTimeout(this.debounceHandler);
			this.debounceHandler = setRAFTimeout(this.debouncedResize, settings.debounce);
			return;
		}

		// - Group elements per row
		var groupData = null;

		if (settings.compact) {
			var cssColumns = 1;
			if (typeof settings.columnCount === 'number') {
				cssColumns = settings.columnCount;
			} else if (settings.columnCount === 'calc') {
				var up = $el.get(0).parentNode;
				var columnCount = '';
				do {
					columnCount = Number(getComputedStyle(up).columnCount);
					if (Number.isInteger(columnCount) && columnCount > 1) {
						cssColumns = columnCount;
						break;
					}
					up = up.parentNode;
				} while (up.parentNode);
			}
			groupData = cssColumns > 1 ? groupCompactColumns($el, cssColumns) : groupCompact($el);
		} else {
			groupData = group($el);
		}

		// - Calculate heights
		calcHeights($el, groupData, settings);

	} // end doTheMagic()

	function group ($el) {
		var el_length = $el.length;
		var grouped = [];
		var cols = el_length;
		var rows = 1;
		grouped[0] = [];
		for (var i = 0; i < el_length; i++) {
			grouped[0].push($el.get(i));
		}
		return {grouped: grouped, rows: rows, cols: cols};
	}

	function groupCompact ($el) {
		var el_length = $el.length;
		var grouped = [];
		var y = null;
		for(var cols = 0; cols < el_length; cols++){
			var offset = $el.eq(cols).offset();
			var offsetTop = offset.top;
			if(y !== offsetTop){
				if(y === null){
					y = offsetTop;
				}else{
					break;
				}
			}
		}
		rows = Math.ceil(el_length / cols);
		for(i = 0; i < el_length; i++){
			r = Math.floor(i / cols);
			c = i % cols;
			if(typeof grouped[r] === 'undefined'){
				grouped[r] = [];
			}
			grouped[r].push($el.get(i));
		}
		return {grouped: grouped, rows: rows, cols: cols};
	}

	function groupCompactColumns ($el, cols) {
		var el_length = $el.length;
		var grouped = [];
		var rows = Math.ceil(el_length / cols);
		for(var i = 0; i < el_length; i++){
			var r = i % rows;
			var c = Math.floor(i / rows);
			if(typeof grouped[r] === 'undefined'){
				grouped[r] = [];
			}
			grouped[r].push($el.get(i));
		}
		return {grouped: grouped, rows: rows, cols: cols};
	}

	function calcHeights ($el, groupData, settings) {
		var grouped = groupData.grouped;
		var rows = groupData.rows;
		for(var r = 0; r < rows; r++){
			var maxHeight = 0;
			var g = grouped[r], gl = g.length;
			for(var c = 0; c < gl; c++){
				var item = g[c], $item = $(item);
				if(settings.responsive){
					item.style.height = 'auto';
				}
				maxHeight = Math.max(maxHeight, $item.height());
			}
			$(g).height(maxHeight);
		}
	}

	function sameHeight ( options ) {
		var settings = $.extend({
			compact: false,
			responsive: true,
			target: null,
			observe: window,
			debounce: 1,
			columnCount: 1
		}, options );

		if ($.isNumeric(settings.debounce)){
			settings.debounce = Number(settings.debounce);
			if (settings.debounce < 1) settings.debounce = 1;
		} else {
			settings.debounce = 1;
		}

		if ($.isNumeric(settings.columnCount)) {
			settings.columnCount = Number(settings.columnCount);
			if (settings.columnCount < 1) settings.columnCount = 1;
		} else {
			if (settings.columnCount !== 'calc') settings.columnCount = 1;
		}

		var $el = $(this);
		var newInstanceOptions = {
			$el: $el,
			settings: settings
		};

		var observeWhat = '';
		var observeType = Object.prototype.toString.call( settings.observe );

		if ( observeType === '[object String]' ) {
			observeWhat = 'query';
		} if ( observeType === '[object Window]' ) {
			observeWhat = 'window';
		} else if ( observeType === '[object HTMLCollection]' ) {
			observeWhat = 'element';
		} else if ( observeType.indexOf('[object HTML') === 0 ) {
			observeWhat = 'element';
		}

		var observeMethod = '';
		if (observeWhat === 'window') {
			observeMethod = 'Window';
		} else  if(observeWhat) {
			if ('ResizeObserver' in window) {
				observeMethod = 'ResizeObserver';
			} else if ('ResizeSensor' in window) {
				observeMethod = 'ResizeSensor';
			} else {
				observeMethod = 'requestAnimationFrame';
			}
		}

		newInstanceOptions.observeMethod = observeMethod;
		var newInstance = new sameHeightObserver(newInstanceOptions);

		switch (observeMethod) {
			case 'Window':
				if (windowObserverHandlers === null) {
					windowObserverHandlers = {};
					var $win = $(window);
					$win.on('resize', debouncedResize);
					$win.on('load', debouncedResize);
				}
				windowObserverHandlerId = windowObserverHandlersAI++;
				windowObserverHandlers[windowObserverHandlerId] = newInstance;
				windowObserverHandlersLen += 1;
			break;
			case 'ResizeObserver':
				var ro = new ResizeObserver(newInstance.debouncedResize);
				ro.observe(settings.observe);
				newInstance.observerHandler = ro;
			break;
			case 'ResizeSensor':
				var rs = new ResizeSensor(settings.observe, newInstance.debouncedResize);
				newInstance.observerHandler = rs;
			break;
			case 'requestAnimationFrame':
				var oldw = [], oldh = [];
				(function resizeLoop(instance){
					var neww = [], newh = [];
					var settings = newInstance.settings;
					newInstance.$el.each(function(i, element){
						var $element = $(element);
						neww.push($element.width());
						newh.push($element.height());
					});
					var i = neww.length;
					while(i--){
						if( neww[i] !== oldw[i] || newh[i] !== oldh[i] ){
							oldw = neww;
							oldh = newh;
							newInstance.debouncedResize();
							break;
						}
					}
					newInstance.observerHandler = setRAFTimeout(resizeLoop, settings.debounce);
				})();
			break;
		}

		newInstance.debouncedResize();

		// return instance controller

		return newInstance;

	} // end sameHeight()

	$.fn.sameHeight = sameHeight;

}( jQuery ));
