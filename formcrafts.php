<?php

/*

   Copyright 2013  Nishant Agrawal  (email : nishantagrawal234@gmail.com)

   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License, version 2, as 
   published by the Free Software Foundation.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 * Plugin Name: FormCrafts
 * Plugin URI: http://formcrafts.com
 * Description: A drag-and-drop form builder, to create amazing forms and manage submissions.
 * Version: 1.0.8
 * Author: nCrafts
 * Author URI: http://ncrafts.net
 * License: GPL2

*/

   if ($_SERVER['HTTP_HOST']=='localhost')
   {
     $fc_path = 'http://localhost/fc/laravel/public/';    
   }
   else
   {
     $fc_path = isset($_SERVER['HTTPS']) ? 'https://formcrafts.com/' : 'http://formcrafts.com/';
   }
   global $fc_path;


   add_action('wp_ajax_formcrafts_get_forms', 'formcrafts_get_forms');
   add_action('wp_ajax_nopriv_formcrafts_get_forms', 'formcraft_get_forms');
   add_action('wp_ajax_formcrafts_save_api', 'formcrafts_save_api');
   add_action('wp_ajax_nopriv_formcrafts_save_api', 'formcraft_save_api');

   add_shortcode( 'formcrafts', 'add_formcrafts_shortcode' );

   function formcrafts_save_api()
   {
    if ( !isset($_GET['api']) || !isset($_GET['redirect']) )
    {
     echo 'API / Redirect path not set';
   }
   update_option( 'formcrafts_api', $_GET['api'], '', 'yes' );
   echo $_GET['redirect'];
   die();
 }

 function add_formcrafts_shortcode( $atts, $content = null ){

  global $fc_path;

  extract( shortcode_atts( array(
   'id' => '1',
   'name' => 'FormCrafts',
   'type' => 'Inline Form',
   'align' => 'center',
   'bind' => 'f'.substr(md5(rand()), 0, 5)
   ), $atts ) );

  $paid = false;
  if (strlen(get_option( 'formcrafts_api' ))==24)
  {
    if (substr(get_option( 'formcrafts_api' ), -1)==1)
    {
      $paid = true;
    }
  }

  if ($id % 2 == 0)
  {
    $powered_text = 'made with <span>FormCrafts</span> - online form builder';
  }
  else
  {
    $powered_text = 'powered by <span>FormCrafts</span>';
  }
  $powered_text = "<a class='fcpbl ".$align."' href='".$fc_path."?pw=pwl'>$powered_text</a>";

  if ($paid==true) {  $powered_text=''; }

  if ($_SERVER['HTTP_HOST']=='localhost')
  {
   $short_path = 'localhost/fc/laravel/public/';    
 }
 else
 {
   $short_path = 'formcrafts.com/';
 } 

 if ( $type=='popup' )
 {
   if ( $align=='left' || $align=='right' )
   {   
     return "<script type='text/javascript'>var _fo=_fo||[];_fo.push({'m':'".$align."','t':'".$content."','c':'".$bind."','i':".$id."});if(typeof fce=='undefined'){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=('https:'==window.location.protocol?'https://':'http://')+'".$short_path."js/fc.js';var fi=document.getElementsByTagName('script')[0];fi.parentNode.insertBefore(s,fi);fce=1;}</script><a id='#".$bind."_a' href='".$fc_path."a/".$id."'>".$name."</a>";
   }
   else
   {
    if ($content==null || empty($content))
    {
      return "<script type='text/javascript'>var _fo=_fo||[];_fo.push({'m':'true','c':'".$bind."','i':".$id."});if(typeof fce=='undefined'){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=('https:'==window.location.protocol?'https://':'http://')+'".$short_path."js/fc.js';var fi=document.getElementsByTagName('script')[0];fi.parentNode.insertBefore(s,fi);fce=1;}</script>";
    }
    else
    {
     return "<script type='text/javascript'>var _fo=_fo||[];_fo.push({'m':'true','c':'".$bind."','i':".$id."});if(typeof fce=='undefined'){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=('https:'==window.location.protocol?'https://':'http://')+'".$short_path."js/fc.js';var fi=document.getElementsByTagName('script')[0];fi.parentNode.insertBefore(s,fi);fce=1;}</script><a href='".$fc_path.'a/'.$id."' data-target='#".$bind."' data-toggle='fcmodal'>".$content."</a>";
   }     
 }
}
else
{
  return "<script type='text/javascript'>var _fo=_fo||[];_fo.push({'d':'".$align."','c':'".$bind."','i':".$id."});if(typeof fce=='undefined'){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=('https:'==window.location.protocol?'https://':'http://')+'".$short_path."js/fc.js';var fi=document.getElementsByTagName('script')[0];fi.parentNode.insertBefore(s,fi);fce=1;}</script><div id='".$bind."'><a href='http://".$short_path.'a/'.$id."'>$name</a></div>$powered_text";
}
}

