<?php
/* List Block */
if(!class_exists('ST_Price_Table_Block')) {
class ST_Price_Table_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-dollar"></i> Price Table',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_price_table_block', $block_options);
	
	//add ajax functions
	add_action('wp_ajax_aq_block_pricetable_add_new', array($this, 'add_pricetable_item'));
	
	}
	
	function form($instance) {
	
		$defaults = array(
			'title' => 'price',
			'subtitle' =>'',           
			'items' => array(
				1 => array(
					'title' => 'New Pricing Table',
					'apps' => 'Unlimited apps',
					'traffic' => 'Unlimited traffic',
					'statistics' => 'Statistics',
					'email' => '48h email support',
					'primeum' => 'Premium plugins included',
					'description' => '$50, if paid annually',
					'note' => '*Normal price: $1.99 per plugin per month.',
					'cost' => '$5/month',
					'class' => '1'
				)
			),		
            'columm' => '3',
			'title_action' => '',
			'content_action' => '',
			'textlink_action' => '',
			'link_action' => '',
			'close_pricing' => '1'
		);
     
	$instance = wp_parse_args($instance, $defaults);
	extract($instance);
	
		$column_options = array(
            '6' => '2 Column',
            '4' => '3 Column',
            '3' => '4 Column',
            '2' => '6 Column',
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
			<a href="#" rel="pricetable" class="aq-sortable-add-new button">Add New</a>
		<p></p>
	</div>

    <div class="description half">
		<label for="<?php echo $this->get_field_id('columm') ?>">
			Column Per Row <code>default: 4 Columm.</code><br/>
			<?php echo aq_field_select('columm', $block_id, $column_options, $columm, $block_id, $size = 'full') ?>
		</label>
	</div>
	<div class="description half last">
		<label for="<?php echo $this->get_field_id('close_pricing') ?>">
			close pricing <code>default: 1.</code><br/>
			<?php echo aq_field_input('close_pricing', $block_id, $close_pricing, $size = 'full') ?>
		</label>
	</div>
	
	<div class="cf"></div>	
	<h3 style="text-align: center;">Pricing Action</h3>
	<div class="description">
        <label for="<?php echo $this->get_field_id('title_action') ?>">
        Title Pricing Action<br />
        <?php echo aq_field_input('title_action', $block_id, $title_action, $size = 'full') ?>
        </label>
    </div>
	<div class="description">
        <label for="<?php echo $this->get_field_id('content_action') ?>">
        Content Pricing Action<br />
        <?php echo aq_field_textarea('content_action', $block_id, $content_action, $size = 'full') ?>
        </label>
    </div>
	<div class="description half">
        <label for="<?php echo $this->get_field_id('textlink_action') ?>">
        Text Link Pricing Action<br />
        <?php echo aq_field_input('textlink_action', $block_id, $textlink_action, $size = 'full') ?>
        </label>
    </div>
	<div class="description half last">
        <label for="<?php echo $this->get_field_id('link_action') ?>">
        Link Pricing Action<br />
        <?php echo aq_field_input('link_action', $block_id, $link_action, $size = 'full') ?>
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
			<div class="tab-desc description fourth">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title">
					Name<br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][title]" value="<?php echo $item['title'] ?>" />
				</label>
			</div>			
			<div class="tab-desc description fourth">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-apps">
					apps<br/>
					<input type="number" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-apps" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][apps]" value="<?php echo $item['apps'] ?>" />
				</label>
			</div>
			<div class="tab-desc description fourth">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-traffic">
					traffic <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-traffic" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][traffic]" value="<?php echo $item['traffic'] ?>" />
				</label>
			</div>
			<div class="tab-desc description fourth last">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-statistics">
					Statistics <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-statistics" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][statistics]" value="<?php echo $item['statistics'] ?>" />
				</label>
			</div>
			<div class="cf"></div>			
			<div class="tab-desc description fourth">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-primeum">
					Premium <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-primeum" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][primeum]" value="<?php echo $item['primeum'] ?>" />
				</label>
			</div>
			<div class="tab-desc description fourth">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-email">
					 Number Email <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-email" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][email]" value="<?php echo $item['email'] ?>" />
				</label>
			</div>
			<div class="tab-desc description fourth">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-cost">
					Cost/date <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-cost" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][cost]" value="<?php echo $item['cost'] ?>" />
				</label>
			</div>
			<div class="tab-desc description fourth last">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-description">
					Description more <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-description" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][description]" value="<?php echo $item['description'] ?>" />
				</label>
			</div>
			<div class="cf"></div>
			<div class="tab-desc description half">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-note">
					Note <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-note" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][note]" value="<?php echo $item['note'] ?>" />
				</label>
			</div>
			<div class="tab-desc description half last">
				<label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-class">
					class <br/>
					<input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-class" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][class]" value="<?php echo $item['class'] ?>" /><br />
					<code>What price you want to highlight, add this class number to (Ex: 2)</code>
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

$output = '<!-- Close pricing -->
<a id="close-pricing'.$close_pricing.'"><i class="fa fa-compress"></i></a>
<div class="container">
	<!-- heading -->
	<div class="section-heading text-center">
		<h2 class="title"><span>'.esc_attr($title).'</span></h2>
		<p class="subtitle">'.esc_attr($subtitle).'</p>	
	</div>
	<!-- end heading -->
	<div class="row">';	
	
	if($columm == 6){
		$output.='<div class="col-md-10 col-md-offset-1">
				<div class="row">';
	}		
	
    if(!empty($items)){
        $i=1;
        foreach($items as $item){
			
        	$output.='<div class="col-md-'.$columm.' pricing-column pricing-col'.strip_tags($item['class']).'">';
			$output.='<div class="pricing-inner">';
			
				$output.='<h3 class="pricing-title">'.strip_tags($item['title']).'</h3>';
				
				$output.='<div class="services-list">';
				
					$output.=(!empty($item['apps']) ? '<div class="service"><span><i class="fa fa-check-circle"></i> '.strip_tags($item['apps']).'</span></div>' : '' );
					$output.=(!empty($item['traffic']) ? '<div class="service"><span><i class="fa fa-check-circle"></i> '.strip_tags($item['traffic']).'</span></div>' : '' );
					$output.=(!empty($item['statistics']) ? '<div class="service"><span><i class="fa fa-check-circle"></i> '.strip_tags($item['statistics']).'</span></div>' : '' );
					$output.=(!empty($item['primeum']) ? '<div class="service"><span><i class="fa fa-check-circle"></i> '.strip_tags($item['primeum']).'</span></div>' : '' );
					$output.=(!empty($item['email']) ? '<div class="service"><span><i class="fa fa-check-circle"></i> '.strip_tags($item['email']).'</span></div>' : '' );
				$output.='</div>';
				$output.='<div class="cost">';
					$output.=(!empty($item['cost']) ? '<h1>'.strip_tags($item['cost']).'</h1>' : '' );
					$output.=(!empty($item['description']) ? '<p class="cf">'.strip_tags($item['description']).'</p>' : '' );
				$output.='</div>';
				$output.=(!empty($item['note']) ? '<p class="asterix"><strong>*</strong>'.strip_tags($item['note']).'</p>' : '' );
				
			$output.='</div>
		</div>';	

        $i++;
       }
    }
	if($columm == 6){
		$output .= '</div>';
		$output .= '<div class="pricing-action">';
				$output .= '<h2>'.$title_action.'</h2>';
				$output .= '<p>'.htmlspecialchars_decode($content_action).'</p>';
				$output .= '<a  href="'.$link_action.'" class="btn btn-default">'.$textlink_action.'</a>';
		$output .= '</div>';	
		$output .= '</div>';
		$output .= '</div><!-- //ROW -->';		
	}else{
		$output .= '</div><!-- //ROW -->';
		$output .= '<div class="pricing-action">';
				$output .= '<h2>'.$title_action.'</h2>';
				$output .= '<p>'.htmlspecialchars_decode($content_action).'</p>';
				$output .= '<a href="'.$link_action.'" class="btn btn-default">'.$textlink_action.'</a>';
		$output .= '</div>';	
	}
	$output .='</div><!-- //CONTAINER -->';
			
	echo $output;
	
 	}
	/* AJAX add testimonial */
	function add_pricetable_item() {
	$nonce = $_POST['security'];	
	if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
	
	$count = isset($_POST['count']) ? absint($_POST['count']) : false;
	$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
	
	//default key/value for the testimonial
	$item = array(
		'title' => 'New Pricing Table',
		'apps' => 'Unlimited apps',
		'traffic' => 'Unlimited traffic',
		'statistics' => 'Statistics',
		'email' => '48h email support',
		'primeum' => 'Premium plugins included',
		'description' => '$50, if paid annually',
		'note' => '*Normal price: $1.99 per plugin per month.',
		'cost' => '$5/month',
		'class' => '1'
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
