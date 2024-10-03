<?php
/*
* Plugin Name: Geo Redirect
* Description: Redirect your website by geo location
* Version: 7.0
* Author: Geo Targetly
* Author URI: https://geotargetly.com
*/



//ADMIN MENU---------------------------------------------------------------------


add_action( 'admin_menu', 'geotargetly_wp_georedirect_add_admin_menu' );
add_action( 'admin_init', 'geotargetly_wp_georedirect_settings_init' );


function geotargetly_wp_georedirect_add_admin_menu(  ) { 
	add_menu_page( 'Geo Redirect - Geo Targetly', 'Geo Redirect', 'manage_options', 'geotargetly_wp_georedirect', 'geotargetly_wp_georedirect_options_page', 'dashicons-location' );
}


function geotargetly_wp_georedirect_settings_init(  ) { 
	register_setting( 'geotargetly_wp_georedirect_pluginPage', 'geotargetly_wp_georedirect_settings' );
	add_settings_section(
		'geotargetly_wp_georedirect_pluginPage_section', 
		__( '', 'geotargetly_wp_georedirect' ), 
		'geotargetly_wp_georedirect_settings_section_callback', 
		'geotargetly_wp_georedirect_pluginPage'
	);
     add_settings_field( 
		'geotargetly_wp_georedirect_ids', 
		__( 'IDs (comma separated)', 'geotargetly_wp_georedirect' ), 
		'geotargetly_wp_georedirect_ids_render', 
		'geotargetly_wp_georedirect_pluginPage', 
		'geotargetly_wp_georedirect_pluginPage_section' 
	);
}



function geotargetly_wp_georedirect_ids_render(  ) { 
	$options = get_option( 'geotargetly_wp_georedirect_settings' );
	?>
	<input type='text' name='geotargetly_wp_georedirect_settings[geotargetly_wp_georedirect_ids]' value='<?php echo $options['geotargetly_wp_georedirect_ids']; ?>'>
	<?php
}



function geotargetly_wp_georedirect_settings_section_callback(  ) { 
	echo __( '', 'geotargetly_wp_georedirect' );
}


function geotargetly_wp_georedirect_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content">

<h2>Geo Redirect - By Geo Targetly</h2>

<div class="postbox" style="width:70%; padding:30px;">
<h2>Getting Started</h2>

<p>Geo Targetly's Geo Redirect service allows you to easily redirect your website based on visitor geolocation (country, state, city, IP address, latitude-longitude-radius).</p>

<p><strong>Note: </strong>This Wordpress plugin allows you to install Geo Targetly's Geo Redirect scripts into your Wordpress website.</p>

<p style="padding-top:20px;"><strong>Steps</strong></p>	
<p>1. Create a Geo Targetly account at <a href="https://geotargetly.com" target="_blank">Geotargetly.com</a> </p>
<p>2. <a href="https://dashboard.geotargetly.com/login" target="_blank">Log in</a> to your Geotargetly dasboard</p>
<p>3. Create a new <strong>Geo Redirect</strong> service</p>
<p>4. Follow the procedure to setup your geo redirects</p>
<p>5. Copy the Geo Redirect Wordpress ID & Reference provided and insert into settings below</p>
<p style="padding-top:20px;">Read more about Geo Redirect at our <a href="https://geotargetly.com/docs/geo-redirect" target="_blank">docs</a></p>

</div>



<div class="postbox" style="width:70%; padding:30px;">
<h2>Settings</h2>
<?php
settings_fields( 'geotargetly_wp_georedirect_pluginPage' );
do_settings_sections( 'geotargetly_wp_georedirect_pluginPage' );
submit_button();
?>
</div>

</form>

</div>
</div>

<?php

}







//GEO REDIRECT-----------------------------------------------------------

//ADD GEO REDIRECT WP HEAD

add_action('wp_head', 'geotargetly_wp_georedirect', -1000);

function geotargetly_wp_georedirect() {
	
	$var = "some text";
	$scripts = <<<EOT
EOT;
	
	$geotargetly_georedirect_ids_database        = get_option('geotargetly_wp_georedirect_settings');
    $geotargetly_georedirect_ids_database_string = preg_replace('/\s+/', '', $geotargetly_georedirect_ids_database['geotargetly_wp_georedirect_ids']);
    $geotargetly_georedirect_ids_database_array  = explode(',', $geotargetly_georedirect_ids_database_string);
    $geotargetly_georedirect_ids_database_array  = array_filter($geotargetly_georedirect_ids_database_array);
	
	if (!empty($geotargetly_georedirect_ids_database_array)) {
        for ($i = 0; $i < count($geotargetly_georedirect_ids_database_array); ++$i) {
            
			$scripts .= <<<EOT
<script>
(function(g,e,o,id,t,a,r,ge,tl,y,s){
g.getElementsByTagName(o)[0].insertAdjacentHTML('afterbegin','<style id="georedirect$geotargetly_georedirect_ids_database_array[$i]style">body{opacity:0.0 !important;}</style>');
s=function(){g.getElementById('georedirect$geotargetly_georedirect_ids_database_array[$i]style').innerHTML='body{opacity:1.0 !important;}';};
t=g.getElementsByTagName(o)[0];y=g.createElement(e);y.async=true;
y.src='https://g10102301085.co/gr?id=$geotargetly_georedirect_ids_database_array[$i]&refurl='+g.referrer+'&winurl='+encodeURIComponent(window.location);
t.parentNode.insertBefore(y,t);y.onerror=function(){s()};
georedirectLoaded="undefined" != typeof georedirectLoaded ? georedirectLoaded:{};
georedirectLoaded['$geotargetly_georedirect_ids_database_array[$i]'] = function(redirect){var to=0;if(redirect){to=5000};setTimeout(function(){s();},to)};
setTimeout(function(){s();}, 8000);
})(document,'script','head');
</script>
EOT;
            
        }
    }
	
	echo $scripts;
}





?>