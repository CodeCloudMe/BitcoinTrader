$(window).load(function(){
	var rec= new alina('recommendation');
	rec.recommend({
		
		productDetection:'selectors', //this vs pre-suff
		productIds:'.productId', //vs products/.../.html
/*

		productDetection:'pre-suff', //this vs pre-suff
		productIds:'product=...&', //vs products/.../.html
*/
		callback:showThem,
		hotspots:{
			"button":[{"action":"click", "rating":4},
					{"action":"hover", "rating":4}],
			".selector":[{"action":"click", "rating":4},
					{"action":"hover", "rating":5}]		
			

		}
	});

})


function showThem(param){
	console.log(param);

}


function alina(type){


	switch (type){
		case "recommendation":
			var recommendation=true;
		break;

		default:
			var recommendation=false;
		break;
	}

	if(!window.jQuery){
		   var script = document.createElement('script');
		   script.type = "text/javascript";
		   script.src = "http://code.jquery.com/jquery-1.11.1.min.js";
		   document.getElementsByTagName('head')[0].appendChild(script);
	}


	this.recommend = function(settings){

		//get productIds
		var productId;

		if(settings.productDetection=="selectors"){
			var selector = settings.productIds;

			$(selector).each(function(){
				productId = $(selector).html();
				$.getJSON('http://alinapi.com/cloud/models/recommend/?callback=?','productId='+productId,
					function(res){
   						 console.log(res)
					});
			})
			
		}
		else{
			var begSearch = settings.productIds.split('...')[0];
			var endSearch = settings.productIds.split('...')[1];
			var pref = window.location.href.split(begSearch)[1];

			productId = pref.split(endSearch)[0];
			
			$.getJSON('http://alinapi.com/cloud/models/recommend/?productId='+productId+'&callback=?',
					function(res){
   						 console.log(res)
					});
		}
		for(i in settings.hotspots){

			//console.log(settings.hotspots[i]);
			for(j in settings.hotspots[i]){

				//set productId to the page's product ID if a productId is not specified in the hotspot
				if(!settings.hotspots[i][j]['productId']){
					settings.hotspots[i][j]['productId'] = productId;
				}

				$(i).on(settings.hotspots[i][j]['action'], settings.hotspots[i][j], function(event){
					
					$.getJSON('http://alina-prod.apigee.net/recommendation?apikey=fbESAOKT4mhobjxXkME5QRySawSkob0V&rating='+event.data['rating']+'&action='+event.data['action']+'&productId='+event.data['productId']+'&callback=?',function(res){
    				
    						console.log(res);
					});

				});
			}
		}

		if(!settings.callback){
			alinaCallback5555=console.log;
		}
		else{
		alinaCallback5555= settings.callback;
		}

		setTimeout(function(){

			$.getJSON('http://alina-prod.apigee.net/recommendation?apikey=fbESAOKT4mhobjxXkME5QRySawSkob0V&productId='+productId+'&callback=?',function(res){
    				
    				alinaCallback5555(res);
			});
		}, 200);
	}


}

