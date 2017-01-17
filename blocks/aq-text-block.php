<?php
/** A simple text block **/
class AQ_Text_Block extends AQ_Block {
	
	//set and create block
	function __construct() {
		$block_options = array(
			'name' => 'Text',
			'size' => 'col-md-6',
			'offset' => '',
			'effect' => 'None',
			'class' => '',
			'resizable' => 1,
		);
		
		//create the block
		parent::__construct('aq_text_block', $block_options);
	}
	
	function form($instance) {
		
		$defaults = array(
			'text' => '',
			'wp_autop' => 1
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		$options = array(
			'fadeInLeft' => 'fadeInLeft',
        	'fadeInRight' => 'fadeInRight',
        	'fadeInUp' => 'fadeInUp',
        	'None' => 'None',
        );
		?>
		
		<p class="description half">
			<label for="<?php echo $this->get_field_id('offset') ?>">
				Offset (optional)
				<?php echo aq_field_input('offset', $block_id, $offset, $size = 'full') ?>
			</label>
		</p>
		<p class="description half">
			<label for="<?php echo $this->get_field_id('effect') ?>">
				Effect (optional)
				<?php echo aq_field_select('effect', $block_id, $options, $effect) ?>
			</label>
		</p>
		<p class="description ">
			<label for="<?php echo $this->get_field_id('class') ?>">
				Custom Class (optional)
				<?php echo aq_field_input('class', $block_id, $class,$size = 'full') ?>
			</label>
		</p>
		<p class="description">
			<label for="<?php echo $this->get_field_id('text') ?>">
				Content
				<?php echo aq_field_textarea('text', $block_id, $text, $size = 'full') ?>
			</label>
			<label for="<?php echo $this->get_field_id('wp_autop') ?>">
				<?php echo aq_field_checkbox('wp_autop', $block_id, $wp_autop) ?>
				Do not create the paragraphs automatically. <code>"wpautop"</code> disable.
			</label>
	</p>
		
		<?php
	}
	
	function block($instance) {
		extract($instance);

		$wp_autop = ( isset($wp_autop) ) ? $wp_autop : 0;
		
		if($title) echo '<h4 class="aq-block-title">'.strip_tags($title).'</h4>';
		echo '<div class="'.$class.'">';
		if($effect!='None'){
			echo '<div style="display:inline-block; width: 100%;" data-appear-top-offset="'.$offset.'" data-animated="'.$effect.'">';
		}
		if($wp_autop == 1){
			echo do_shortcode(htmlspecialchars_decode($text));
		}
		else
		{
			echo wpautop(do_shortcode(htmlspecialchars_decode($text)));
		}
		if($effect!='None'){
			echo "</div>";
		}
		echo '</div>';
	}
	
}
