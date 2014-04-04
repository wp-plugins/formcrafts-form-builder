		var w = window,
		d = document,
		e = d.documentElement,
		g = d.getElementsByTagName('body')[0],
		x = w.innerWidth || e.clientWidth || g.clientWidth,
		y = w.innerHeight|| e.clientHeight|| g.clientHeight;
		y = y - 96;
		/* var h = document.getElementById('fc-cover').setAttribute("style","height:"+y+"px"); */

		window.base = 'http://localhost/fc/laravel/public/';
		window.base = 'http://formcrafts.com/';
		function ajax_submit(id)
		{

			jQuery('#'+id+' button[type="submit"]').attr('disabled','disabled'); 
			jQuery('#'+id+' button[type="submit"]').addClass('loading-button'); 
			jQuery('#'+id+' button[type="submit"]').attr('data-text',jQuery('#'+id+' button[type="submit"]').text()); 
			jQuery('#'+id+' button[type="submit"]').text(''); 
			jQuery('#'+id+' .validation_error').text(''); 
			jQuery('#'+id+' .validation_error').hide(); 
			jQuery('#'+id+' .failed').removeClass('failed');


			jQuery('#'+id+' .response').html('');
			jQuery.ajax({
				dataType: 'json',
				type: "POST",
				url: window.base+jQuery('#'+id).attr('data-ajax'),
				data: jQuery('#'+id).serialize()
			}).
			always(function ()
			{
				jQuery('#'+id+' button[type="submit"]').removeAttr('disabled'); 
				jQuery('#'+id+' button[type="submit"]').removeClass('loading-button'); 
				jQuery('#'+id+' button[type="submit"]').text(jQuery('#'+id+' button[type="submit"]').attr('data-text')); 
				jQuery('#'+id+' button[type="submit"]').attr('data-text',''); 
			}).
			done(function (response)
			{
				if (response.success)
				{
					jQuery('#'+id+' .response').removeClass('failed');
					jQuery('#'+id).fadeOut(function()
					{
						jQuery('#'+id).html("<div class='form-success-last'>"+response.success+"</div>");
						jQuery('#'+id).fadeIn();
					});
					if (response.redirect)
					{
						window.location.replace(response.redirect);
					}
				}
				else if (typeof response.failed != 'undefined')
				{
					jQuery('#'+id+' .response').html(response.failed);
					jQuery('#'+id+' .response').removeClass('success');
					jQuery('#'+id+' .response').addClass('failed');

					for (field in response)
					{
						if (jQuery('#'+id+' .'+field).length && field!='failed' && !jQuery('#'+id+' .'+field).hasClass('failed'))
						{
							jQuery('#'+id+' .'+field).addClass('failed');
							jQuery('#'+id+' .'+field+'_validation').text(response[field]);
							jQuery('#'+id+' .'+field+'_validation').show();
						}
					}

				}
			}).
			fail(function (response)
			{
				jQuery('#'+id+' .response').html('Unknown Error');
			});
		}





		jQuery(document).ready(function(){

			jQuery('.toggle-form').click(function(){
				jQuery('#form-login').toggle();
				jQuery('#form-forgot-password').toggle();
			});

			jQuery('.toggle-signup').click(function(){
				jQuery('#form-login-alone').toggle();
				jQuery('#form-signup-alone').toggle();
			});		

			jQuery('.nav-alive span').click(function(){
				var index = jQuery(this).index();
				jQuery(this).parent().find('span').removeClass('active');
				jQuery('.tabs > div').removeClass('active');
				jQuery(this).addClass('active');
				jQuery('.tabs > div').hide();
				jQuery('.tab:eq('+index+')').show();
				jQuery('.tab:eq('+index+')').addClass('active');
			});

			jQuery('.nav-a.signup').click(function(){
				setTimeout(function(){
					jQuery('.form-sign .email').focus();				
				},100);
			});

			jQuery('.nav-a.login').click(function()
			{
				if (jQuery('.form-user').hasClass('show'))
				{
					jQuery('.form-user').removeClass('show');
					jQuery(this).removeClass('toggle');
				}
				else
				{
					jQuery(this).addClass('toggle');
					jQuery('.form-user').addClass('show');
					jQuery('.form-user .email').focus();
				}
			});

			jQuery('.captcha-image').click(function(){
				jQuery(this).attr('src',jQuery(this).attr('src')+'&'+Math.floor((Math.random()*100)+1));
			});

			var d = new Date()
			var n = (d.getTimezoneOffset()*-1)/60;
			jQuery('#timezone-input').val(n);

		});