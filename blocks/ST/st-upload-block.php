<?php 
/* Media Uploader Block 
 *
 * Please see media block in cuvette 
 */
if(!class_exists('ST_Upload_Block')) {
	class ST_Upload_Block {
		
		function __construct() {
			$block_options = array(
				'name' => '<i class="fa fa-upload"></i> Media',
				'size' => 'col-md-12',
			);
			
			//create the block
			parent::__construct('st_upload_block', $block_options);
		}
		
		function form($instance) {
			$defaults = array(
				'media' => '',
			);
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
		}
		
		function block($instance) {
			if($title) echo '<h4 class="st-block-title">'.strip_tags($title).'</h4>';
		}
		
	}
}
