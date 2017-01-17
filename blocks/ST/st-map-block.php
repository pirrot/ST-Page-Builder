<?php
/** Contact Form Block **/

class ST_Map_Block extends AQ_Block {

    //set and create block
    function __construct() {
        $block_options = array(
            'name' => '<i class="fa fa-arrows"></i> Google Map',
            'size' => 'col-md-6',
        );

        //create the block
        parent::__construct('st_map_block', $block_options);
    }

    function form($instance) { 
				
        $defaults = array(
			'title' => '',
			'address' => '',
			'longitude' => '',
			'latitude' => '',
        ); 
        $instance = wp_parse_args($instance, $defaults);
        extract( $instance);

        ?>
        
		<div class="description">
			<label for="<?php echo $block_id ?>_title">
				Title (optional)<br/>
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
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
		<div class="custom-heading text-center">
			<h2 class="title"><span><?php echo $title; ?></span></h2>
		</div>
		<div class="map">
		<!-- Map -->
		<div id="map" class="googlemap" data-position-latitude="<?php echo $latitude; ?> " data-position-longitude="<?php echo $longitude; ?>" data-marker-img="<?php echo get_bloginfo('template_directory');?>/images/20-map-marker.png" data-marker-width="71" data-marker-height="79"></div>     		
		<div class="address" data-animated="fadeInDown">
			<?php echo wpautop(do_shortcode(htmlspecialchars_decode($address))); ?>
		</div>
		</div>
		
    <?php  
    }
}