Fx.Height = Fx.Style.extend({initialize: function(el, options){$(el).setStyle('overflow', 'hidden');this.parent(el, 'height', options);},toggle: function(){var style = this.element.getStyle('height').toInt();return (style > 0) ? this.start(style, 0) : this.start(0, this.element.scrollHeight);},show: function(){return this.set(this.element.scrollHeight);}});Fx.Opacity = Fx.Style.extend({initialize: function(el, options){this.now = 1;this.parent(el, 'opacity', options);},toggle: function(){return (this.now > 0) ? this.start(1, 0) : this.start(0, 1);},show: function(){return this.set(1);}});

window.addEvent("load",function(){
	$$(".gk_news_image_1_wrapper").each(function(el){
		var elID = el.getProperty("id");
		var wrapper = $(elID);
		var $G = $Gavick[elID];
		var animation_slide_speed = $G['anim_speed'];
		var animation_interval = $G['anim_interval'];
		var autoanimation = $G['autoanim'];
		var animation_slide_type = $G['anim_type'];
		var animation_text_type = $G['anim_type_t'];
		var thumbnail_width = $G['thumbnail_width'];
		var thumbnail_margin = $G['thumbnail_margin'];
		var thumbnail_border = $G['thumbnail_border'];
		var thumbnail_border_color = $G['thumbnail_border_color'];
		var thumbnail_border_color_inactive = $G['thumbnail_border_color_inactive'];
		var base_bgcolor = $G['bgcolor'];
		var base_opacity = $G['opacity'];
		var slides = [];
		var contents = [];
		var loadedImages = ($E('.gk_news_image_1_preloader', wrapper)) ? false : true;
	
		if($E('.gk_news_image_1_preloader', wrapper)){
			var imagesToLoad = [];
			
			$ES('.gk_news_image_1_slide',wrapper).each(function(el,i){
				var newImg = new Element('img',{
					"src":el.innerHTML,
					"alt":el.getProperty('title'),
					"class":el.getProperty('class'),
					"style":el.getProperty('style')
				});
				imagesToLoad.push(newImg);
				newImg.injectAfter(el);
				el.remove();
			});
			
			var timerrr = (function(){
				var process = 0;				
				imagesToLoad.each(function(el,i){
					if(el.complete) process++;
 				});
 				
				if(process == imagesToLoad.length){
					$clear(timerrr);
					loadedImages = process;
					(function(){new Fx.Opacity($E('.gk_news_image_1_preloader', wrapper)).start(1,0);}).delay(400);
				}
			}).periodical(200);
		}
		
		var timerrr2 = (function(){
		if(loadedImages){
		$clear(timerrr2);
		// ----------	
		if(window.ie){
			if($E(".gk_news_image_1_text_bg", wrapper)) $E(".gk_news_image_1_text_bg",wrapper).setOpacity(base_opacity.toFloat());
		}
		
		wrapper.getElementsBySelector(".gk_news_image_1_slide").each(function(elmt,i){
			slides[i] = elmt;
			if($G['clickable_slides'] == 1){
				elmt.addEvent("click", function(){window.location = elmt.getProperty('alt');});
				elmt.setStyle("cursor", "pointer");
			}
		});
		
		slides.each(function(el,i){if(i != 0) el.setOpacity(0);});
		
		var ticks_array = [];
		
		if($E('.gk_news_image_1_tick_buttons', wrapper)){
			$ES('.tick', wrapper).each(function(el,x){
				ticks_array[x] = el;
				
				el.addEvent("click",function(){
					gk_news_image_1_anim2(thumbs_array,elID,wrapper,slides,contents,animation_slide_speed,x,animation_text_type,animation_slide_type, $G, ticks_array);
				});
			});
			
			ticks_array[0].setProperty("src", (ticks_array[0].getProperty("src")).replace('tick.png', 'tick_active.png'));
		}
		
		if(wrapper.getElementsBySelector(".gk_news_image_1_text_bg").length > 0){
			var text_block = wrapper.getElementsBySelector(".gk_news_image_1_text_bg")[0];
			wrapper.getElementsBySelector(".gk_news_image_1_news_text").each(function(elmt,i){contents[i] = elmt.innerHTML;});
		
			if($E('.gk_news_image_1_tb',wrapper)){
				var thmb_bar = $E('.gk_news_image_1_tb',wrapper);
				var prev = $E('.gk_news_image_1_tb_prev',thmb_bar.getParent());
				var next = $E('.gk_news_image_1_tb_next',thmb_bar.getParent());
				var thumbs_array = $ES('.gk_news_image_1_thumb',thmb_bar);
				
				var actual_thumb = 0;
				thumbs_array[0].setStyles({"border": thumbnail_border + "px solid " + thumbnail_border_color});
				
				thumbs_array.each(function(el,i){
					el.addEvent("click",function(){
						gk_news_image_1_anim2(thumbs_array,elID,wrapper,slides,contents,animation_slide_speed,i,animation_text_type,animation_slide_type, $G, ticks_array);
					});
				});
				
				if( (thumbs_array.length * (thumbnail_width+(2*thumbnail_margin)+(2*thumbnail_border))) < text_block.getSize().size.x){
					prev.setStyle("display","none");
					next.setStyle("display","none");
					thmb_bar.setStyle("width", text_block.getSize().size.x+"px");
				}else{
					var visible_thmb = Math.floor((thmb_bar.getStyle("width").toInt()-(2*thumbnail_margin)) / (thumbnail_width+(2*thumbnail_margin)+(2*thumbnail_border))) - 1;
					var thmb_slider = new Fx.Scroll(thmb_bar,{transition: Fx.Transitions.linear,duration: 50});
					var timer_left, timer_right;
					var position = 0;
				
					prev.addEvent("mouseenter",function(){
						if(position > 0){
							timer_left = (function(){
								if(position > 0){
									position-=5;
									thmb_slider.scrollTo(position,0);
								}else{
									$clear(timer_left);
									position = 0;
									thmb_slider.toLeft();
								}
							}).periodical(50);
						}
					});
					
					next.addEvent("mouseenter",function(){
						var xsize = $E(".gk_news_image_1_tbo",thmb_bar).getSize().size.x;
						if(position < xsize){
							timer_right = (function(){
								if(position < xsize){
									position+=5;
									thmb_slider.scrollTo(position,0);
								}else{
									$clear(timer_right);
									position = xsize;
									thmb_slider.toRight();
								}
							}).periodical(50);
						}
					});
					
					prev.addEvent("mouseout",function(){$clear(timer_left);$clear(timer_right);});
					next.addEvent("mouseout",function(){$clear(timer_right);$clear(timer_left);});
				}
				
				thumbs_array.each(function(el,i){
					el.addEvent("click",function(){
						thumbs_array.each(function(elmt){elmt.setStyle("border", thumbnail_border + "px solid " + thumbnail_border_color_inactive);});
						el.setStyle("border", thumbnail_border + "px solid " + thumbnail_border_color);
					});
				});
			}
		}
		
	
		if($E('.gk_news_image_1_interface_buttons',wrapper)){
			var Interface = $E('.gk_news_image_1_interface_buttons',wrapper);
			Interface.setStyles({
				"left" : wrapper.getSize().size.x - (Interface.getSize().size.x+$G['interface_x']),
				"top" : wrapper.getSize().size.y - (Interface.getSize().size.y+$G['interface_y'])
			});
		}
		
		if($E(".gk_news_image_1_prev", wrapper)){
			$E(".gk_news_image_1_prev", wrapper).addEvent("click",function(e){
				var event = new Event(e);event.preventDefault();
				gk_news_image_1_anim2(thumbs_array,elID,wrapper,slides,contents,animation_slide_speed,(($G['actual_slide'] > 0) ? $G['actual_slide']-1 : slides.length-1),animation_text_type,animation_slide_type, $G, ticks_array);
			});
		}
		
		if($E(".gk_news_image_1_next", wrapper)){
			$E(".gk_news_image_1_next", wrapper).addEvent("click",function(e){
				var event = new Event(e);event.preventDefault();
				gk_news_image_1_anim2(thumbs_array,elID,wrapper,slides,contents,animation_slide_speed,(($G['actual_slide'] < slides.length-1) ? $G['actual_slide']+1 : 0),animation_text_type,animation_slide_type, $G, ticks_array);
			});
		}
		
		if($E(".gk_news_image_1_play", wrapper)){
			$E(".gk_news_image_1_play", wrapper).addEvent("click",function(e){
				var event = new Event(e);event.preventDefault();
				gk_news_image_1_anim(wrapper,slides,contents,thumbs_array,elID,animation_interval,animation_slide_speed,"right",true,animation_text_type,animation_slide_type, $G, ticks_array);
				$E(".gk_news_image_1_play", wrapper).setStyle("display","none");
				$E(".gk_news_image_1_pause", wrapper).setStyle("display","block");
			});
		}
		
		if($E(".gk_news_image_1_pause", wrapper)){
			$E(".gk_news_image_1_pause", wrapper).addEvent("click",function(e){
				var event = new Event(e);event.preventDefault();
				gk_news_image_1_pause(elID, $G);
			});
		}
		
		var amount_c = contents.length-1;
		$G['actual_slide'] = 0;
		
		if(wrapper.getElementsBySelector(".gk_news_image_1_text")[0]) wrapper.getElementsBySelector(".gk_news_image_1_text")[0].innerHTML = contents[0];
		
		if(autoanimation == 1){
			gk_news_image_1_anim(wrapper,slides,contents,thumbs_array,elID,animation_interval,animation_slide_speed,"right",true,animation_text_type,animation_slide_type, $G, ticks_array);
			if($E(".gk_news_image_1_play", wrapper)) $E(".gk_news_image_1_play", wrapper).setStyle("display","none");
		}else{
			if($E(".gk_news_image_1_pause", wrapper)) $E(".gk_news_image_1_pause", wrapper).setStyle("display","none");
		}
		// ----------
		}}).periodical(250);
	});
});

