jQuery(document).ready(function(){

	// Search
	jQuery('#search-box').hide();
	jQuery('.strigger').click(function(){
			jQuery('#search-box').toggle();
	});

	jQuery('#qubez').slicknav({
		label: '',
		duration: 1000,
		prependTo:'.menu-trig'
	});


	jQuery('.sidetrigger').click(function(){
	   jQuery('#st-container').toggleClass('st-menu-open');
	});

   jQuery('.sidebox').slimScroll({
        height: 'auto',
        color: '#eee',
    });

});

