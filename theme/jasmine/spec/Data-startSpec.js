


	describe("When the Data Module is started",function(){
		
		beforeEach(function(){
			
			this.Data = App.module("Data");
			
		});
	
		afterEach(function(){
			 this.Data.stop();
		});
		
		it("should create a callback called App.Data.Ready",function(){

			var callbackwatcher = sinon.spy();
			this.Data.ready.add(function(){
				callbackwatcher();
			})

			this.Data.start();
			 this.Data.ready.run()
			
			expect(callbackwatcher).toHaveBeenCalled();

		});

	it("should use the default options since none are stated",function(){
		
		var options = {
			'url':'http://localhost'
			,'requests':[
				{'command':'get_page_index'
				,'custom_fields':''}
				]
		}

		this.Data.start();
		
		expect (this.Data.options).toEqual(options);

	})

});


describe("when the Data Model is initialzied with an options parameter",function(){
		
	beforeEach(function(){

		this.options = {
			url:"http://localhost"
			,requests: [{'command':'get_posts','custom_fields':'test_field'}]
		}
		
		this.Data = App.module("Data");

	});

	afterEach(function(){
		 this.Data.stop();
	});	

	it("should set  its options variable to those received",function(){
	
			this.Data.start(this.options);
		
		expect(this.Data.options).toEqual(this.options);
		
	});
});
