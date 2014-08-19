jQuery(document).ready(function(){
	jQuery('a').each(function(){
		var href = jQuery(this).attr('href');
		if (href!=undefined){
		if (href.indexOf('http://formcrafts.com/a')!=-1 || href.indexOf('https://formcrafts.com/a')!=-1)
		{
			if (href.indexOf('#modal')!=-1)
			{
				for (x in _fo)
				{
					jQuery(this).attr('data-toggle','fcmodal');
					jQuery(this).attr('data-target','#'+_fo[x].c);
				}
			}
		}			
		}
	});
});