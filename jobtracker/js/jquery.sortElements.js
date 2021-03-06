function sortingbyfields() {

var trcolor = 0 ;
jQuery.fn.sortElements = (function(){
    
		    var sort = [].sort;
		    
		    return function(comparator, getSortable) {
		        
		        getSortable = getSortable || function(){return this;};
		        
		        var placements = this.map(function(){
		            
		            var sortElement = getSortable.call(this),
		                parentNode = sortElement.parentNode,
		                
		                // Since the element itself will change position, we have
		                // to have some way of storing it's original position in
		                // the DOM. The easiest way is to have a 'flag' node:
		                nextSibling = parentNode.insertBefore(
		                    document.createTextNode(''),
		                    sortElement.nextSibling
		                );
		            
		            return function() {
		                
		                if (parentNode === this) {
		                    throw new Error(
		                        "You can't sort elements if any one is a descendant of another."
		                    );
		                }	
						//console.log(this);
						if(trcolor == 0) {
							$(this).attr('class','trcolor');
							trcolor = 1;
						} else {
							$(this).attr('class','');
							trcolor = 0;
						}
							
		                //console.log($(this).attr('class','trcolor'));
		                // Insert before flag:
		                parentNode.insertBefore(this, nextSibling);
		                // Remove flag:
		                parentNode.removeChild(nextSibling);
		                
		            };
		            
		        });
		       
		        return sort.call(this, comparator).each(function(i){
		            placements[i].call(getSortable.call(this));
		        });
		    };
		})();
		

	    var th = jQuery('.sort_column'),
	        inverse = false;
	    
	    th.click(function(imgId){
			trcolor = 0;
	        var header = $(this),
	        index = header.index();
			var isColDate = $(this).hasClass("date");
			//console.log(isColDate);           
	        header
	            .closest('table')
	            .find('td')
	            .filter(function(){
	                return $(this).index() === index;
	            })
	            .sortElements(function(a, b){
					if (isColDate) {
						if($(a).text()==""){
							a = 0;
						} else {
							var myDate = $(a).text();
							myDate=myDate.split("/");
							var newDate=myDate[1]+"/"+myDate[0]+"/"+myDate[2];
							a = new Date(newDate).getTime();
							//console.log(a);
						}
						
						if($(b).text()==""){
							b=0;
						} else {
							var myDate = $(b).text();
							myDate=myDate.split("/");
							var newDate=myDate[1]+"/"+myDate[0]+"/"+myDate[2];
							b = new Date(newDate).getTime();
						}
					} else {
	            		a = $(a).text();
		                b = $(b).text();
						a = a.toLowerCase();
						b = b.toLowerCase();						
					}

	                return (
	                    isNaN(a) || isNaN(b) ?
	                        a > b : +a > +b
	                    ) ?
	                        inverse ? -1 : 1 :
	                        inverse ? 1 : -1;
	                    
	            }, function(){
	                return this.parentNode;
	            });
	        
	        inverse = !inverse;
	    });
		
}
	
sortingbyfields(); //For Auto call reuse