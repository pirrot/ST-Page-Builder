<?php
/* List Block */
if(!class_exists('ST_Timeline_Block')) {
class ST_Timeline_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-signal"></i> Timeline',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_timeline_block', $block_options);
	
	//add ajax functions
	add_action('wp_ajax_aq_block_test4_add_new', array($this, 'add_test4_item'));
	
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => 'Title Time Line',
			'subtitle' =>'', 
			'description' =>'', 
			'items' => array(
				1 => array(
					'title' => 'New Timeline',
					'photo' => '',	
                    'year'  => 2007,
                    'content'   =>'',				
				)
			),
		);
	
	$instance = wp_parse_args($instance, $defaults);
	extract($instance);
	
	?>	
	 <div class="description">
        <label for="<?php echo $this->get_field_id('title') ?>">
        Title <br />
        <?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
        </label>
    </div>
	
	<div class="description">
        <label for="<?php echo $this->get_field_id('subtitle') ?>">
        Subtitle <br />
        <?php echo aq_field_input('subtitle', $block_id, $subtitle, $size = 'full') ?>
        </label>
    </div>
	
	<div class="description">
        <label for="<?php echo $this->get_field_id('description') ?>">
        Description <br />
		<?php echo aq_field_textarea('description', $block_id, $description, $size = 'full') ?>
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
			<a href="#" rel="test4" class="aq-sortable-add-new button">Add New</a>
		<p></p>
	</div>
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
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-year">
			Year<br/>
			<input type="number" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-month" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][year]" value="<?php echo $item['year'] ?>" />     
		</label>
	</div>
	
	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo">
			Photo <em style="font-size: 0.8em;">(Recommended size: 256 x 256 pixel)</em><br/>
			<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo" class="input-full input-upload" value="<?php echo $item['photo'] ?>" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][photo]">
			<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
		</label>
	</div>
	<div class="cf"></div>
	<div class="tab-desc description half">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title">
			Title<br/>
			<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
		</label>
	</div>
	<div class="tab-desc description half last">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
			Content<br/>
			<textarea id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $item['content'] ?></textarea>
		</label>
	</div>	
	<div class="cf"></div>
	<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
	</div>
	</li>
	
	<?php
	}
	
	function block($instance) {
	extract($instance);
	
	$output = '';
	
	$output = '<div class="container">
		<div class="row">';
		
	$output.='<!-- Timeline heading -->
			<div class="col-md-4 history">
				<div class="section-heading text-center">';
				
					$output.='<h1 class="title"><span>'.htmlspecialchars_decode($title).'</span></h1>';
					$output.='<p class="subtitle">'.htmlspecialchars_decode($subtitle).'</p>';
					
				$output.='</div>';
				$output.='<p class="text-center">'.htmlspecialchars_decode($description).'</p>';
				$output.='<h1 class="calender"><i class="fa fa-calendar-o"></i></h1>
			</div>
			<!-- end Timeline heading -->';	
			
			$output.='<!-- Timeline -->
			<div class="col-md-8">
				<div id="timeline">';
	
				if (!empty($items)) {  
				  	$output.='<ul id="dates">';
						$i = 1;
	    				foreach( $items as $item ) {
							$output .= '<li><a href="#year'.$i.'">'.strip_tags($item['year']).'</a></li>'; 
						$i++;	        
						}
					$output.='</ul>';
					
					$output.='<ul id="issues">';
					$j = 1;
					foreach( $items as $item ) {
						$output.='
							<li id="year'.$j.'">
							<img src="'.esc_url($item['photo']).'" height="256" width="256" alt="">
							<h1>'.strip_tags($item['title']).'</h1>
							<p>'.htmlspecialchars_decode($item['content']).'</p>
						</li>
						';
						$j++;
					}
					$output.='</ul>';
    	   		}
				$output .= '<div id="grad_top"></div>
				<div id="grad_bottom"></div>
				<a style="display: block;" href="#" id="next">+</a>
				<a style="display: block;" href="#" id="prev">-</a>
			</div>
			</div>
			<!-- end Timeline -->';
	$output.='</div>
			</div>';
			
	echo $output;

	}
	/* AJAX add testimonial */
	function add_test4_item() {
	$nonce = $_POST['security'];	
	if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
	
	$count = isset($_POST['count']) ? absint($_POST['count']) : false;
	$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
	
	//default key/value for the testimonial
	$item = array(
		'title' => 'New Timeline',
		'photo' => '',	
        'year'  => 2007,
        'content'   =>'',	
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