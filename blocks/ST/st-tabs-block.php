<?php
/* Aqua Tabs Block */
if(!class_exists('ST_Tabs_Block')) {
	class ST_Tabs_Block extends AQ_Block {
	
		function __construct() {
			$block_options = array(
				'name' => '<i class="fa fa-toggle-down"></i> Tabs &amp; Toggles',
				'size' => 'col-md-6',
			);
			
			//create the widget
			parent::__construct('st_Tabs_Block', $block_options);
			
			//add ajax functions
			add_action('wp_ajax_aq_block_tab_add_new', array($this, 'add_tab'));
			
		}
		
		function form($instance) {
		
			$defaults = array(
				'title' => 'New Title',
				'tabs' => array(
					1 => array(
						'title' => 'My New Tab',
						'content' => 'My tab contents',
					)
				),
				'type'	=> 'tab',
			);
			
			$instance = wp_parse_args($instance, $defaults);
			extract($instance);
			
			$tab_types = array(
				'tab' => 'Tabs',
				'toggle' => 'Toggles',
				'accordion' => 'Accordion'
			);
			
			?>
			<div class="description">
		        <label for="<?php echo $this->get_field_id('title') ?>">
			        Title
			        <?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
		        </label>
	    	</div>
			<div class="description cf">
				<ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
					<?php
					$tabs = is_array($tabs) ? $tabs : $defaults['tabs'];
					$count = 1;
					foreach($tabs as $tab) {	
						$this->tab($tab, $count);
						$count++;
					}
					?>
				</ul>
				<p></p>
				<a href="#" rel="tab" class="aq-sortable-add-new button">Add New</a>
				<p></p>
			</div>
			<p class="description">
				<label for="<?php echo $this->get_field_id('type') ?>">
					Tabs style<br/>
					<?php echo aq_field_select('type', $block_id, $tab_types, $type) ?>
				</label>
			</p>
			<?php
		}
		
		function tab($tab = array(), $count = 0) {
				
			?>
			<li id="<?php echo $this->get_field_id('tabs') ?>-sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
				
				<div class="sortable-head cf">
					<div class="sortable-title">
						<strong><?php echo $tab['title'] ?></strong>
					</div>
					<div class="sortable-handle">
						<a href="#">Open / Close</a>
					</div>
				</div>
				
				<div class="sortable-body">
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title">
							Tab Title<br/>
							<input type="text" id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-title" class="input-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][title]" value="<?php echo $tab['title'] ?>" />
						</label>
					</p>
					<p class="tab-desc description">
						<label for="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content">
							Tab Content<br/>
							<textarea id="<?php echo $this->get_field_id('tabs') ?>-<?php echo $count ?>-content" class="textarea-full" name="<?php echo $this->get_field_name('tabs') ?>[<?php echo $count ?>][content]" rows="5"><?php echo $tab['content'] ?></textarea>
						</label>
					</p>
					<p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
				</div>
				
			</li>
			<?php
		}
		
		function block($instance) {
			extract($instance);
			
			//wp_enqueue_script('jquery-ui-tabs');
			
			$output = '';
			$output.='<div class="custom-heading text-left">
						<h3 class="title"><span>'.$title.'</span></h3>
					</div>';
			if($type == 'tab') {
			
				//$output .= '<div id="aq_block_tabs_'. rand(1, 100) .'" class="aq_block_tabs"><div class="aq-tab-inner">';
					$output .= '<ul class="nav nav-tabs tab-header">';
					
					$i = 1;
					foreach( $tabs as $tab ){
						$tab_selected = $i == 1 ? 'active' : '';
						$output .= '<li class="'.$tab_selected.'"><a href="#tab-'. sanitize_title( $tab['title'] ) . $i .'" data-toggle="tab">' . $tab['title'] . '</a></li>';
						$i++;
					}
					
					$output .= '</ul>';
					
					$output.='<div class="tab-content">';
					$i = 1;
					foreach($tabs as $tab) {
						$tab_selected = $i == 1 ? 'active' : '';
						$output .= '<div id="tab-'. sanitize_title( $tab['title'] ) . $i .'" class="tab-pane '.$tab_selected.'">'. wpautop(do_shortcode(htmlspecialchars_decode($tab['content']))) .'</div>';
						
						$i++;
					}
				
				$output .= '</div>';
				
			} elseif ($type == 'toggle') {
				
				//$output .= '<div id="aq_block_toggles_wrapper_'.rand(1,100).'" class="aq_block_toggles_wrapper">';
				$i = 1;
				foreach( $tabs as $tab ){
					$toggles_selected = $i == 2 ? 'in' : '';
					$minus = $i == 2 ? 'minus' : 'plus';
					$output.='
						<div class="panel panel-default">
						<div class="panel-heading"><div class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#toggles'.$i.'">'. $tab['title'] .'<i class="fa fa-'.$minus.'-square"></i></a></div>
						</div>
						<div id="toggles'.$i.'" class="panel-collapse collapse '.$toggles_selected.'"><div class="panel-body">';
							$output .= wpautop(do_shortcode(htmlspecialchars_decode($tab['content'])));
					$output .='</div></div>
					</div>';
					$i++;
				}
				
				//$output .= '</div>';
				
			} elseif ($type == 'accordion') {
				
				$count = count($tabs);
				$i = 1;
				
				//$output .= '<div id="aq_block_accordion_wrapper_'.rand(1,100).'" class="aq_block_accordion_wrapper">';
				$output.='<div id="1370158991" class="accordion">';
				foreach( $tabs as $tab ){
					
					$open = $i == 1 ? 'in' : '';
					$minus = $i == 1 ? 'minus' : 'plus';
					$i++;
					
					$output.='
						<div class="panel panel-default">
							<div class="panel-heading"><div class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="" href="#accordion'.$i.'">'. $tab['title'] .'<i class="fa fa-'.$minus.'-square"></i></a></div></div>
							<div id="accordion'.$i.'" class="panel-collapse collapse '.$open.'"><div class="panel-body">';
								$output .= wpautop(do_shortcode(htmlspecialchars_decode($tab['content'])));
							$output .='</div></div>
						</div>';
				}
				
				$output .= '</div>';
				
			}
			
			echo $output;
			
		}
		
		/* AJAX add tab */
		function add_tab() {
			$nonce = $_POST['security'];
			if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
			
			$count = isset($_POST['count']) ? absint($_POST['count']) : false;
			$this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
			
			//default key/value for the tab
			$tab = array(
				'title' => 'New Tab',
				'content' => ''
			);
			
			if($count) {
				$this->tab($tab, $count);
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
