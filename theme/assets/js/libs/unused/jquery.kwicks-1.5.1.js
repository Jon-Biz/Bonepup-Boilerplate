/*
	Kwicks for jQuery (version 1.5.1)
	Copyright (c) 2008 Jeremy Martin
	http://www.jeremymartin.name/projects.php?project=kwicks
	
	Licensed under the MIT license:
		http://www.opensource.org/licenses/mit-license.php

	Any and all use of this script must be accompanied by this copyright/license notice in its present form.
*/

(function($){
	$.fn.kwicks = function(options) {
		var defaults = {
			isVertical: false,
			sticky: false,
			defaultKwick: 0,
			event: 'mouseover',
			spacing: 0,
			duration: 500,
			max: 100,
			min: 20,
			spacing: 5
		};
		var o = $.extend(defaults, options);
		var WoH = (o.isVertical ? 'height' : 'width'); // WoH = Width or Height
		var LoT = (o.isVertical ? 'top' : 'left'); // LoT = Left or Top
		
		return this.each(function() {

			//set this to whatever is being kwicked
			container = $(this);

			// create a convenience reference to the children of the kwick container
			var kwicks = container.children('li');

			// grab the first child's stretchable size as the baseline normWoH
			// REMOVED
			//var normWoH = kwicks.eq(0).css(WoH).replace(/px/,''); // normWoH = Normal Width or Height
			
			// 
			var normWoH = (o.isVertical ? 40 : 35);
			
			console.log("normal width or height", normWoH);
			// if there is no defined max Woh, define it as the norm * number of kwicks, - 
			if(!o.max) {
				o.max = (normWoH * kwicks.size()) - (o.min * (kwicks.size() - 1));
			} else {
				o.min = ((normWoH * kwicks.size()) - o.max) / (kwicks.size() - 1);
			}
			// set width of container ul
			// if it's a vertical one, set the width to the first child's width, set height to the normal * number of kwicks, plus the spacing between them.
			// if horizontal, do the equivalent.
			
			if(o.isVertical) {
				container.css({
					width : kwicks.eq(0).css('width'),
					height : (normWoH * kwicks.size()) + (o.spacing * (kwicks.size() - 1)) + 'px'
				});				
			} else {
				container.css({
					width : (normWoH * kwicks.size()) + (o.spacing * (kwicks.size() - 1)) + 'px',
					height : kwicks.eq(0).css('height')
				});				
			}

			// pre calculate left or top values for all kwicks but the first and last
			// i = index of currently hovered kwick, j = index of kwick we're calculating

			var preCalcLoTs = []; // preCalcLoTs = pre-calculated Left or Top's

			for(i = 0; i < kwicks.size(); i++) {
				preCalcLoTs[i] = [];
				// don't need to calculate values for first or last kwick
				for(j = 1; j < kwicks.size() - 1; j++) {
					if(i == j) {
						preCalcLoTs[i][j] = o.isVertical ? j * o.min + (j * o.spacing) : j * o.min + (j * o.spacing);
					} else {
						preCalcLoTs[i][j] = (j <= i ? (j * o.min) : (j-1) * o.min + o.max) + (j * o.spacing);
					}
				}
			}
			
			// loop through all kwick elements
			kwicks.each(function(i) {
				
				
				var kwick = $(this);
				
				// unbind event before calculations
				// TODO specify called function here. Otherwise, all handlers are removed, may cause problems
				
				kwick.unbind(o.event);
				
				// set initial width or height and left or top values
				// set first kwick
				if(i === 0) {
					kwick.css(LoT, '0px');
				} 
				// set last kwick
				else if(i == kwicks.size() - 1) {
					kwick.css(o.isVertical ? 'bottom' : 'right', '0px');
				}
				// set all other kwicks
				else {
					if(o.sticky) {
						kwick.css(LoT, preCalcLoTs[o.defaultKwick][i]);
					} else {
						kwick.css(LoT, (i * normWoH) + (i * o.spacing));
						console.log("kwick.css",LoT, (i * normWoH) + (i * o.spacing));
					}
				}
				// correct size in sticky mode
				if(o.sticky) {
					if(o.defaultKwick == i) {
						kwick.css(WoH, o.max + 'px');
						kwick.addClass('active');
					} else {
						kwick.css(WoH, o.min + 'px');
					}
				}
				kwick.css({
					margin: 0,
					position: 'absolute'
				});
				
				var kwickhandler = function(){
					
					// calculate previous width or heights and left or top values
					var prevWoHs = []; // prevWoHs = previous Widths or Heights
					var prevLoTs = []; // prevLoTs = previous Left or Tops
					
					kwicks.stop().removeClass('active');
					
					for(j = 0; j < kwicks.size(); j++) {
						prevWoHs[j] = kwicks.eq(j).css(WoH).replace(/px/, '');
						prevLoTs[j] = kwicks.eq(j).css(LoT).replace(/px/, '');
					}
					
					var aniObj = {};
					aniObj[WoH] = o.max;
					var maxDif = o.max - prevWoHs[i];
					var prevWoHsMaxDifRatio = prevWoHs[i]/maxDif;
					kwick.addClass('active').animate(aniObj, {
						step: function(now) {
							// calculate animation completeness as percentage
							var percentage = maxDif != 0 ? now/maxDif - prevWoHsMaxDifRatio : 1;
							// adjsut other elements based on percentage
							kwicks.each(function(j) {
								if(j != i) {
									kwicks.eq(j).css(WoH, prevWoHs[j] - ((prevWoHs[j] - o.min) * percentage) + 'px');
								}
								if(j > 0 && j < kwicks.size() - 1) { // if not the first or last kwick
									kwicks.eq(j).css(LoT, prevLoTs[j] - ((prevLoTs[j] - preCalcLoTs[i][j]) * percentage) + 'px');
								}
							});
						},
						duration: o.duration,
						easing: o.easing
					});
				};
					
				kwick.bind(o.event, function(){
					kwickhandler();
				});
				

			});
			
			// if the card stays sized when leaving with the mouse
			if(!o.sticky) {
				container.bind("mouseleave", function() {
					var prevWoHs = [];
					var prevLoTs = [];
					kwicks.removeClass('active').stop();
					for(i = 0; i < kwicks.size(); i++) {
						prevWoHs[i] = kwicks.eq(i).css(WoH).replace(/px/, '');
						prevLoTs[i] = kwicks.eq(i).css(LoT).replace(/px/, '');
					}
					var aniObj = {};
					aniObj[WoH] = normWoH;
					var normDif = normWoH - prevWoHs[0];
					kwicks.eq(0).animate(aniObj, {
						step: function(now) {
							var percentage = normDif != 0 ? (now - prevWoHs[0])/normDif : 1;
							for(i = 1; i < kwicks.size(); i++) {
								kwicks.eq(i).css(WoH, prevWoHs[i] - ((prevWoHs[i] - normWoH) * percentage) + 'px');
								if(i < kwicks.size() - 1) {
									kwicks.eq(i).css(LoT, prevLoTs[i] - ((prevLoTs[i] - ((i * normWoH) + (i * o.spacing))) * percentage) + 'px');
								}
							}
						},
						duration: o.duration,
						easing: o.easing
					});
				});
			}
		});
	};	
	
})(jQuery);