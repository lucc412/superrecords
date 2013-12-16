
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
		

	    var th = jQuery('th'),
	        inverse = false;
	    
	    th.click(function(){
	        
	        var header = $(this),
	        index = header.index();
	            
	        header
	            .closest('table')
	            .find('td')
	            .filter(function(){
	                return $(this).index() === index;
	            })
	            .sortElements(function(a, b){
	                a = $(a).text();
	                b = $(b).text();
	                
					a = a.toLowerCase();
					b = b.toLowerCase();
					
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
$('th').sortElements(function(a,b){
        return parseInt($(a).html(),10) < parseInt($(b).html(),10) ? 1 : -1;
    });
		