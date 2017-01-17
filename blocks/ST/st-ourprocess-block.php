<?php 
class ST_Ourprocess_Block extends AQ_Block{
    function __construct(){
        $block_option=array(
            'name' => '<i class="fa fa-indent"></i> OurProcess',
            'size' => 'col-md-12',
        );
        parent::__construct('st_ourprocess_block', $block_option);
        add_action('wp_ajax_aq_block_ourprocess_add_new', array($this, 'add_ourprocess_item'));
    }
    function form($instance){
        $defaults =array(
        'title' => 'Title Our Process',
        'subtitle'   => 'Subtitle Our Process',	
        'items'=> array(
            1=>array(
	            'title' => 'New Process',
	            'content' => 'New Content Process',
	            'icon'  => 'tint',
            )
        ),
		'columm' => '3'
        );        
        $instance=wp_parse_args($instance,$defaults);
        extract($instance);
		
		$columm_options = array(
			'2' => '6 Columm',
			'3' => '4 Columm',
			'4' => '3 Columm',
			'6' => '2 Columm',
		);
		
    ?>    
     <div class="descriptions">
        <label for="<?php echo $this->get_field_id('title') ?>">
	    	Title:
	    	<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
	    </label>
    </div>
	
	<div class="descriptions">
        <label for="<?php echo $this->get_field_id('subtitle') ?>">
	    	Subtitle:
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
	    	<a href="#" rel="ourprocess" class="aq-sortable-add-new button">Add New</a>
	    <p></p>
    </div>
	
	<div class="description">
		<label for="<?php echo $this->get_field_id('columm') ?>">
			Selected Columm / Row <code>Default: 4 Columm / Row.</code><br/>
			<?php echo aq_field_select('columm', $block_id, $columm_options, $columm) ?>
		</label>
	</div>
    
    <?php }
    
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
				    Name Process<br/>
				    <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
			    </label>
		    </div>
		    <div class="tab-desc description">
			    <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
				    Content Process<br/>
				    <textarea id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $item['content'] ?></textarea>
			    </label>
		    </div>
		    <div class="tab-desc description">
		        <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon">
		            Icon class name <code>Ex: globe</code><a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/"> view more icon </a><br/>
		            <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-icon" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][icon]" value="<?php echo $item['icon'] ?>" />
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
    $output .= '<!--background overlay-->
		<div class="background-overlay"></div>
		<!-- end background overlay-->
		<div id="bgcolor_process" style="width: 100%; position: relative;z-index: 11;">
			<!--process heading-->
			<div class="section-heading mini text-center" data-animated="fadeInDown">
				<h4 class="title" style="font-size: 1em;"><span>'.esc_attr($title).'</span></h4>
				<p class="subtitle" style="font-size: 0.6em;">'.esc_attr($subtitle).'</p>
			</div>
			<!--end process heading-->
		</div>
		<!--process container-->
		<div class="container">
			<div class="row clearfix">';
			
            if(!empty($items)){
                foreach($items as $item){
			$output.='<div class="col-md-'.esc_attr($columm).' col-sm-6 col process">
					<header data-animated="bounceIn">
						<h5><i class="fa fa-caret-right"></i> '.htmlspecialchars_decode($item['title']).' <i class="fa fa-caret-left"></i></h5>
						'.(!empty($item['icon']) ? '<span><i class="fa fa-'.esc_attr($item['icon']).'"></i></span>' : '').'
						<p>'.htmlspecialchars_decode($item['content']).'</p>
					</header>
					<div class="circle"></div>
				</div>';		
              }
         }
		$output.='</div>
			</div>';
		
    echo $output;
	
	}
    function add_ourprocess_item() {
    $nonce = $_POST['security'];	
    if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
    
    $count = isset($_POST['count']) ? absint($_POST['count']) : false;
    $this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
    
    //default key/value for the testimonial
    $item = array(
	    'title' => 'New Process',
        'content' => 'New Content Process',
        'icon'  => 'tint',
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
