<?php
/** A simple text block **/
class ST_Row_Block extends AQ_Block {
	
	/* PHP5 constructor */
	function __construct() {
		
		$block_options = array(
			'name' => '<i class="fa fa-columns"></i> Section ',
			'size' => 'col-md-12',
			'resizable' => 0
		);
		
		//create the widget
		parent::__construct('st_row_block', $block_options);
		
	}

	//form header
	function before_form($instance) {
		extract($instance);
		
		$title = $title ? '<span class="in-block-title"> : '.$title.'</span>' : '';
		$resizable = $resizable ? '' : 'not-resizable';
		
		echo '<li id="template-block-'.$number.'" class="block block-container block-'.$id_base.' '. $size .' '.$resizable.'">',
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
		extract($instance);
		
		echo '<div class="head_row"><div class="handle_row"><div class="block-title">'.$name , $title.'</div><div class="block-controls"><input type="submit" value="close" class="block-edit" id="save_template_header" name="save_template"></div></div></div>';
		echo '<p class="empty-column">',
		__('Drag block items into this column box', 'framework'),
		'</p>';
		echo '<ul class="blocks column-blocks cf"></ul>';
		
	}
	
	function form_callback($instance = array()) {
		$instance = is_array($instance) ? wp_parse_args($instance, $this->block_options) : $this->block_options;
		
		//insert the dynamic block_id & block_saving_id into the array
		$this->block_id = 'aq_block_' . $instance['number'];
		$instance['block_saving_id'] = 'aq_blocks[aq_block_'. $instance['number'] .']';

		extract($instance);
		
		$col_order = $order;
		
		//column block header
		if(isset($template_id)) {
			$resizable = $resizable ? '' : 'not-resizable';	
			echo '<li id="template-block-'.$number.'" class="block block-st_column_block col-md-12 '.$size.' '.$resizable.'">',
					'<dl class="block-bar">',
							'<dt class="block-handle">',
								'<div class="block-title">',
									$name , $title, 
								'</div>',
								'<span class="block-controls">',
									'<a class="block-edit1" id="edit-'.$number.'" title="Edit Block" href="#block-settings-'.$number.'">Edit Block</a>',
								'</span>',
							'</dt>',
						'</dl>',
					'<div class="block-settings cf columm" id="block-settings-'.$number.'">',						
						'<p class="empty-column">',
							__('Drag block items into this column box', 'framework'),
						'</p>',
						'<ul class="blocks column-blocks cf">';
					
			//check if column has blocks inside it
			$blocks = aq_get_blocks($template_id);
			
			//outputs the blocks
			if($blocks) {
				foreach($blocks as $key => $child) {
					global $aq_registered_blocks;
					extract($child);
					
					//get the block object
					$block = $aq_registered_blocks[$id_base];
					
					if($parent == $col_order) {
						$block->form_callback($child);
					}
				}
			} 
			echo 		'</ul>';
			
		} else {
			$this->before_form($instance);
			$this->form($instance);
		}
				
		//form footer
		$this->after_form($instance);
	}
	
	//form footer
	function after_form($instance) {
		$defaults = array(
			'text' => '',
			'id' => '',
			'class' => '',			
			'class1' => '',
			'id1' => '',
			'tagdiv' => ''		
		);

		$instance = wp_parse_args($instance, $defaults);
		extract($instance, EXTR_OVERWRITE);
		
		$block_id = 'aq_block_' . $number;
		$block_saving_id = 'aq_blocks[aq_block_'.$number.']';
		
		?>
		<div style="background-color: #91DCE2;padding: 10px 5px;">
			<hr class="aq-block-clear aq-block-hr-single" style="background: #ececec; clear: both; width: 100%;"/>
			
			<p class="description third">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Title (optional)<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</p>
			
			<p class="description third">
				<label for="<?php echo $this->get_field_id('id') ?>">
					ID (optional)<br/>
					<?php echo aq_field_input('id', $block_id, $id) ?>
				</label>
			</p>
			
			<p class="description third last">
				<label for="<?php echo $this->get_field_id('class') ?>">
					Class (optional)<br/>
					<?php echo aq_field_input('class', $block_id, $class) ?>
				</label>
			</p>
			
			<div class="cf"></div>
			<hr class="aq-block-clear aq-block-hr-single" style="background: #ececec; clear: both; width: 100%; margin: 30px 0px;"/> 
			
			<div class="description third">
				<label for="<?php echo $this->get_field_id('tagdiv') ?>">
					Add div before container <br/>
					<?php echo aq_field_input('tagdiv', $block_id, $tagdiv) ?>
				</label>
			</div>
			
			<div class="description third">
				<label for="<?php echo $this->get_field_id('class1') ?>">
					Class for div before container<br/>
					<?php echo aq_field_input('class1', $block_id, $class1) ?>
				</label>
			</div>
			
			<div class="description third last">
				<label for="<?php echo $this->get_field_id('id1') ?>">
					ID for div before container<br/>
					<?php echo aq_field_input('id1', $block_id, $id1) ?>
				</label>
			</div>
			
		<div class="cf"></div>	
		</div>	
		<?php 
			
			echo '<div class="block-control-actions cf"><a href="#" class="delete">Delete</a></div>';
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
		
		//column block header
		if(isset($template_id)) {
			$this->before_block($instance);
			
			//define vars
			$overgrid = 0; $span = 0; $first = false;
			
			//check if column has blocks inside it
			$blocks = aq_get_blocks($template_id);
			
			//outputs the blocks
			if($blocks) {
				foreach($blocks as $key => $child) {
					global $aq_registered_blocks;
					extract($child);
					
					if(class_exists($id_base)) {
						//get the block object
						$block = $aq_registered_blocks[$id_base];
						
						//insert template_id into $child
						$child['template_id'] = $template_id;
						
						//display the block
						if($parent == $col_order) {
							
							$child_col_size = absint(preg_replace("/[^0-9]/", '', $size));
							
							$overgrid = $span + $child_col_size;
							
							if($overgrid > $col_size || $span == $col_size || $span == 0) {
								$span = 0;
								$first = true;
							}
							
							if($first == true) {
								$child['first'] = true;
							}
							
							$block->block_callback($child);
							
							$span = $span + $child_col_size;
							
							$overgrid = 0; //reset $overgrid
							$first = false; //reset $first
						}
					}
				}
			} 
			
			$this->after_block($instance);
			
		} else {
			//show nothing
		}
	}
	
	/**** Block Outer Ouput ****/
 	/* block header */
 	function before_block($instance) {
 		extract($instance);
 		$column_class = $first ? 'aq-first' : '';
 		
 		if (!empty($tagdiv)){
 			echo '<section id="'.$id.'" class="'.$class.' clearfix"><'.$tagdiv.' class="'.$class1.'" id="'.$id1.'" ></'.$tagdiv.'>';
 		}else {
 			echo '<section id="'.$id.'" class="'.$class.' clearfix">';
 		}
 	}
 	
	
	/* block footer */
 	function after_block($instance) {
 		extract($instance);
 		echo '</section>';	
 	}
}