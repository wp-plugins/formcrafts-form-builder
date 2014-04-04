	<style>
		#wpcontent, #wpfooter
		{
			margin-left: 160px;
		}
		.folded #wpcontent, .folded #wpfooter
		{
			margin-left: 36px;
		}
	</style>
	<Style>

		form
		{
			width: 320px;
			margin: auto auto;
			height: 300px;
			margin-top: 150px;
			text-align: center;
			font-family: 'Open Sans', Helvetica, Arial;
		}
		form input,
		form button
		{
			width: 100%;
		}
		input[type="text"].input-one,
		select.input-one,
		input[type="email"].input-one,
		input[type="password"].input-one
		{
			border: 1px solid #bbb;
			border-color: #c4c4c4 #d8d8d8 #e2e2e2;
			box-shadow: none;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			padding: 8px 8px;
			font-size: 15px;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			font-size: 13px;
			color: #777;
			margin-top: 5px;
			margin-bottom: 5px;
			line-height: 135%;
		}
		input[type="text"].input-one:focus,
		select.input-one:focus,
		input[type="email"].input-one:focus,
		input[type="password"].input-one:focus
		{
			border-color: #4488ee;
		}

		input[type="text"].input-one.large,
		select.input-one.large,
		input[type="email"].input-one.large,
		input[type="password"].input-one.large
		{
			padding: 12px 12px;
			font-size: 20px;
		}		
		.ie_placeholder {
			position: absolute;
			left: 10px;
			font-size: 11px;
			background: #fff;
			line-height: 12px;
			color: #777;
			display: none;
		}
		.btn.large {
			font-size: 21px;
			padding: 13px 16px;
		}
		.loading-transition
		{
			transition: border-radius 0.50s ease-out, width 0.20s;
			-webkit-transition: border-radius 0.50s ease-out, width 0.20s;
			-moz-transition: border-radius 0.50s ease-out, width 0.20s;
			-ms-transition: border-radius 0.50s ease-out, width 0.20s;
			display: block;
			margin-left: auto;
			margin-right: auto;
		}

		.loading-button
		{
			background-image: url(<?php echo plugins_url( '../images/loading.gif', __FILE__ ); ?>) !important;
			background-size: 18px 18px;
			background-position: center !important;
			background-repeat: no-repeat !important;
			padding: 10px 15px;
			opacity: 1;
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
			filter: alpha(opacity=100);
			border-radius: 30px !important;
			-moz-border-radius: 30px !important;
			-webkit-border-radius: 30px !important;
			height: 37px !important;
			width: 37px !important;
		}
		.loading-button.large
		{
			height: 51px !important;
			width: 51px !important;
			background-size: 21px 21px;	
		}
		.btn
		{
			border: 0;
			box-shadow: 0;
			background-color: #888;
			color: white;
			font-size: 12px;
			padding: 8px 12px;
			text-align: center;
			margin: auto auto;
			display: block;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;	
			cursor: pointer;
			opacity: .93;
			outline: none;
			font-family: Helvetica, Arial;
			font-weight: 300;
			display: inline-block;
			text-decoration: none;
			text-transform: none;	
		}

		.btn.large
		{
			font-size: 21px;
			padding: 13px 16px; 
		}	

		.btn.center
		{
			display: block;
			margin: auto auto;
		}

		.btn:hover
		{
			opacity: 1;
			text-decoration: none;
			text-transform: none;		
		}
		.btn-blue
		{
			background: rgb(74,140,232);
			background: -moz-linear-gradient(top, rgba(74,140,232,1) 42%, rgba(41,119,229,1) 100%);
			background: -webkit-gradient(linear, left top, left bottom, color-stop(42%,rgba(74,140,232,1)), color-stop(100%,rgba(41,119,229,1)));
			background: -webkit-linear-gradient(top, rgba(74,140,232,1) 42%,rgba(41,119,229,1) 100%);
			background: -o-linear-gradient(top, rgba(74,140,232,1) 42%,rgba(41,119,229,1) 100%);
			background: -ms-linear-gradient(top, rgba(74,140,232,1) 42%,rgba(41,119,229,1) 100%);
			background: linear-gradient(to bottom, rgba(74,140,232,1) 42%,rgba(41,119,229,1) 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4a8ce8', endColorstr='#2977e5',GradientType=0 );
			border-bottom: 1px solid #284475;
		}	
		.btn-blue.loading-button
		{
			background-color: rgb(74,140,232);
		}
		.blue-link
		{
			font-size: 13px;
			font-weight: 400;
			text-transform: none;
			text-decoration: none;
			color: #999;
			cursor: pointer;
			margin-top: 4px;
		}
		.blue-link:hover
		{
			color: #4488ee;
		}
		.validation_error
		{
			position: absolute;
			right: 10px;
			font-size: 13px;
			background: #fff;
			line-height: 12px;
			line-height: 3px;
			margin-top: 3px;
			color: rgb(246,100,100);
			-webkit-animation-duration: 300ms;
			-webkit-animation-timing-function: ease;
			-webkit-animation-name: bounce-in;
			-moz-animation-duration: 300ms;
			-moz-animation-timing-function: ease;
			-moz-animation-name: bounce-in;
			-o-animation-duration: 300ms;
			-o-animation-timing-function: ease;
			-o-animation-name: bounce-in;
			-ms-animation-duration: 300ms;
			-ms-animation-timing-function: ease;
			-ms-animation-name: bounce-in;
			animation-duration: 300ms;
			animation-timing-function: ease;
			animation-name: bounce-in;
		}

	</Style>


	<div class='wp-login-screen'>
		<form class='form-user-alone' action='javascript:ajax_submit("form-login-alone")' data-ajax='user/login' id='form-login-alone' >
			<h1 class='cursive'><span style='color: #4488ee; font-size: 42px; letter-spacing: -2px; font-style: initial'>FormCrafts</span></h1>

			<span class='validation_error email_validation'></span>
			<span class='ie_placeholder'>email</span>
			<input type='email' placeholder='email' class='input-one email large' name='email' value='' autofocus>
			<span class='validation_error password_validation'></span>
			<span class='ie_placeholder'>password</span>
			<input type='password' placeholder='password' class='input-one password large' name='password'>
			<button type='submit' class='submit btn btn-blue loading-transition large' style='margin-top: 5px'>log in</button>
			<div class='response'></div>
			<div class='toggle-form blue-link toggle-signup' style='font-size: 14px'>Create a free account</div>
		</form>

		<form class='form-user-alone' action='javascript:ajax_submit("form-signup-alone")' data-ajax='user/signup' id='form-signup-alone' style='display: none'>
			<h1 class='cursive'><span style='color: #4488ee; font-size: 42px; letter-spacing: -2px; font-style: initial'>FormCrafts</span></h1>

			<span class='validation_error email_validation'></span>
			<span class='ie_placeholder'>email</span>
			<input type='email' placeholder='email' class='input-one email large' name='email' value='' autofocus>
			<span class='validation_error password_validation'></span>
			<span class='ie_placeholder'>password</span>
			<input type='password' placeholder='password' class='input-one password large' name='password'>
			<img src='<?php echo $captcha_url; ?>' alt='Captcha' style='width: 48%; height: 53px; float: left' class='captcha-image' title='Click to Try Another One'>
			<span class='validation_error captcha_validation'></span>
			<span class='ie_placeholder'>captcha</span>
			<input type='text' class='input-one captcha large' name='captcha' style='width: 48%; margin-left: 3.5%'>
			<input type='hidden' id='timezone-input' name='offset' value=''>
			<button type='submit' class='submit btn btn-blue loading-transition large' style='margin-top: 5px'>sign up</button>
			<div class='response'></div>
			<div class='toggle-form blue-link toggle-signup' style='font-size: 14px'>Already have an account? Login</div>
		</form>
	</div>
	<span style='height: 0; width: 0'></span>