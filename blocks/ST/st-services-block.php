<?php
/* List Block */
if(!class_exists('ST_Services_Block')) {
class ST_Services_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-cogs"></i> Services',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_services_block', $block_options);
	
	//add ajax functions
	add_action('wp_ajax_aq_block_services_add_new', array($this, 'add_services_item'));
	
	}
	
   function form($instance){
        $defaults = array(
            'title' => '', 
			'subtitle' =>'',          
            'items' => array(
	            1 => array(
		            'title' => 'New Title Service',
					'subtitle' => 'New Subtitle Service',
		            'icon' => 'globe',
		            'content' => 'New content service',
					'linkitem' => '#',
					'textlink' => 'Text link',
					'idpricingtable' => ''
	            )
            ),
			'columm' => '4'
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
		
		$columm_options = array (
			'6' => 'columm 2',
			'4' => 'columm 3',
			'3' => 'columm 4',
			'2' => 'columm 6'
		);
	?>

    <div class="description">
        <label for="<?php echo $this->get_field_id('title') ?>">
        Title
        <?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
        </label>
    </div>
	
	<div class="description">
        <label for="<?php echo $this->get_field_id('subtitle') ?>">
        Subtitle
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
	    	<a href="#" rel="services" class="aq-sortable-add-new button">Add New</a>
	    <p></p>
    </div>
	<div class="description">
		<label for="<?php echo $this->get_field_id('columm') ?>">
			Selected Columm / Row <code>Default: 3 Columm / Row.</code><br/>
			<?php echo aq_field_select('columm', $block_id, $columm_options, $columm) ?>
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
			Title<br/>
	<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
		</label>
	</div>
	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-subtitle">
			Subtitle<br/>
	<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-subtitle" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][subtitle]" value="<?php echo $item['subtitle'] ?>" />
		</label>
	</div>
	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon">
			Icon class name <code>Ex: globe</code><a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/"> view more icon </a><br/>
			<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][icon]" value="<?php echo $item['icon'] ?>" />
		</label>
	</div>

	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
			Content item service<br/>
			<textarea id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $item['content'] ?></textarea>
		</label>
	</div>
	
	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-textlink">
			Text Link Service<br/>
	<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-textlink" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][textlink]" value="<?php echo $item['textlink'] ?>" />
		</label>
	</div>
	
	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-linkitem">
			Link Item Service <code>Ex: show-pricingtable1</code><br/>
			<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-linkitem" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][linkitem]" value="<?php echo $item['linkitem'] ?>" />
		</label>
	</div>
	
	<div class="tab-desc description">
		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-idpricingtable">
			Id Item Service for show Pricing Table <code>Ex: http://shinetheme.com/</code><br/>
			<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-idpricingtable" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][idpricingtable]" value="<?php echo $item['idpricingtable'] ?>" />
		</label>
	</div>
	
	<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
	</div>
	</li>

  <?php  
    }
	
    function block($instance){
    extract($instance);
		 $output = '';
		 
		 $output.= '<div class="container">';
		 $output.= '<!-- heading -->
					<div class="section-heading text-center" data-animated="fadeInDown">
						<h2 class="title"><span>'.esc_attr($title).'</span></h2>
						<p class="subtitle">'.esc_attr($subtitle).'</p>			
					</div>
					<!-- end heading -->';
		$output.='<!--Service 4 col block-->
				<div class="row">'; 
				
		if (!empty($items)) {
			foreach( $items as $item ) {
			   $output.='<div class="col-lg-'.esc_attr($columm).' service">
							<div class="service-title">
								'.(!empty($item['title']) ? '<h3 class="title">'.htmlspecialchars_decode($item['title']).'</h3>' : '').'
								'.(!empty($item['icon']) ? '<i class="fa fa-'.esc_attr($item['icon']).'"></i>' : '').'
							</div>
							<p class="description">
								<span class="service-subtitle">'.htmlspecialchars_decode($item['subtitle']).'</span>
								'.$item['content'].'
							</p>
							<a id="'.esc_attr($item['idpricingtable']).'" href="'.esc_attr($item['linkitem']).'" class="btn btn-default">'.esc_attr($item['textlink']).'</a>
						</div>';
		    	}   
			}		 
			
			$output.='</div>
				</div>';
			
		  echo $output;
		  
		    }
		/* AJAX add testimonial */
		function add_services_item() {
		$nonce = $_POST['security'];	
		if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
		
		$count = isset($_POST['count']) ? absint($_POST['count']) : false;
		$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
		
		//default key/value for the testimonial
		$item = array(
			'title' => 'New Title Service',
			'subtitle' => 'New Subtitle Service',
            'icon' => 'globe',
            'content' => 'New content service',
			'linkitem' => '#',
			'textlink' => 'Text link',
			'idpricingtable' => ''
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