function formcrafts_get_forms()
{
  global $fc_path;
  $api = get_option( 'formcrafts_api' );

  if (!function_exists('curl_version'))
  {
    echo json_encode(array('failed'=>'FormCraft requires the PHP extension cURL. You don\'t appear to have it. Please contact your web host.', 'failedType'=>'curl'));
    die();
  }

  $ch = curl_init();
  curl_setopt_array($ch, array(
   CURLOPT_URL            => $fc_path.'api/get_forms?api='.$api,
   CURLOPT_RETURNTRANSFER => 1,
   CURLOPT_SSL_VERIFYPEER => false   
   ));
  $result = curl_exec($ch);
  curl_close($ch);
  echo $result;
  die();
}



add_action('admin_menu', 'formcrafts_admin' );
add_action('media_buttons_context',  'formcrafts_wp_edit_button');

function formcrafts_wp_edit_button($context) {
  wp_enqueue_script('jquery');
  ?>

  <style>
    .fc-message
    {
      width: 100%;
      display: block;
      padding: 15px 0;
      text-align: center;
    }
    #formcrafts-btn
    {
      border: 0;
      box-shadow: 0;
      background-color: #888;
      color: white;
      font-size: 12px;
      padding: 6px 12px;
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
      display: inline-block;
      text-decoration: none;
      text-transform: none; 
      margin-right: 5px;
      margin-bottom: 4px;
      background: rgb(74,140,232);
      border-bottom: 1px solid rgb(27, 82, 165);
      background: rgba(41,119,229,1);
    }
    #formcrafts-btn-cover.active #formcrafts-btn
    {
      background: rgb(39, 118, 230);
      box-shadow: 0px 1px 1px #0D2674 inset;
      -moz-box-shadow: 0px 1px 1px #0D2674 inset;
      -webkit-box-shadow: 0px 1px 1px #0D2674 inset;
      border-bottom: 1px solid rgb(41,119,229); 
    }       
    #formcrafts-btn:hover
    {
      opacity: 1;
      text-decoration: none;
      text-transform: none;   
    }
    #formcrafts-btn-cover
    {
      display: inline-block;
      position: relative;
      z-index: 101;
    }
    #formcrafts-btn-tooltip
    {
      display: none;
      width: 240px;
      position: absolute;
      background-color: #fff;
      box-shadow: 0px 1px 9px #999;
      -moz-box-shadow: 0px 1px 9px #999;
      -webkit-box-shadow: 0px 1px 9px #999;
      margin-left: -60px;
      border-radius: 5px;
      -moz-border-radius: 5px;
      -webkit-border-radius: 5px;
      margin-top: 4px;
      border: 1px solid #bbb;         
    }
    #formcrafts-btn-tooltip:after
    {
      content: '';
      width: 0; 
      height: 0; 
      border-left: 9px solid transparent;
      border-right: 9px solid transparent; 
      border-bottom:9px solid #999;
      position: absolute;
      left: 50%;
      margin-left: -9px;
      top: 0;
      margin-top: -9px;     
    }
    #formcrafts-btn-cover.active #formcrafts-btn-tooltip
    {
      display: block;
    }
    #formcrafts-btn-tooltip-forms
    {
      padding: 0;
      margin: 0;
      overflow: hidden;
      max-height: 112px;
      overflow: auto;       
    }
    #formcrafts-btn-tooltip-forms li
    {
      padding: 6px 9px;
      margin: 0;
      font-size: 12px;
      display: block;
      color: #888;
      cursor: pointer;
      background-color: #f0f0f0;
    }
    #formcrafts-btn-tooltip-forms li:first-child
    {
      border-top-left-radius: 3px;
      border-top-right-radius: 3px;
      -moz-border-top-left-radius: 3px;
      -moz-border-top-right-radius: 3px;
      -webkit-border-top-left-radius: 3px;
      -webkit-border-top-right-radius: 3px;
    }
    .formcrafts-btn-tooltip-type
    {
      display: inline-block;
      width: 50%;
      background-color: #f0f0f0;
      font-size: 12px;
      text-align: center;
      padding: 6px 0;
      cursor: pointer;
      color: #888;
    }   
    .formcrafts-btn-tooltip-align
    {
      display: inline-block;
      width: 33.3%;
      background-color: #f0f0f0;
      font-size: 12px;
      text-align: center;
      padding: 5px 0;
      cursor: pointer;
      color: #888;
    }
    .formcrafts-btn-tooltip-align
    {
      border-bottom: 1px solid #e6e6e6;
    }
    .formcrafts-btn-tooltip-align.active
    {
      border-bottom: 1px solid #fff;
    }

    .formcrafts-btn-tabs > div
    {
      display: none;
    }
    .formcrafts-btn-tabs > div.active
    {
      display: block;
    }
    .formcrafts-btn-nav .active,
    #formcrafts-btn-tooltip-forms li.active       
    {
      background-color: white;
      color: #444;
    }
    .formcrafts-link
    {
      text-align: center;
      display: block;
      color: #4488ff !important;
      background-color: #f0f0f0;
      line-height: 200%;
      border-bottom-left-radius: 3px;
      border-bottom-right-radius: 3px;
      -moz-border-bottom-left-radius: 3px;
      -moz-border-bottom-right-radius: 3px;
      -webkit-border-bottom-left-radius: 3px;
      -webkit-border-bottom-right-radius: 3px;
    }
    .formcrafts-link:hover
    {
      color: #4466ff !important;
    }
    #formcrafts-btn-shortcode
    {
      width: 100%;
      font-size: 11px;
      font-family: Monaco;
      line-height: 150%;
      outline: 0px;
      resize: none;
      color: #666;
      border: 0px;
      overflow: auto;
      letter-spacing: -1px; padding: 6px 7px; margin: 3px 0px;
      box-shadow: none;
      -moz-box-shadow: none;
      -webkit-box-shadow: none;
      margin: 0px;
      border-bottom: 1px solid #e6e6e6;
      display: block;
      background-color: #fff;
    }
    @-moz-document url-prefix() { 
      #formcrafts-btn-shortcode {
       font-family: Helvetica, Arial;
       letter-spacing: 0.2px;
       font-size: 12px;
       line-height: 130%;
     }
   } 
   #formcrafts-btn-cover.formcrafts-loading #formcrafts-btn-shortcode,
   #formcrafts-btn-cover.formcrafts-loading .formcrafts-link,
   #formcrafts-btn-cover.formcrafts-loading .formcrafts-btn-tooltip-align,
   #formcrafts-btn-cover.formcrafts-loading .formcrafts-btn-tooltip-type,
   #formcrafts-btn-cover.formcrafts-loading div
   {
     display: none;
   }
   #formcrafts-btn-cover #formcrafts-btn-loading
   {
     display: block;
     text-align: center;
     padding: 10px;
     border-radius: 3px;
     -moz-border-radius: 3px;
     -webkit-border-radius: 3px;
   }
 </style>
 <script>
  function formcrafts_refresh_shortcode()
  {
   var type = jQuery('.formcrafts-btn-tooltip-type.active').text();
   var index = jQuery('.formcrafts-btn-tooltip-type.active').index();
   var align = jQuery('.formcrafts-btn-tooltip-align.active:eq('+index+')').text().toLowerCase();
   var form = jQuery('#formcrafts-btn-tooltip-forms li.active').attr('data-index');
   var name = jQuery('#formcrafts-btn-tooltip-forms li.active').text();
   var rand = 'f'+Math.random().toString(36).slice(-4);

   if (type=='Inline Form')
   {
    var shortcode = "[formcrafts id='"+form+"' name='"+name+"' align='"+align+"'][/formcrafts]";
  }
  else
  {
    var shortcode = "[formcrafts id='"+form+"' type='popup' align='"+align+"']Click Here[/formcrafts]";
  }
  jQuery('#formcrafts-btn-shortcode').text(shortcode);
}
jQuery(document).mouseup(function (e)
{
 var container = jQuery('#formcrafts-btn-cover');
 if (!container.is(e.target)
  && container.has(e.target).length === 0)
 {
  container.removeClass('active');
}
});       
jQuery(document).ready(function(){
 jQuery('body').on('click', '#formcrafts-btn', function(event){
  event.preventDefault();
  jQuery(this).parent().toggleClass('active');
  if (jQuery('#formcrafts-btn-tooltip-forms').text()!='loading...')
  {
   return false;
 }
 jQuery.ajax({
   url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
   type: 'GET',
   data: 'action=formcrafts_get_forms',
   dataType: 'JSON',
 }).done(function(response){
   if (response.success && response.forms)
   {
    var html = '';
    if (response.forms.length==0)
    {
      html = '<center><bR>No forms created<br><br></center>'; 
      jQuery('#formcrafts-btn-tooltip').html(html);
    }
    else
    {
      for (form in response.forms)
      {
        html = form == 0 ? html + '<li data-index="'+response.forms[form]['id']+'" class="active">'+response.forms[form]['name']+'</li>' : html + '<li data-index="'+response.forms[form]['id']+'">'+response.forms[form]['name']+'</li>';
      }
      jQuery('#formcrafts-btn-tooltip-forms').html(html);
    }

  }
  else if (response.failedType)
  {
   jQuery('#formcrafts-btn-tooltip').html("<div class='fc-message'>"+response.failed+"</div>");
 }
 else
 {
   jQuery('#formcrafts-btn-tooltip').html("<a style='color: #48e; font-size: 14px; margin: 20px 0px; display: block; text-align: center' target='_blank' href='<?php echo admin_url(); ?>admin.php?page=formcrafts_admin_page'>Click here and log in</a>");
 }
 formcrafts_refresh_shortcode();
 jQuery('#formcrafts-btn-cover').removeClass('formcrafts-loading');
});           
});

jQuery('body').on('click', '.formcrafts-btn-nav > span', function(event){
 jQuery(this).parent().find('> span').removeClass('active');
 jQuery(this).addClass('active');
 var abc = jQuery(this).index() + 1;
 jQuery(this).parent().find('> .formcrafts-btn-tabs > div').hide();
 jQuery(this).parent().find('> .formcrafts-btn-tabs > div').removeClass('active');

 jQuery(this).parent().find('> .formcrafts-btn-tabs > div:nth-child('+abc+')').show();
 jQuery(this).parent().find('> .formcrafts-btn-tabs > div:nth-child('+abc+')').addClass('active');
 formcrafts_refresh_shortcode();
});

jQuery('body').on('click', '#formcrafts-btn-tooltip-forms li', function(event){
 jQuery(this).parent().find('> li').removeClass('active');
 jQuery(this).addClass('active');
 formcrafts_refresh_shortcode();
})

});
</script>

