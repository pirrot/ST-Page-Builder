<?php
/* List Block */
if(!class_exists('ST_Banner_Block')) {
class ST_Banner_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-spinner"></i> Banner Slider',
		'size' => 'col-md-12',
	);

	//create the widget
	parent::__construct('st_banner_block', $block_options);
	
	//add ajax functions
	add_action('wp_ajax_aq_block_check2_add_new', array($this, 'add_check2_item'));
	add_action('wp_ajax_aq_block_check3_add_new', array($this, 'add_check3_slide'));
	}
   function form($instance){
        $defaults = array(
            'title' => '',
            'items' => array(
            1 => array(
            'desc' => 'New Desc',
            )
            ),
            'messageHeader' => 'We design',
            'messageHeader1' => 'Creative',
            'messageHeader2' => 'we what we do!',
            'logo' => '', 
            'more' => '',
            'linkmore' => '',
            'image' => '',
            'length' => '',
            'speed' => '',
            'effect' => '',
            'chosen' => '',
            'slides' => array(
            1 => array(
            'slide_img' => '',
            )
            ),
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
            $effect_options = array(
				'0' => 'None',
				'1' => 'Fade',
				'2' => 'Slide Top',
				'3' => 'Slide Right',
				'4' => 'Slide Bottom',
                '5' => 'Slide Left',
                '6' => 'Carousel Right',
                '7' => 'Carousel Left',
			);  
            $chosen_options = array(
                'slide' => 'Slider multi Image',
                'image' => 'Only One Image',
            ); 
        ?>
    <h3 style="text-align: center;">Overview</h3>
   	<div class="description">
		<label for="<?php echo $this->get_field_id('title') ?>">
			Title
			<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
		</label>
	</div>
	<div class="description">
		<label for="<?php echo $this->get_field_id('logo') ?>">
			Logo
			<?php echo aq_field_upload('logo', $block_id, $logo, $media_type = 'image') ?>
		</label>
	</div>
	<div class="cf"></div>
	<div class="description third">
		<label for="<?php echo $this->get_field_id('messageHeader') ?>">
			Message header 1
			<?php echo aq_field_input('messageHeader', $block_id, $messageHeader, $size = 'full') ?>
		</label>
	</div>
	<div class="description third">
		<label for="<?php echo $this->get_field_id('messageHeader1') ?>">
			Message header 2
			<?php echo aq_field_input('messageHeader1', $block_id, $messageHeader1, $size = 'full') ?>
		</label>
	</div>
	<div class="description third last">
		<label for="<?php echo $this->get_field_id('messageHeader2') ?>">
			Message header 3
			<?php echo aq_field_input('messageHeader2', $block_id, $messageHeader2, $size = 'full') ?>
		</label>
	</div>
    <div class="cf"></div>
    <div class="description cf">
	    <ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
			<?php
				$items = is_array($items) ? $items : $defaults['items'];
				$count = 1;
				foreach($items as $item) {	
					$this->item($item, $count);
					$count++;
				}
			?>
	    </ul>
	    <p></p>
	    	<a href="#" rel="check2" class="aq-sortable-add-new button">Add New Desc</a>
	    <p></p>
    </div>
   
     <h3 style="text-align: center;">Button More</h3>
	<div class="description">
		<label for="<?php echo $this->get_field_id('linkmore') ?>">
			Link More<br/><em style="font-size: 0.8em;">(Example: #about)</em><br/>
			<?php echo aq_field_input('linkmore', $block_id, $linkmore, $size = 'full') ?>
		</label>
	</div>
    <div class="cf"></div>
 
     <h3 style="text-align: center;">Slider Image</h3>
    <br />
    <div class="description cf">
	    <ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
			<?php
				$slides = is_array($slides) ? $slides : $defaults['slides'];
				$count = 1;
				foreach($slides as $slide) {	
					$this->slide($slide, $count);
					$count++;
				}
			?>
	    </ul>
	    <p></p>
	    	<a href="#" rel="check3" class="aq-sortable-add-new button">Add New Slide</a>
	    <p></p>
    </div>  
     
	<div class="description third">
		<label for="<?php echo $this->get_field_id('length') ?>">
			Length<br/><em style="font-size: 0.8em;">(Default : 4000)</em><br/>
			<?php echo aq_field_input('length', $block_id, $length, $size = 'full') ?>
		</label>
	</div>
	<div class="description third">
		<label for="<?php echo $this->get_field_id('speed') ?>">
			Speed<br/><em style="font-size: 0.8em;">(Default : 1200)</em><br/>
			<?php echo aq_field_input('speed', $block_id, $speed, $size = 'full') ?>
		</label>
	</div>
	<div class="description third last">
    	<label for="<?php echo $this->get_field_id('effect') ?>">
    	Effect<br/><em style="font-size: 0.8em;">(Chosen a effect)</em><br/>
    	<?php echo aq_field_select('effect', $block_id, $effect_options, $effect) ?>
    	</label>
	</div>
	
    <br />
    <h3 style="text-align: center;">Image</h3>
    <br />
	<div class="description">
		<label for="<?php echo $this->get_field_id('image') ?>">
			Image
			<?php echo aq_field_upload('image', $block_id, $image, $media_type = 'image') ?>
		</label>
	</div>
      
  	<div class="description">
    	<label for="<?php echo $this->get_field_id('chosen') ?>">
	    	Chosen Type Banner <br/>
	    	<?php echo aq_field_select('chosen', $block_id, $chosen_options, $chosen) ?>
    	</label>
	</div>  
      <?php   
        }
		function item($item = array(), $count = 0) {

		?>
		<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
			<div class="sortable-head cf">
				<div class="sortable-title">
					<strong><?php echo $item['desc'] ?></strong>
				</div>
				<div class="sortable-handle">
					<a href="#">Open / Close</a>
				</div>
			</div>
			<div class="sortable-body">
				<div class="tab-desc description">
					<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-desc">
						Desc<br/>
						<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-desc" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][desc]" value="<?php echo $item['desc'] ?>" />
					</label>
				</div>
				<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
			</div>
		</li>

  <?php  
    }
	function slide($slide = array(), $count = 0) {

	?>
	<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
	<div class="sortable-head cf">
		<div class="sortable-title">
			<strong>Slider Image</strong>
		</div>
		<div class="sortable-handle">
			<a href="#">Open / Close</a>
		</div>
	</div>
	<div class="sortable-body">
		<div class="tab-desc description">
			<label for="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-photo">
				Photo <em style="font-size: 0.8em;">(Recommended size: 1920 x 1100 pixel)</em><br/>
				<input type="text" id="<?php echo $this->get_field_id('slides') ?>-<?php echo $count ?>-photo" class="input-full input-upload" value="<?php echo $slide['slide_img'] ?>" name="<?php echo $this->get_field_name('slides') ?>[<?php echo $count ?>][slide_img]">
				<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
			</label>
		</div>
	<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
	</div>
	</li>

  <?php  
    }
   function block($instance){
   extract($instance);        
   $title = (!empty($title) ? ' '.esc_attr($title) : '');    
   $image = (!empty($image) ? ' '.esc_url($image) : ''); 
   $output ='';
   $banner ='';
   
   $output ='<!-- Home banner section -->
	<div id="home">
		<ul class="home-banner slideshow-home">
			<!-- Home parallax background -->';
 
   switch($chosen){
    case 'image':
    $banner.=' <li class="parallax bg1" data-stellar-background-ratio="0.5" style="background-image:url('.$image.')!important;">';
    break;
    case 'slide':
    $banner.='<li class="parallax">';
   }
   $output.= $banner;
   $output.='<!-- background overlay pattern -->
			<div class="background-overlay"></div>
			<div class="wrapper">
				<div class="inner">
					<div class="container">
					<div class="centerContent">
							<!-- floating logo -->
							<div class="logo float">
								<div class="thread"></div>';
    $output.=(!empty($logo) ? '<img src="'.esc_url($logo).'" alt="">' : '');                              
					$output.='	</div>
								<!-- end floating logo -->
								<!-- typer -->
								<div class="message">';
	$output.='<h1 class="messageHeader"><span class="purple">'.do_shortcode(htmlspecialchars_decode($messageHeader)).'</span></h1>
								<h1 class="messageHeader tlt">	 
	<span class="purple">'.do_shortcode(htmlspecialchars_decode($messageHeader1)).' <span data-typer-targets=" ';
			
    foreach($items as $item){
    	
      $output.=(!empty($item['desc']) ? esc_attr($item['desc']).', ' : ''); 
      //$output.='websites, Strategy, Parallax';     
    }             
    $output.=' "></span></span></h1>
    			<h3 class="messageHeader"><span class="purple">'.do_shortcode(htmlspecialchars_decode($messageHeader2)).'</span></h3>
							</div>						
							<!-- end typer -->
						</div>
						
						<div class="clearfix"></div>
						<!-- Go button -->
						<div class="go">';
    
	//$output.=(!empty($more) ? '	<a href="" class="btn btn-outline-white btn-small btnmore">'.esc_attr($more).'</a>' : '');				
	$output.='<a href="'.(!empty($more) ? esc_attr($linkmore) : '#about').'"><i class="fa fa-chevron-down"></i></a>';
	$output.='				</div>
							<!-- end go button -->
						</div>						
					</div>
				</div>';
	$output.='</li>
			<!-- end Home parallax background -->
		</ul>
	</div>
	<!-- End Home banner section -->';
	
	echo $output;

	?>
		<script>
 			jQuery(function($){
 				"use strict";
				$.supersized({
					// Functionality
					slide_interval          :   <?php if($length){echo $length;}else{echo 4000;}?>,		
					transition              :   <?php echo $effect;?>, 			
					transition_speed		:	<?php if($speed){echo $speed;}else{echo 1200;}?>,					
					keyboard_nav            :   0,
					// Components							
					slide_links				:	'blank',
					slides 					:  	[ <?php $slide1 = '';
                    foreach($slides as $slide){	
                        if($slide['slide_img']){ ?>
						{image : '<?php echo esc_url($slide['slide_img'])?>'},																	
                                 <?php }}?>         ]
                });
		    });
		</script>
	<?php
}
function add_check2_item() {
	$nonce = $_POST['security'];	
	if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
	
	$count = isset($_POST['count']) ? absint($_POST['count']) : false;
	$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
	
	//default key/value for the testimonial
	$item = array(
		'desc' => 'New Desc',
	);
	
	if($count) {
		$this->item($item, $count);
	} else {
		die(-1);
	}
	die();
}

function add_check3_slide() {
	$nonce = $_POST['security'];	
	if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
	
	$count = isset($_POST['count']) ? absint($_POST['count']) : false;
	$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
	
	//default key/value for the testimonial
	$slide = array(
		'slide_img' => '',
	);
	
	if($count) {
		$this->slide($slide, $count);
	} else {
		die(-1);
	}
	die();
}


function update($new_instance, $old_instance) {
		$new_instance = aq_recursive_sanitize($new_instance);
		return $new_instance;
	}
}
}