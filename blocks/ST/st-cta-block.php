<?php
/** Slogan block **/
class ST_CTA_Block extends AQ_Block {

	//set and create block
	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-pagelines"></i> Call To Action',
		'size' => 'col-md-12',
	);

		//create the block
		parent::__construct('st_cta_block', $block_options);
	}

	function form($instance) {
	
		$defaults = array(
			'title' => '',
			'headline' => '',
			'subheadline' => '',
			'heading' => 'h1',
			'subheading' => 'h2',
			'align' => 'center',
			'bgcolor' => '#F2EFEF',
			'textcolor'	=> '#676767',
			'btntext' => 'Learn More',
			'btncolor' => 'grey',
			'btnsize' => 'large',
			'btnlink' => '',
			'btnicon' => 'none',
			'btnlinkopen' => 'same',
			'id' => '',
			'class' => '',
			'style' => '',
			'description1' => '',
			'description2' => '',
			'description3' => '',
		);
		$instance = wp_parse_args($instance, $defaults);
		extract($instance);
		
		$heading_style = array(
			'h1' => 'H1',
			'h2' => 'H2',
			'h3' => 'H3',
			'h4' => 'H4',
			'h5' => 'H5',
			'h6' => 'H6',
		);
	
		$align_options = array(
			'left' => 'Left',
			'center' => 'Center',
			'right' => 'Right'
		);
	
	?>
		<div class="description">
			<label for="<?php echo $this->get_field_id('title') ?>">
				Title (optional)
				<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
			</label>
		</div>
		
		<div class="description half">
			<label for="<?php echo $this->get_field_id('headline') ?>">
				Headline
				<?php echo aq_field_textarea('headline', $block_id, $headline, $size = 'full') ?>
			</label>
		</div>
		
		<div class="description half last">
			<label for="<?php echo $this->get_field_id('subheadline') ?>">
				Subheadline
				<?php echo aq_field_textarea('subheadline', $block_id, $subheadline, $size = 'full') ?>
			</label>
		</div>
		
		<div class="cf"></div>
		
		<div class="description third">
			<label for="<?php echo $this->get_field_id('description1') ?>">
				Description columm one
				<?php echo aq_field_textarea('description1', $block_id, $description1, $size = 'full'); ?>
			</label>
		</div>
		
		<div class="description third">
			<label for="<?php echo $this->get_field_id('description2') ?>">
				Description columm two
				<?php echo aq_field_textarea('description2', $block_id, $description2, $size = 'full'); ?>
			</label>
		</div>
		
		<div class="description third last">
			<label for="<?php echo $this->get_field_id('description3') ?>">
				Description columm three
				<?php echo aq_field_textarea('description3', $block_id, $description3, $size = 'full'); ?>
			</label>
		</div>
		
		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('heading') ?>">
				Heading Type(Headline)<br/>
				<?php echo aq_field_select('heading', $block_id, $heading_style, $heading); ?>
			</label>
		</div>
		
		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('subheading') ?>">
				Heading Type(Subheadline)<br/>
				<?php echo aq_field_select('subheading', $block_id, $heading_style, $subheading); ?>
			</label>
		</div>
		
		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('align') ?>">
				Text Align<br/>
				<?php echo aq_field_select('align', $block_id, $align_options, $align); ?>
			</label>
		</div>

		
		<div class="description fourth last">
			<label for="<?php echo $this->get_field_id('textcolor') ?>">
				Pick a text color<br/>
				<?php echo aq_field_color_picker('textcolor', $block_id, $textcolor) ?>
			</label>
		</div>
		
		<div class="cf"></div>
		
		<div class="description half">
			<label for="<?php echo $this->get_field_id('id') ?>">
				id (optional)<br/>
				<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
			</label>
		</div>
	
		<div class="description half last">
			<label for="<?php echo $this->get_field_id('class') ?>">
				class (optional)<br/>
				<?php echo aq_field_input('class', $block_id, $class, $size = 'full') ?>
			</label>
		</div>
	
		<div class="cf"></div>
	
		<div class="description">
			<label for="<?php echo $this->get_field_id('style') ?>">
				Additional inline css styling (optional)<br/>
				<?php echo aq_field_input('style', $block_id, $style) ?>
			</label>
		</div>

	<?php
	
	}
	
	function block($instance) {
	extract($instance);
	
		$id = (!empty($id) ? ' id="'.esc_attr($id).'"' : '');
		$class = (!empty($class) ? ' '.esc_attr($class) : '');
		$style = (!empty($style) ? ' ' . esc_attr($style) : '');
	
	switch ($align) {
		case 'left':
		$alignclass = 'left';
		break;
		case 'center':
		$alignclass = 'center';
		break;
		case 'right':
		$alignclass = 'right';
		break;
	
	}
	
		$output = '';
		$output .= '<div class="container">';
		
		$output .= '<'.$heading.' style="color: '.$textcolor.'; text-align: '.$alignclass.';">';
		$output .= htmlspecialchars_decode($headline);
		$output .= '</'.$heading.'>';
		$output .= '<'.$subheading.' style="color: '.$textcolor.'; text-align: '.$alignclass.';">';
		$output .= htmlspecialchars_decode($subheadline);
		$output .= '</'.$subheading.'>';
		
		if (!empty($description3)){
		$output .= '<div id="'.$id.'" class="row '.$class.'" style="'.$style.'">';
		$output .= '<div class="col-md-4""><p class="left-align">';
		$output .= htmlspecialchars_decode($description1);	
		$output .= '</p></div>';
		$output .= '<div class="col-md-4"><p class="left-align">';
		$output .= htmlspecialchars_decode($description2);	
		$output .= '</p></div>';
		$output .= '<div class="col-md-4"><p class="left-align">';
		$output .= htmlspecialchars_decode($description3);	
		$output .= '</p></div>';
		$output .= '</div>';
		}
		
		else {	
		if  (!empty($description2)){
		$output .= '<div id="'.$id.'" class="row '.$class.'" style="'.$style.'">';
		$output .= '<div class="col-md-6"><p class="left-align">';
		$output .= htmlspecialchars_decode($description1);	
		$output .= '</p></div>';
		$output .= '<div class="col-md-6"><p class="left-align">';
		$output .= htmlspecialchars_decode($description2);	
		$output .= '</p></div>';
		$output .= '</div>';
		}
		elseif  (!empty($description1)){
		$output .= '<div id="'.$id.'" class="row '.$class.'" style="'.$style.'">';
		$output .= '<div class="col-md-10 col-md-offset-1 " style="text-align:'.$alignclass.';"><p>';
		$output .= htmlspecialchars_decode($description1);	
		$output .= '</p></div>';
		$output .= '</div>';
		}
		else {}
		}
		
		$output .= '</div>';
		
		echo $output;
	}

}