<?php
$context .= "
<div id='formcrafts-btn-cover' class='formcrafts-loading'>
  <button id='formcrafts-btn'><span style='font-size: 15px; line-height: 10px; font-weight: bold'>+</span> FormCrafts Form</button>

  <div id='formcrafts-btn-tooltip'>
    <ul id='formcrafts-btn-tooltip-forms'><li id='formcrafts-btn-loading'>loading...</li></ul>

    <div class='formcrafts-btn-nav'>
      <span class='formcrafts-btn-tooltip-type active'>Inline Form</span><span class='formcrafts-btn-tooltip-type'>Modal Form</span>

      <div class='formcrafts-btn-tabs'>
        <div class='formcrafts-btn-nav active'>
          <span class='formcrafts-btn-tooltip-align active'>Left</span><span class='formcrafts-btn-tooltip-align'>Center</span><span class='formcrafts-btn-tooltip-align'>Right</span>
          <div class='formcrafts-btn-tabs'>
            <div class='active'></div>
            <div></div>
            <div></div>
          </div>  
        </div>
        <div class='formcrafts-btn-nav'>
          <span class='formcrafts-btn-tooltip-align active'>Inline</span><span class='formcrafts-btn-tooltip-align'>Left</span><span class='formcrafts-btn-tooltip-align'>Right</span>
          <div class='formcrafts-btn-tabs'>
            <div class='active'></div>
            <div></div>
            <div></div>
          </div>          
        </div>
      </div>  
    </div>
    <textarea onclick='select()' rows='3' readonly='readonly' id='formcrafts-btn-shortcode'></textarea>
    <div style='font-size: 12px; text-align: center; background-color: #eee; padding-top: 3px'>use the above shortcode in your post</div>
    <a class='formcrafts-link' href='http://formcrafts.com/help/basics/how-can-i-embed-share-the-forms-i-have-made' target='_blank'>read more</a>
  </div>
