<?php
/** "Container Open" block
 * This is tag open "<div class="container">".
**/
class ST_Container_Open_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => '<i class="fa fa-chevron-left"></i> Container(Open)',
			'size' => 'col-md-12',
			'resizable' => 0
		);
		
		//create the block
		parent::__construct('st_container_open_block', $block_options);
	}
	
	//form header
	function before_form($instance) {
		extract($instance);
		
		$title = $title ? '<span class="in-block-title"> : '.$title.'</span>' : '';
		$resizable = $resizable ? '' : 'not-resizable';
		
		echo '<li id="template-block-'.$number.'" class="block block-'.$id_base.' '. $size .' '.$resizable.'">',
				'<dl class="block-bar">',
					'<dt class="block-handle">',
						'<div class="block-title">',
							$name , $title, 
						'</div>',
						'<span class="block-controls">',
							'<a class="block-edit" id="edit-'.$number.'" title="Edit Block" href="#block-settings-'.$number.'">Edit Block</a>',
						'</span>',
					'</dt>',
				'</dl>',
				'<div class="block-settings cf" id="block-settings-'.$number.'">';
	}
	
	function form($instance) {
		$defaults = array(
			'text' => '',
			'wp_autop' => 0,
			'bgimage' => '',
			'bgcolor' => '#F8F8F8',
			'textcolor'	=> '#545454',
			'id' => '',
			'class' => '',
			'style' => '',
			'taghtml' => '',
			'checkbg' => '',
			'checktag' => '',
			'idclass1' => '',
			'idclass2' => '',
			'taghtml1' => '',
			'style1' => '',
			'paddtop' => 0,
			'paddbottom' => 0,
			'marginbottom' => 0
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance, EXTR_OVERWRITE);
		
		$block_id = 'aq_block_' . $number;
		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';
		?>
		<div class="description third">
			<label for="<?php echo $this->get_field_id('class') ?>">
				Container Wrapper Class
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>
		
	<?php 
	}
	
	function form_callback($instance = array()) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		
		//insert the dynamic block_id & block_saving_id into the array
		$this->block_id = 'aq_block_' . $instance['number'];
		$instance['block_saving_id'] = 'aq_blocks[aq_block_'. $instance['number'] .']';

		extract($instance);
		
		$col_order = $order;

		$this->before_form($instance);
		$this->form($instance);		
		$this->after_form($instance);
	}
	
	//form footer
	function after_form($instance) {
		extract($instance);
		
		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';
			
			echo '<div class="block-control-actions clearfix"><a href="#" class="delete">Delete</a> | <a href="#" class="close">Close</a></div>';
			echo '<input type="hidden" class="id_base" name="'.$this->get_field_name('id_base').'" value="'.$id_base.'" />';
			//echo '<input type="hidden" class="name" name="'.$this->get_field_name('name').'" value="'.$name.'" />';
			echo '<input type="hidden" class="order" name="'.$this->get_field_name('order').'" value="'.$order.'" />';
			echo '<input type="hidden" class="size" name="'.$this->get_field_name('size').'" value="'.$size.'" />';
			echo '<input type="hidden" class="parent" name="'.$this->get_field_name('parent').'" value="'.$parent.'" />';
			echo '<input type="hidden" class="number" name="'.$this->get_field_name('number').'" value="'.$number.'" />';
		echo '</div>',
			'</li>';
	}
	
	function block_callback($instance) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		
		extract($instance);
		
		$col_order = $order;
		$col_size = absint(preg_replace("/[^0-9]/", '', $size));
	
		$this->before_block($instance);

	}
	
	/**** Block Outer Ouput ****/
 	/* block header */
 	function before_block($instance) {
 		extract($instance);
 		$column_class = $first ? 'aq-first' : '';
 		
 		echo '
			<div class="'.$class.'">
			<div class="container">
			<div class="row">
		';
 		
 	}

}
