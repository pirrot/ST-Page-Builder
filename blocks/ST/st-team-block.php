<?php
/* ourteam Block */
if(!class_exists('ST_Team_Block')) {
class ST_Team_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-group"></i> Our Team',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_team_block', $block_options);
	
	//add ajax functions
	add_action('wp_ajax_aq_block_check4_add_new', array($this, 'add_check4_item'));

}
   function form($instance){
        $defaults = array(
			'title' => '', 
			'subtitle' =>'', 
            'items' => array(
	            	1 => array(
			            'name' => 'New Team',
			            'job' => '',		            
			            'content' => '',
			            'photo' => '',
			            'facebook' => '',
			            'twitter' => '',
			            'googleplus' => '',
			            'linkedin' => '',
		            )
            	),
            ); 
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
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
	    	<a href="#" rel="check4" class="aq-sortable-add-new button">Add New Team</a>
	    <p></p>
    </div>    
            
    <?php        }
    
    function item($item = array(), $count = 0) {
        ?>
     <li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
        <div class="sortable-head cf">
            <div class="sortable-title">
            	<strong><?php echo $item['name'] ?></strong>
            </div>
            <div class="sortable-handle">
            	<a href="#">Open / Close</a>
            </div>
        </div>
        <div class="sortable-body">
            <div class="tab-desc description half">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-name">
                Name<br/><em style="font-size: 0.8em;">(Please enter name)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-name" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][name]" value="<?php echo $item['name'] ?>" />
                </label>
            </div>
            <div class="tab-desc description half last">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-job">
                Job<br/><em style="font-size: 0.8em;">(Please enter job)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-job" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][job]" value="<?php echo $item['job'] ?>" />
                </label>
            </div>         
           	<div class="tab-desc description">
        		<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo">
        			Photo <em style="font-size: 0.8em;">(Recommended size: 50 x 50 pixel)</em><br/>
        			<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-photo" class="input-full input-upload" value="<?php echo $item['photo'] ?>" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][photo]">
        			<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
        		</label>
        	</div>
            <div class="tab-desc description">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content">
                Content<br/><em style="font-size: 0.8em;">(Please enter content)</em><br/>
                <textarea id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][content]" ><?php echo $item['content'] ?></textarea>
                </label>
            </div>
     
            <div class="tab-desc description fourth">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-facebook">
                Facebook<br/><em style="font-size: 0.8em;">(Example: https://www.facebook.com/user)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-facebook" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][facebook]" value="<?php echo $item['facebook'] ?>" />
                </label>
            </div>
            <div class="tab-desc description fourth">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-twitter">
                Twitter<br/><em style="font-size: 0.8em;">(Example: https://www.twitter.com/user)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-twitter" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][twitter]" value="<?php echo $item['twitter'] ?>" />
                </label>
            </div>
            <div class="tab-desc description fourth">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-googleplus">
                Google Plus<br/><em style="font-size: 0.8em;">(Example: https://plus.google.com/u/0/116236036606523490579)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-googleplus" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][googleplus]" value="<?php echo $item['googleplus'] ?>" />
                </label>
            </div>
            <div class="tab-desc description fourth last">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-linkedin">
                linked in<br/><em style="font-size: 0.8em;">(Example: https://www.linkedin.com/user)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-linkedin" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][linkedin]" value="<?php echo $item['linkedin'] ?>" />
                </label>
            </div>
            <p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
            <div class="cf"> </div> 
        </div>
    </li>   
        <?php
        }    
      function block($instance){
    extract($instance); 
	
    $output ='';
	
    $output.='<div class="container">
		<!-- Heading -->
		<div class="section-heading text-center picture" data-animated="fadeInDown">
			<h1 class="title"><span>'.esc_attr($title).'</span></h1>
			<p class="subtitle">'.esc_attr($subtitle).'</p>	
		</div>
		<!-- end Heading -->';
		
		$output.='<div id="team-members" class="slider">
			<ul class="slides">';	
	
	if(!empty($items)){
		
    foreach($items as $item){
		
        $output .='<li class="pane">
				<div class="details">';
		
		$output.='<div class="identifier">';
		$output.=(!empty($item['name']) ? '<h3 class="name">'.htmlspecialchars_decode($item['name']).'</h3>' : ''); 
        $output.=(!empty($item['job']) ? '<h4 class="subheading">'.htmlspecialchars_decode($item['job']).'</h4>' : '');
		$output.='</div>';
		$output.=(!empty($item['content']) ? '<div class="text-content">'.wpautop(do_shortcode(htmlspecialchars_decode($item['content']))).'</div>' : ''); 
        $output.=(!empty($item['twitter']) ? '<a href="'.esc_url($item['twitter']).'" target="_blank" class="more"><i class="fa fa-twitter"></i></a>' : '');
        $output.=(!empty($item['facebook']) ? '<a href="'.esc_url($item['facebook']).'" target="_blank" class="more"><i class="fa fa-facebook"></i></a>' : '');
        $output.=(!empty($item['googleplus']) ? '<a href="'.esc_url($item['googleplus']).'" target="_blank" class="more"><i class="fa fa-google-plus"></i></a>' : '');
        $output.=(!empty($item['linkedin']) ? '<a href="'.esc_url($item['linkedin']).'" target="_blank" class="more"><i class="fa fa-linkedin"></i></a>' : ''); 
		
        $output.='</div>
			  </li>';      
    }
	
	
    $output.='</ul>
			<ul class="flex-direction-nav">
			  <li><a class="flex-prev" href="#"><i class="fa fa-caret-left"></i></a></li>
			  <li><a class="flex-next" href="#"><i class="fa fa-caret-right"></i></a></li>
			</ul>
		</div>';
	$output.='<ul class="team-nav">';
	foreach($items as $item){
	$image = (!empty($item['photo']) ? esc_url($item['photo']) : '');	
	$output.='<li><a href="#" class="member-node"><img src="'.$image.'" alt="Our Team" class="nav-pic"></a></li>';
	}
	$output.='</ul>';
	}	
	$output.='</div><!-- End .container -->';	
    echo $output;
	
   	}
    function add_check4_item() {
    $nonce = $_POST['security'];	
    if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
    
    $count = isset($_POST['count']) ? absint($_POST['count']) : false;
    $this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
    
    //default key/value for the testimonial
    $item = array(
            'name' => 'New Team',
            'job' => '',           
            'content' => '',
            'photo' => '',
            'facebook' => '',
            'twitter' => '',
            'googleplus' => '',
            'linkedin' => '',
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