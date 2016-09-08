Fx.Height = Fx.Style.extend({initialize: function(el, options){$(el).setStyle('overflow', 'hidden');this.parent(el, 'height', options);},toggle: function(){var style = this.element.getStyle('height').toInt();return (style > 0) ? this.start(style, 0) : this.start(0, this.element.scrollHeight);},show: function(){return this.set(this.element.scrollHeight);}});Fx.Opacity = Fx.Style.extend({initialize: function(el, options){this.now = 1;this.parent(el, 'opacity', options);},toggle: function(){return (this.now > 0) ? this.start(1, 0) : this.start(0, 1);},show: function(){return this.set(1);}});
//
window.addEvent("load",function(){
	$ES(".gk_news_image_3_wrapper").each(function(el){
		// generowanie rdzenia
		var wrap = el;
		var elID = el.getParent().getProperty("id");
		var $G = $Gavick[elID]; 
		var wrap = $(elID);
		$G["actual_slide"] = -1;
		$G["actual_anim"] = false;
		$G["actual_anim_p"] = false;
		var slides = [];
		var contents = [];
		if(window.ie){
			if($E(".gk_news_image_3_text_bg", wrap)) $E(".gk_news_image_3_text_bg",wrap).setOpacity($G["opacity"].toFloat());
		}
		wrap.getElementsBySelector(".gk_news_image_3_slide").each(function(elmt,i){slides[i] = elmt;});
		slides.each(function(el,i){if(i != 0) el.setOpacity(0);});
		//
		if($E(".gk_news_image_3_text_bg",wrap)){
			var text_block = $E(".gk_news_image_3_text_bg",wrap);
			$ES(".gk_news_image_3_news_text",wrap).each(function(el,i){contents[i] = el.innerHTML;});
		}
		// animacje
		var amount_c = contents.length-1;
		if($E(".gk_news_image_3_text",wrap)) $E(".gk_news_image_3_text",wrap).innerHTML = contents[0];
		//
		var loadedImages = ($E('.gk_news_image_3_preloader', wrap)) ? false : true;
	
		if($E('.gk_news_image_3_preloader', wrap)){
			var imagesToLoad = [];
			
			$ES('.gk_news_image_3_slide',wrap).each(function(el,i){
				var newImg = new Element('img',{
					"src":el.innerHTML,
					"alt":el.getProperty('title')
				});
				imagesToLoad.push(newImg);
				el.innerHTML = '';
				newImg.injectInside(el);
			});
			
			var timerrr = (function(){
				var process = 0;				
				imagesToLoad.each(function(el,i){
					if(el.complete) process++;
 				});
 				
				if(process == imagesToLoad.length){
					$clear(timerrr);
					loadedImages = process;
					(function(){new Fx.Opacity($E('.gk_news_image_3_preloader', wrap)).start(1,0);}).delay(400);
				}
			}).periodical(200);
		}
		
		var timerrr2 = (function(){
		if(loadedImages){
		$clear(timerrr2);
		//
		$ES('.gk_news_image_3_slide',wrap).each(function(el,i){
			el.addEvent("click", function(e){
				new Event(e).stop();
				if(el.title) window.location.href = el.title;
			});
		});
		// ----------	
		var NI3 = new news_image_3();
		//
		$ES(".gk_news_image_3_tab",wrap).each(function(elx,index){
			elx.addEvent("click",function(){
				if(!$G["actual_anim_p"]){
					$E(".gk_news_image_3_tab_active",wrap).setProperty("class","gk_news_image_3_tab TipsGK");
					elx.setProperty("class","gk_news_image_3_tab_active TipsGK");
				}
				//
				NI3.image_anim(elID,wrap,wrap,slides,index,contents,$G,false);
			});
			//
			if(window.ie) elx.removeProperty('alt');
		});
		//
		$E(".gk_news_image_3_tab",wrap).setProperty("class","gk_news_image_3_tab_active TipsGK");
		NI3.image_anim(elID,wrap,wrap,slides,0,contents,$G,($G["autoanim"]==1));
		//
		if(($G["tooltips"] == 1) && ($G["tooltips_anim"] == 1) && $$('.tool-tip').length == 0){
	        //
			new Tips($$('.TipsGK'), {
				initialize:function(){
					this.fx = new Fx.Style(this.toolTip, 'opacity', {duration: 500, wait: false}).set(0);
				},
				onShow: function(toolTip) {
					this.fx.start(1);
				},
				onHide: function(toolTip) {
					this.fx.start(0);
				}
			});
		
		}
		else{
			if(($G["tooltips"] == 1) && ($G["tooltips_anim"] == 0) && $$('.tool-tip').length == 0){
				new Tips($$('.TipsGK'));
			}
		}
		
		
		
		}}).periodical(250);
		
		
	});
});
//
var news_image_3 = new Class({
    //
	text_anim : function(wrap,contents,$G){
		var txt = $E(".gk_news_image_3_text",wrap);
		if(txt){
			if($G["anim_type_t"] == 0){	
				new Fx.Opacity(txt,{duration: $G["anim_speed"]/2}).start(1,0);
				(function(){
					new Fx.Opacity(txt,{duration: $G["anim_speed"]/2}).start(0,1);txt.innerHTML = contents[$G["actual_slide"]];
				}).delay($G["anim_speed"]);
			}	
			else{ 
				txt.innerHTML = contents[$G["actual_slide"]];
			}
		}
	},
    //
	image_anim : function(elID,wrap,wrap,slides,n,contents,$G,play){
		var max = slides.length-1;
	    //
		if(!$G["actual_anim_p"] && n != $G["actual_slide"]){
			$G["actual_anim_p"] = true;
			//
			var actual_slide = $G["actual_slide"];
			$G["actual_slide"] = n;
			slides[n].setStyle("z-index",max+1);
		    //
			if(actual_slide != -1) new Fx.Opacity(slides[actual_slide],{duration: $G["anim_speed"]}).start(1,0);
			new Fx.Opacity(slides[n],{duration: $G["anim_speed"]}).start(0,1);
			this.text_anim(wrap,contents,$G);	
			//	
			switch($G["anim_type"]){
				case 0: break;
				case 1: new Fx.Style(slides[n],'margin-top',{duration: $G["anim_speed"]}).start((-1)*slides[n].getSize().size.y,0);break;
				case 2: new Fx.Style(slides[n],'margin-left',{duration: $G["anim_speed"]}).start((-1)*slides[n].getSize().size.x,0);break;
				case 3: new Fx.Style(slides[n],'margin-top',{duration: $G["anim_speed"]}).start(slides[n].getSize().size.y,0);break;
				case 4: new Fx.Style(slides[n],'margin-left',{duration: $G["anim_speed"]}).start(slides[n].getSize().size.x,0);break;
			}
			//
			if(play){
				$E(".gk_news_image_3_tab_active",wrap).setProperty("class","gk_news_image_3_tab TipsGK");
				$ES(".gk_news_image_3_tab",wrap)[n].setProperty("class","gk_news_image_3_tab_active TipsGK");
			}
		     //
			(function(){slides[n].setStyle("z-index",n);}).delay($G["anim_speed"]);
			(function(){$G["actual_anim_p"] = false;}).delay($G["anim_speed"]);
			//
			var $this = this;
			//
			if(!play) this.image_pause($G);
			if((play || $G["autoanim"] == 1) && ($G["actual_anim"] == false)){
				$G["actual_anim"] = (function(){
					n = (n < max) ? n+1 : 0;
					$this.image_anim(elID,wrap,wrap,slides,n,contents,$G,true);
				}).periodical($G["anim_speed"]*2+$G["anim_interval"]);
			}
		}
	},
    //
	image_pause : function($G){
		$clear($G["actual_anim"]);
		$G["actual_anim"] = false;
	}
});