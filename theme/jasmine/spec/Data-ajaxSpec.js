
describe("when it is initialzied with an options parameter",function(){
		
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



describe("an ajax call",function(){

	beforeEach(function(){

		spy = sinon.spy($, "ajax");
		
	});
	
	afterEach(function(){
		$.ajax.restore();
	});

it("should have been made",function(){

	this.Data.start(this.options);
	console.log(spy.returnValues[0]);
	expect(spy).toHaveBeenCalled();
});

it("should be called once when given one request ",function(){

	this.Data.start({url:"test"
																				,requests: [{
																					'command':'get_posts'
																					,'custom_fields':'test_field'
																					}]
																			})
																			;
	expect(spy).toHaveBeenCalledOnce();
	
});

it("should be called twice when given two requests",function(){

	this.Data.start({url:"test"
																				,requests: [{
																					'command':'get_posts'
																					,'custom_fields':'test_field'
																					}
																					,{
																					'command':'get_posts'
																					,'custom_fields':'test_field'
																					}]
																			});
																			
	expect(spy).toHaveBeenCalledTwice();
	
});
	
it("should be  based on the options sent to it",function(){
		
		this.Data.start(this.options);
		expect(spy.getCall(0).args[0].url).toEqual("http://localhost/?json=get_posts&custom_fields=test_field");
});

		xit("should create a collection for each request in the options list",function(){

			this.Data.start(this.options);
			expect(this.Data.Page_collections.length).toEqual(this.options.requests.length);
	});

});



		xit("should trigger the callback when the ajax call returns",function(){
	});
	
});
