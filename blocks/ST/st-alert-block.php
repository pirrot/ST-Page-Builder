<?php
/** Notifications block **/

if(!class_exists('ST_Alert_Block')) {
	class ST_Alert_Block extends AQ_Block {
		
		//set and create block
		function __construct() {
			$block_options = array(
				'name' => '<i class="fa fa-tasks"></i> Alerts',
				'size' => 'col-md-6',
			);
			
			//create the block
			parent::__construct('st_alert_block', $block_options);
		}
		
		function form($instance) {
			
			$defaults = array(
				'content' => '',
				'type' => 'alert-info',
				'style' => '',
				'btn_close' => 0
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$type_options = array(
				'alert-info' => 'Info',
				'alert-danger' => 'Danger',
				'alert-warning' => 'Warning',
				'alert-success' => 'Success'
			);
			
			?>
			
			<p class="description">
				<label for="<?php echo $this->get_field_id('title') ?>">
					Title (optional)<br/>
					<?php echo aq_field_input('title', $block_id, $title) ?>
				</label>
			</p>
			<p class="description">
				<label for="<?php echo $this->get_field_id('content') ?>">
					Alert Text (required)<br/>
					<?php echo aq_field_textarea('content', $block_id, $content) ?>
				</label>
			</p>
			<p class="description half">
				<label for="<?php echo $this->get_field_id('type') ?>">
					Alert Type<br/>
					<?php echo aq_field_select('type', $block_id, $type_options, $type) ?>
				</label>
			</p>
			<p class="description half last">
				<label for="<?php echo $this->get_field_id('style') ?>">
					Additional inline css styling (optional)<br/>
					<?php echo aq_field_input('style', $block_id, $style) ?>
				</label>
				<label for="<?php echo $this->get_field_id('btn_close') ?>">
					<?php echo aq_field_checkbox('btn_close', $block_id, $btn_close) ?>
					Insert the button close in Box. <code>"btn close"</code> enable.
				</label>
			</p>
			
			<?php
		}
		
		function block($instance) {
			extract($instance);
			$btn_close = ( isset($btn_close) ) ? $btn_close : 0;
			
			echo '<div class="alert '.$type.' alert-dismissable" style="'. $style .'">';
			if($btn_close == 1){
			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			}
			else{}
				echo do_shortcode(htmlspecialchars_decode($content));
			echo'</div>';
			
		}
		
	}
}