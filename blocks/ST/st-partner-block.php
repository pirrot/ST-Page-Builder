<?php
/* List Block */
if(!class_exists('ST_Partner_Block')) {
class ST_Partner_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-picture-o"></i> Clients image',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_partner_block', $block_options);
	
	//add ajax functions
	add_action('wp_ajax_aq_block_partner_add_new', array($this, 'add_partner_item'));
	
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => 'Title Clients',
			'subtitle' => 'Subtitle Clients',
			'gettext' => 'Get in touch',
			'getlink' => '#contact',
			'items' => array(
				1 => array(
					'title' => 'New Images',
					'photo' => '', 
					'link' => ''                   
				)
			),
            'numimage' => 5,
            'ab'    => 'on',
            'class'    => 'slideshow-clients',
		);
        $onoff = array(
            'true'  => 'On',
            'false' => 'Off',
        );
	
	$instance = wp_parse_args($instance, $defaults);
	extract($instance);
	
	?>
	<div class="description">
        <label for="<?php echo $this->get_field_id('title') ?>">
	        Title Partner
	        <?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
        </label>
    </div>
	
	<div class="description">
        <label for="<?php echo $this->get_field_id('subtitle') ?>">
	        Subtitle Partner
	        <?php echo aq_field_input('subtitle', $block_id, $subtitle, $size = 'full') ?>
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
			<a href="#" rel="partner" class="aq-sortable-add-new button">Add New</a>
		<p></p>
	</div>
	<div class="description half">
		<label for="<?php echo $this->get_field_id('gettext') ?>">
			Get in touch text<br/>
			<?php echo aq_field_input('gettext', $block_id, $gettext, $size = 'full') ?>
		</label>
	</div>
	<div class="description half last">
		<label for="<?php echo $this->get_field_id('getlink') ?>">
			Get in touch link<br/>
			<?php echo aq_field_input('getlink', $block_id, $getlink, $size = 'full') ?>
		</label>
	</div>
	<div class="cf"></div>
    <div class="description third">
		<label for="<?php echo $this->get_field_id('class') ?>">
			class for slide<br/>
			<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
		</label>
	</div>
    <div class="description third">
		<label for="<?php echo $this->get_field_id('numimage') ?>">
			Visible Items<br/>
			<?php echo aq_field_input('numimage', $block_id, $numimage, $size = 'full',$type='number') ?>
		</label>
	</div>
    <div class="description third last">
        <label for="<?php echo $this->get_field_id('ab') ?>">
            On or Off Slider<br />
            <?php echo aq_field_select('ab', $block_id, $onoff, $ab, $size='full')?>      
        </label>
    </div>
	<div class="cf"></div>
	<?php
	}
	
	function item($item = array(), $count = 0) {
	
	?>
	<li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
		<div class="sortable-head cf">
			<div class="sortable-title">
				<strong><?php echo $item['title'] ?></strong>
			</div>
			<div class="sortable-handle">
				<a href="#">Open / Close</a>
			</div>
		</div>
		<div class="sortable-body">
			<div class="tab-desc description">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title">
					Name<br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
				</label>
			</div>

			<div class="tab-desc description">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo">
					Photo <em style="font-size: 0.8em;">(Recommended size: 200 x 200 pixel)</em><br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo" class="input-full input-upload" value="<?php echo $item['photo'] ?>" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][photo]">
					<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
				</label>
			</div>
			<div class="tab-desc description">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-link">
					Link to Website Client<br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-link" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][link]" value="<?php echo $item['link'] ?>" />
				</label>
			</div>
		
		<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
		</div>
	</li>
	<?php
	}
	
	function block($instance) {
	extract($instance);
	$title1 = (!empty($title) ? ' '.esc_attr($title) : '');  
    $subtitle1 = (!empty($subtitle) ? ' '.esc_attr($subtitle) : ''); 
	$gettext1 = (!empty($gettext) ? ' '.esc_attr($gettext) : '');  
    $getlink1 = (!empty($getlink) ? ' '.esc_attr($getlink) : ''); 
	
	$output = '';
	
	$output .= '<div class="container">
		<div class="section-heading mini text-center" data-animated="fadeInDown">
			<h4 class="title"><span>'.$title1.'</span></h4>
			<p class="subtitle">'.$subtitle1.'<a href="'.$getlink1.'">'.$gettext1.'</a></p>
		</div>
		<ul class="'.strip_tags($class).' list-unstyled">';
			if(!empty($items)){
                foreach($items as $item){
					$output.='<li>'.(!empty($item['link']) ? '<a href="'.strip_tags($item['link']).'">' : '').'<img src="'.esc_url($item['photo']).'" alt=""/>'.(!empty($item['link']) ? '</a>' : '').'</li>';   
				}
            }	
		$output.='</ul>		
	</div>';

	echo $output;
	?>
		<script>
			//jQuery(document).ready()
			jQuery(document).ready(function() {
				/* Slideshow: Clients
				-------------------------*/
				clientsContainer = jQuery('.<?php echo strip_tags($class); ?>').closest('.container').width();
				// Number of clients to show at once (according to device width)
				if (windowWidth < 768) {
					var slidesAtOnce = 2; // Mobile devices
				}
				else if (windowWidth >= 768 && windowWidth < 1200) {
					var slidesAtOnce = 3; // Tablet and desktos with a screen smaller than 1200px
				}
				else if (windowWidth >= 1200) {
					var slidesAtOnce = 5; // Desktops with a width of 1200px and above
				}
				slideWidthCustom = Math.round(clientsContainer / slidesAtOnce);
				var clientSlider = jQuery('.<?php echo strip_tags($class); ?>').bxSlider({
					infiniteLoop: false,
					hideControlOnEnd: true,
				  minSlides: slidesAtOnce,
				  maxSlides: slidesAtOnce,
				  slideWidth:slideWidthCustom,
				  slideMargin:10,
				  prevText: '<i class="fa fa-angle-left"></i>',
				  nextText: '<i class="fa fa-angle-right"></i>',
				  pager: false,
				  oneToOneTouch: false
				});

			});
		</script>
	<?php
	 }

	/* AJAX add testimonial */
	function add_partner_item() {
	$nonce = $_POST['security'];	
	if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
	
	$count = isset($_POST['count']) ? absint($_POST['count']) : false;
	$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
	
	//default key/value for the testimonial
	$item = array(
		'title' => 'New Images',
		'photo' => '',
		'link' => '' 
	);
	
	if($count) {
		$this->item($item, $count);
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