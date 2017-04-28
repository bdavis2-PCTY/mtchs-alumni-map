var _Spinner = function(spinnerObject){
	this.SpinnerObject = spinnerObject;
	this.count = 0;
	
	this.up = function(){
		this.count++;
		console.log(this.SpinnerObject);
		
		if ( this.count > 0 ) 
			this.SpinnerObject.show();
		
		//this.printCount();
	}
	
	this.down = function(){
		this.count--;

		if ( this.count < 0 )
			this.count = 0;
		
		if ( this.count == 0 ) {
			this.SpinnerObject.hide();
		}
		
		//this.printCount();
	}
	
	this.printCount = function(){
		console.log(this.count);
	}
}

var o = $("#loadingSpinner");
var Spinner = new _Spinner(o);
Spinner.up(); // Init. page load
$(window).on("load", Spinner.down);

$(document).ajaxStart(function(){
	Spinner.up();
	console.log("AJAX START");
	})
	
	.ajaxComplete(function(){
		Spinner.down();
		console.log("AJAX END");
	});
