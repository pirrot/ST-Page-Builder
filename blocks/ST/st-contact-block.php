<?php
/** Contact Form Block **/

class ST_Contact_Block extends AQ_Block {

    //set and create block
    function __construct() {
        $block_options = array(
            'name' => '<i class="fa fa-envelope"></i> Contact Form',
            'size' => 'col-md-12',
        );

        //create the block
        parent::__construct('st_contact_block', $block_options);
    }

    function form($instance) { 
    	
		$args = array (
			'nopaging' => true,
			'post_type' => 'wpcf7_contact_form',
			'status' => 'publish',
		);
		$contacts = get_posts($args);
		
    	$contact_options = array(); $default_contact = '';
		foreach ($contacts as $contact) {
			$default_contact = empty($default_sidebar) ? $contact->ID : $default_contact;
			$contact_options[$contact->ID] = htmlspecialchars($contact->post_title);
		}
				
        $defaults = array(
        	'contact' => $default_contact,
			'title' => '',
			'subtitle' => '',
			'address' => '',
			'longitude' => '',
			'latitude' => '',
        ); 
        $instance = wp_parse_args($instance, $defaults);
        extract( $instance);

        ?>
        
		<div class="description third">
			<label for="<?php echo $block_id ?>_title">
				Title (optional)<br/>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>
		
		<div class="description third">
			<label for="<?php echo $block_id ?>_subtitle">
				Subtitle (optional)<br/>
				<?php echo aq_field_input('subtitle', $block_id, $subtitle, $size = 'full') ?>
			</label>
		</div>
		<div class="description third last">
			<label for="">
				Choose contact form<br/>
				<?php echo aq_field_select('contact', $block_id, $contact_options, $contact); ?>
			</label>
		</div>
		<div class="cf"></div>
		
		<h3 style="text-align: center;">Settings Google Map</h3><br />
		<div class="description">
			<label for="<?php echo $block_id ?>_address">
				Address (optional)<br/>
				<?php echo aq_field_input('address', $block_id, $address, $size = 'full') ?>
			</label>
		</div>
		<div class="cf"><code>Website convert address to latitude and longitude <a target="_blank" href="http://www.latlong.net/convert-address-to-lat-long.html">click here</a></code></div>
        <div class="description half">
			<label for="<?php echo $block_id ?>_latitude">
				Position Latitude Number (optional)<br/>
				<?php echo aq_field_input('latitude', $block_id, $latitude, $size = 'full') ?>
			</label>
		</div>
		<div class="description half last">
			<label for="<?php echo $block_id ?>_longitude">
				Position Longitude Number (optional)<br/>
				<?php echo aq_field_input('longitude', $block_id, $longitude, $size = 'full') ?>
			</label>
		</div>
	<?php
    }

    function block($instance) {
        extract($instance);
      
        ?>
		<div class="container">
		<div class="section-heading text-center" data-animated="fadeInDown">		
			<h2 class="title"><span><?php echo $title; ?></span></h2>
			<p class="subtitle"><?php echo $subtitle; ?></p>		
		</div>
		<div class="row">
			<div class="col-md-8">
				<!-- contact form -->
				<div id="contactform">
					<?php 
			        	//echo do_shortcode(htmlspecialchars_decode($title));	
			        	echo do_shortcode('[contact-form-7 id="'.$contact.'" title="contact form 2"]');
			        ?>
				</div>
				<script>
					$( "#contactform .placeholder" ).focus(function() {
						$( this ).removeClass("placeholder");
					});
				</script>
				<!-- End contact form -->
			</div>
			<div class="col-md-4 address">
				<!-- Map -->
				<div class="map">
					<div id="map" class="googlemap" data-position-latitude="<?php echo $latitude; ?>" data-position-longitude="<?php echo $longitude; ?>" data-marker-img="<?php echo get_bloginfo('template_directory');?>/images/20-map-marker.png" data-marker-width="71" data-marker-height="79"></div>     		
				</div>	
				<!-- end Map -->
				<?php echo wpautop(do_shortcode(htmlspecialchars_decode($address))); ?>
			</div>
		</div>
	</div>	
    <?php  
    }
}