function gk_news_image_1_text_anim(wrapper,contents,as,type,ass){
	var txt = wrapper.getElementsBySelector(".gk_news_image_1_text")[0];
	if(txt){
		if(type == 0){	
			new Fx.Opacity(txt,{duration: ass/2}).start(1,0);
			(function(){new Fx.Opacity(txt,{duration: ass/2}).start(0,1);txt.innerHTML = contents[as];}).delay(ass);
		}else txt.innerHTML = contents[as];
	}
}

function gk_news_image_1_anim(wrapper,slides,contents,thumbs_array,elID,ai,ass,direct,play,type,animation_slide_type, $G, ticks_array){
	var max = slides.length-1;
	
	if(!$G['actual_animation']){
		$G['actual_animation'] = (function(){
			if(direct == "left") var actual_slide2 = ($G['actual_slide'] == 0) ? 0 : $G['actual_slide'];
			if(direct == "right") var actual_slide2 = ($G['actual_slide'] == max) ? max : $G['actual_slide'];
			if(direct == "left") ($G['actual_slide'] == 0) ? $G['actual_slide'] = max : $G['actual_slide'] -= 1;
			if(direct == "right") ($G['actual_slide'] == max) ? $G['actual_slide'] = 0 : $G['actual_slide'] += 1;
			slides[$G['actual_slide']].setStyle("z-index",max+1);
		
			new Fx.Opacity(slides[actual_slide2],{duration: ass}).start(1,0);
			$G['actual_animation_p'] = true;
			new Fx.Opacity(slides[$G['actual_slide']],{duration: ass}).start(0,1);
			gk_news_image_1_text_anim(wrapper,contents,$G['actual_slide'],type,ass);	
				
			switch(animation_slide_type){
				case 0: break;
				case 1: new Fx.Style(slides[$G['actual_slide']],'margin-top',{duration: ass}).start((-1)*slides[$G['actual_slide']].getSize().size.y,0);break;
				case 2: new Fx.Style(slides[$G['actual_slide']],'margin-left',{duration: ass}).start((-1)*slides[$G['actual_slide']].getSize().size.x,0);break;
				case 3: new Fx.Style(slides[$G['actual_slide']],'margin-top',{duration: ass}).start(slides[$G['actual_slide']].getSize().size.y,0);break;
				case 4: new Fx.Style(slides[$G['actual_slide']],'margin-left',{duration: ass}).start(slides[$G['actual_slide']].getSize().size.x,0);break;
			}
				
			if(thumbs_array) thumbs_array[actual_slide2].setStyles({"border": $G['thumbnail_border'] + "px solid " + $G['thumbnail_border_color_inactive']});	
			if(thumbs_array) thumbs_array[$G['actual_slide']].setStyles({"border": $G['thumbnail_border'] + "px solid " + $G['thumbnail_border_color']});	
				
			if(ticks_array.length > 0) ticks_array[actual_slide2].setProperty("src", (ticks_array[actual_slide2].getProperty("src")).replace('tick_active.png', 'tick.png'));	
		if(ticks_array.length > 0) ticks_array[$G['actual_slide']].setProperty("src", (ticks_array[$G['actual_slide']].getProperty("src")).replace('tick.png', 'tick_active.png'));
				
			(function(){slides[$G['actual_slide']].setStyle("z-index",$G['actual_slide']);}).delay(ass);
			(function(){$G['actual_animation_p'] = false;}).delay(ass);
		}).periodical(ass+ai);
		(function(){if(!play) gk_news_image_1_pause(elID, $G);}).delay(ass+ai);
	}
}

