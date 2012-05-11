/**
 *     Fancy Image Show
 *     Copyright (C) 2012  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */	
 
var $j = jQuery.noConflict();
(function($) {
	var opts = new Array;
	var level = new Array;
	var img = new Array;
	var titles = new Array;
	var order = new Array;
	var imgInc = new Array;
	var inc = new Array;
	var stripInt = new Array;
	var imgInt = new Array;	
	
	$j.fn.FancyImageShow = $j.fn.FancyImageShow = function(options){
	
	init = function(el){

		opts[el.id] = $j.extend({}, $j.fn.FancyImageShow.defaults, options);
		img[el.id] = new Array(); // images array
		titles[el.id] = new Array(); // titles array
		order[el.id] = new Array(); // strips order array
		imgInc[el.id] = 0;
		inc[el.id] = 0;

		params = opts[el.id];

		if(params.effect == 'zipper'){ params.direction = 'alternate'; params.position = 'alternate'; }
		if(params.effect == 'wave'){ params.direction = 'alternate'; params.position = 'top'; }
		if(params.effect == 'curtain'){ params.direction = 'alternate'; params.position = 'curtain'; }
		if(params.effect == 'fountain top'){ params.direction = 'fountain'; params.position = 'top'; }
		if(params.effect == 'random top'){ params.direction = 'random'; params.position = 'top'; }

		// width of strips
		stripWidth = parseInt(params.width / params.strips); 
		gap = params.width - stripWidth*params.strips; // number of pixels
		stripLeft = 0;

		// create images and titles arrays
		$j.each($j('#'+el.id+' img'), function(i,item){
			img[el.id][i] = $j(item).attr('src');
			titles[el.id][i] = $j(item).attr('alt') ? $j(item).attr('alt') : '';
			$j(item).hide();
		});

		// set panel
		$j('#'+el.id).css({
			'background-image':'url('+img[el.id][0]+')',
			'width': params.width,
			'height': params.height,
			'position': 'relative',
			'background-position': 'top left'
			});
		$j('#'+el.id).append("<div class='ft-title' id='ft-title-"+el.id+"' style='position: absolute; bottom:0; left: 0; z-index: 1000; color: #fff; background-color: #000; '>"+titles[el.id][0]+"</div>");
	
		if(titles[el.id][imgInc[el.id]])
			$j('#ft-title-'+el.id).css('opacity',opts[el.id].titleOpacity);
		else
			$j('#ft-title-'+el.id).css('opacity',0);

		odd = 1;
		// creating bars
		// and set their position
		for(j=1; j < params.strips+1; j++){
			
			if( gap > 0){
				tstripWidth = stripWidth + 1;
				gap--;
			} else {
				tstripWidth = stripWidth;
			}
				
			$j('#'+el.id).append("<div class='ft-"+el.id+"' id='ft-"+el.id+j+"' style='width:"+tstripWidth+"px; height:"+params.height+"px; float: left; position: absolute;'></div>");

			// positioning bars
			$j("#ft-"+el.id+j).css({ 
				'background-position': -stripLeft +'px top',
				'left' : stripLeft 
			});
			
			stripLeft += tstripWidth;

			if(params.position == 'bottom')
				$j("#ft-"+el.id+j).css( 'bottom', 0 );
				
			if (j%2 == 0 && params.position == 'alternate')
				$j("#ft-"+el.id+j).css( 'bottom', 0 );
	
			// bars order
				// fountain
				if(params.direction == 'fountain' || params.direction == 'fountainAlternate'){ 
					order[el.id][j-1] = parseInt(params.strips/2) - (parseInt(j/2)*odd);
					order[el.id][params.strips-1] = params.strips; // fix for odd number of bars
					odd *= -1;
				} else {
				// linear
					order[el.id][j-1] = j;
				}
	
		}

			$j('.ft-'+el.id).mouseover(function(){
				opts[el.id].pause = true;
			});
		
			$j('.ft-'+el.id).mouseout(function(){
				opts[el.id].pause = false;
			});	
			
			$j('#ft-title-'+el.id).mouseover(function(){
				opts[el.id].pause = true;
			});
		
			$j('#ft-title-'+el.id).mouseout(function(){
				opts[el.id].pause = false;
			});				
		
		clearInterval(imgInt[el.id]);	
		imgInt[el.id] = setInterval(function() { $j.transition(el)  }, params.delay+params.stripDelay*params.strips);

	};

	// transition
	$j.transition = function(el){

		if(opts[el.id].pause == true) return;

		stripInt[el.id] = setInterval(function() { $j.strips(order[el.id][inc[el.id]], el)  },opts[el.id].stripDelay);
		
		$j('#'+el.id).css({ 'background-image': 'url('+img[el.id][imgInc[el.id]]+')' });
		
		imgInc[el.id]++;

		if  (imgInc[el.id] == img[el.id].length) {
			imgInc[el.id] = 0;
		}
		
		if(titles[el.id][imgInc[el.id]]!=''){
			$j('#ft-title-'+el.id).animate({ opacity: 0 }, opts[el.id].titleSpeed, function(){
				$j(this).html(titles[el.id][imgInc[el.id]]).animate({ opacity: opts[el.id].titleOpacity }, opts[el.id].titleSpeed);
			});
		} else {
			$j('#ft-title-'+el.id).animate({ opacity: 0}, opts[el.id].titleSpeed);
		}
		
		inc[el.id] = 0;

		if(opts[el.id].direction == 'random')
			$j.fisherYates (order[el.id]);
			
		if((opts[el.id].direction == 'right' && order[el.id][0] == 1) 
			|| opts[el.id].direction == 'alternate'
			|| opts[el.id].direction == 'fountainAlternate')			
				order[el.id].reverse();		
	};


	// strips animations
	$j.strips = function(itemId, el){

		temp = opts[el.id].strips;
		if (inc[el.id] == temp) {
			clearInterval(stripInt[el.id]);
			return;
		}
		
		if(opts[el.id].position == 'curtain'){
			currWidth = $j('#ft-'+el.id+itemId).width();
			$j('#ft-'+el.id+itemId).css({ width: 0, opacity: 0, 'background-image': 'url('+img[el.id][imgInc[el.id]]+')' });
			$j('#ft-'+el.id+itemId).animate({ width: currWidth, opacity: 1 }, 1000);
		} else {
			$j('#ft-'+el.id+itemId).css({ height: 0, opacity: 0, 'background-image': 'url('+img[el.id][imgInc[el.id]]+')' });
			$j('#ft-'+el.id+itemId).animate({ height: opts[el.id].height, opacity: 1 }, 1000);
		}
		
		inc[el.id]++;
		
	};

	// shuffle array function
	$j.fisherYates = function(arr) {
	  var i = arr.length;
	  if ( i == 0 ) return false;
	  while ( --i ) {
	     var j = Math.floor( Math.random() * ( i + 1 ) );
	     var tempi = arr[i];
	     var tempj = arr[j];
	     arr[i] = tempj;
	     arr[j] = tempi;
	   }
	}	
		
	this.each (
		function(){ init(this); }
	);
		
};

	// default values
	$j.fn.FancyImageShow.defaults = {	
		width: 500, // width of panel
		height: 332, // height of panel
		strips: 20, // number of strips
		delay: 5000, // delay between images in ms
		stripDelay: 50, // delay beetwen strips in ms
		titleOpacity: 0.7, // opacity of title
		titleSpeed: 1000, // speed of title appereance in ms
		position: 'alternate', // top, bottom, alternate, curtain
		direction: 'fountainAlternate', // left, right, alternate, random, fountain, fountainAlternate
		effect: '' // curtain, zipper, wave		
	};
	
})(jQuery);