</div>";
return $context;
}

function formcrafts_admin()
{
  global $wp_version, $fc_page;
  $fc_image = $wp_version >= 3.8 ? 'dashicons-list-view' : plugins_url( 'images/icon.png', __FILE__ );
  $fc_page = add_menu_page( 'FormCrafts', 'FormCrafts', 'edit_posts', 'formcrafts_admin_page', 'formcrafts_admin_page', $fc_image, '31.2035' );
  add_action( 'admin_enqueue_scripts', 'formcrafts_login_assets' );
}

function formcrafts_admin_page()
{
 global $wp_version, $fc_path;

 ?>

 <style>
   #wpcontent, #wpfooter
   {
    margin-left: 160px !important;
  }
</style>
<?php
$captcha_url = plugins_url( 'views/captcha.php', __FILE__ );
?>
<style>
 .folded #wpcontent, .folded #wpfooter
 {
  margin-left: 36px;
}

#wpfooter
{
  display: none;
}
#fc-cover iframe
{
  width: 100%;
  height: 100%;
  overflow: visible;
}
</style>  
<div id='fc-cover' style='background-color: #fff; position: absolute; top: 0; bottom: 0; left: 0; right: 0; z-index: 100'>
</div>
<script type="text/javascript" src="<?php echo plugins_url( 'easyXDM.min.js', __FILE__ ); ?>"></script>
<script>
 var w = window,
 d = document,
 e = d.documentElement,
 g = d.getElementsByTagName('body')[0],
 x = w.innerWidth || e.clientWidth || g.clientWidth,
 y = w.innerHeight|| e.clientHeight|| g.clientHeight;
 document.getElementById('fc-cover').style.height = ((Math.max(y,500))-32)+"px";

 if ("<?php echo get_option( 'formcrafts_api' ); ?>"=="")
 {
   var url = "<?php echo $fc_path; ?>wp/user/login?return=<?php echo urlencode(plugins_url('',__FILE__)); ?>&logout=true";
 }
 else
 {
   var url = "<?php echo $fc_path; ?>wp/user/login?return=<?php echo urlencode(plugins_url('',__FILE__)); ?>";  
 }
 window.formcrafts_api = '<?php echo get_option( 'formcrafts_api' ); ?>';
 transport = new easyXDM.Socket(
 {
   remote: url,
   container: 'fc-cover',
   onMessage: function(message, origin){
    message = jQuery.parseJSON( message );
    if (typeof message.redirect=='undefined'){return false;}
    jQuery.ajax({
      url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
      type: 'GET',
      data: 'action=formcrafts_save_api&api='+message.api+'&redirect='+encodeURIComponent(message.redirect),
    }).done(function(response){
    }).always(function(response){
      data = '{ "redirect": "'+response+'" }';
      transport.postMessage(data);
    });   
  },
  onReady: function(){
    if (window.formcrafts_api=='') { transport.postMessage('no api'); }
  }
});      
</script> 

<?php
wp_enqueue_script('jquery');
wp_enqueue_script('fc-login-page', plugins_url( 'assets/fc-login-page.js', __FILE__ ));
}

function formcrafts_login_assets($hook) {
  global $fc_page;
  if ( $hook =='toplevel_page_formcrafts_admin_page' )
  {
    wp_enqueue_script( 'fc-login-page', plugin_dir_url( __FILE__ ) . 'assets/fc-login-page.js' );
    wp_enqueue_script( 'jquery' );
  }
}