function gk_news_image_1_anim2(thumbs_array,elID,wrapper,slides,contents,ass,direct,type,animation_slide_type, $G, ticks_array){
	var max = slides.length-1;
	
	if(!$G['actual_animation_p'] && direct != $G['actual_slide']){
		var actual_slide2 = $G['actual_slide'];
		$G['actual_slide'] = direct;
		slides[$G['actual_slide']].setStyle("z-index",max+1);
		
		new Fx.Opacity(slides[actual_slide2],{duration: ass}).start(1,0);
		$G['actual_animation_p'] = true;
		new Fx.Opacity(slides[$G['actual_slide']],{duration: ass}).start(0,1);
		gk_news_image_1_text_anim(wrapper,contents,$G['actual_slide'],type,ass);	
				
		switch(animation_slide_type){
			case 0: break;
			case 1: new Fx.Style(slides[$G['actual_slide']],'margin-top',{duration: ass}).start((-1)*slides[$G['actual_slide']].getSize().size.y,0);break;
			case 2: new Fx.Style(slides[$G['actual_slide']],'margin-left',{duration: ass}).start((-1)*slides[$G['actual_slide']].getSize().size.x,0);break;
			case 3: new Fx.Style(slides[$G['actual_slide']],'margin-top',{duration: ass}).start(slides[$G['actual_slide']].getSize().size.y,0);break;
			case 4: new Fx.Style(slides[$G['actual_slide']],'margin-left',{duration: ass}).start(slides[$G['actual_slide']].getSize().size.x,0);break;
		}
				
		if(thumbs_array) thumbs_array[actual_slide2].setStyles({"border": $G['thumbnail_border'] + "px solid " + $G['thumbnail_border_color_inactive']});	
		if(thumbs_array) thumbs_array[$G['actual_slide']].setStyles({"border": $G['thumbnail_border'] + "px solid " + $G['thumbnail_border_color']});
			
		if(ticks_array.length > 0) ticks_array[actual_slide2].setProperty("src", (ticks_array[actual_slide2].getProperty("src")).replace('tick_active.png', 'tick.png'));	
		if(ticks_array.length > 0) ticks_array[$G['actual_slide']].setProperty("src", (ticks_array[$G['actual_slide']].getProperty("src")).replace('tick.png', 'tick_active.png'));
		
		(function(){slides[$G['actual_slide']].setStyle("z-index",$G['actual_slide']);}).delay(ass);
		(function(){$G['actual_animation_p'] = false;}).delay(ass);
		
		gk_news_image_1_pause(elID, $G);
	}
}

function gk_news_image_1_pause(elID, $G){
	var wrapper = $(elID);
	$clear($G['actual_animation']);$G['actual_animation'] = false;
	if($E(".gk_news_image_1_play", wrapper)) $E(".gk_news_image_1_play", wrapper).setStyle("display","block");
	if($E(".gk_news_image_1_pause", wrapper))$E(".gk_news_image_1_pause", wrapper).setStyle("display","none");
}