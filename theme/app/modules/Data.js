App.module("Data",function(Data){
		// Data.ready callback signals that the page collection has been retrieved
	Data.ready = new Backbone.Marionette.Callbacks();
	
	Data.on("before:start", function(options){ 

		// make options available, or use default
		options = options || {};
		options.url = options.url || "http://localhost";
		options.requests = options.requests || [{'command':'get_page_index','custom_fields':''}];
		Data.options = options;

	});

	Data.addInitializer(function(){
		
		Data.Page_collections = [];
		
		_.each(Data.options.requests,function(request){
			var WP_Item = new Backbone.Collection();
			var Options = Data.options;
			
			WP_Item.url = Options.url + "/?json="+request.command+"&custom_fields="+request.custom_fields;
			WP_Item.fetch({success: function(collection,resp){
			console.log('collection fetched', resp)
			}}).done(function(){
				
				Data.Page_collections.push(WP_Item);
			
				//trigger callback because all data is ready

				Data.ready.run();

			});
			
			
	
		});
	});
	
	
	Data.images_load = function(collection_model,image_size){		

		var gallery = collection_model.get('children'),
			checklist = gallery.length,
			images_loaded_cb = new Backbone.Marionette.Callbacks();

		gallery.each(function(model){
			console.log('up first....',model.get('title'));
			Data.image_load(model,image_size).add(function(){
				checklist --;
			 	if (checklist == 0) {images_loaded_cb.run();} ;
			});
		});
				
		return images_loaded_cb;;
	};

	Data.image_load= function(model,image_size,dom){

		var image_loaded_cb = new Backbone.Marionette.Callbacks(),
			latest = model.get("attachments").length-1,
			image_url = model.get('attachments')[latest].images[image_size].url,
			dom = dom || $('<img>');
			
		dom.attr({ src: image_url })
			.load(function() {
				console.log('image callback called')
				image_loaded_cb.run();
			});	
			
		return image_loaded_cb;
	};	
});
