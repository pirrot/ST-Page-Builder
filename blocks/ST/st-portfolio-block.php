<?php
/* Work Block */
if(!class_exists('ST_Portfolio_Block')) {
class ST_Portfolio_Block extends AQ_Block {
   
   function __construct() {
	    $block_options = array(
	    'name' => '<i class="fa fa-archive"></i> Portfolio',
	    'size' => 'col-md-12',
    );
    
	    //create the widget
	    parent::__construct('st_portfolio_block', $block_options);
    } 
    
   function form($instance){
        $defaults = array(
			'title' => 'Title Portfolio',
			'subtitle' => 'Subtitle Portfolio',
		    'show' => '',
		    'length' => '',
			'show_button' => 0,
			'text_button' => 'View Portfolio',
			'link_button' => ''
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
        ?>
		<div class="description">
	        <label for="<?php echo $this->get_field_id('title') ?>">
	        Title Portfolio
	        <?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
	        </label>
	    </div>
		
		<div class="description">
	        <label for="<?php echo $this->get_field_id('subtitle') ?>">
	        Subtitle Portfolio
	        <?php echo aq_field_input('subtitle', $block_id, $subtitle, $size = 'full') ?>
	        </label>
	    </div>
		<div class="cf"></div>
		
    	<div class="description half">
    		<label for="<?php echo $this->get_field_id('show') ?>">
    			Show post<br/><em style="font-size: 0.8em;">(Number: 6)</em><br/>
    			<?php echo aq_field_input('show', $block_id, $show, $size = 'full',$type = 'number') ?>
    		</label>
    	</div>
    	<div class="description half last">
    		<label for="<?php echo $this->get_field_id('length') ?>">
    			Length excerpt<br/><em style="font-size: 0.8em;">(Number: 16)</em><br/>
    			<?php echo aq_field_input('length', $block_id, $length, $size = 'full',$type = 'number') ?>
    		</label>
    	</div>
		<h3 style="text-align: center;">Button more Portfolio</h3>
		<div class="cf"></div>
  		<div class="description third">
    		<label for="<?php echo $this->get_field_id('show_button') ?>">
    			show_button<br/><em style="font-size: 0.8em;">(Default: hide)</em><br/>
    			<?php echo aq_field_checkbox('show_button', $block_id, $show_button, $size = 'full') ?>
    		</label>
    	</div>
		<div class="description third">
    		<label for="<?php echo $this->get_field_id('text_button') ?>">
    			text_button<br/><em style="font-size: 0.8em;">(Default: View Portfolio)</em><br/>
    			<?php echo aq_field_input('text_button', $block_id, $text_button, $size = 'full') ?>
    		</label>
    	</div>
		<div class="description third last">
    		<label for="<?php echo $this->get_field_id('link_button') ?>">
    			link_button<br/><em style="font-size: 0.8em;">(Link Default: link to archive portfolio page)</em><br/>
    			<?php echo aq_field_input('link_button', $block_id, $link_button, $size = 'full') ?>
    		</label>
    	</div>
		<div class="cf"></div>
        <?php
        } 
   function block($instance){
    extract($instance);
    $title1 = (!empty($title) ? ' '.esc_attr($title) : '');  
    $desc1 = (!empty($subtitle) ? ' '.esc_attr($subtitle) : '');  
    $show1 = (!empty($show) ? ' '.esc_attr($show) : '');
    $length1 = (!empty($length) ? ' '.esc_attr($length) : '');
	
    $html ='';        
    $html .='<!-- heading -->	
		<div class="container section-heading text-center" data-animated="fadeInDown">
			<h2 class="title"><span>'.$title1.'</span></h2>
			<p class="subtitle">'.$desc1.'</p>
		</div>
		<!-- end heading -->				
		<!-- Filter -->	
		<ul id="portfolio-filter" class="list-inline">
		  <li class="active"><a href="#" data-filter="*">All</a></li>';
		  $categories = get_terms('Categories');   
    	  foreach($categories as $categorie){ 
		  	$html.='<li><a href="#" data-filter=".'.$categorie->slug.'">'.$categorie->name.'</a></li>';
		  }
		$html .='</ul>
		<!-- end filter -->	
		<div class="clearfix"></div>';


    $html .='<!-- portfolio thumbnail list -->	
			<ul id="portfolio-list">';
        $args = array(   
            'posts_per_page' => $show1,
            'post_type' => 'portfolio',   
        );  
        $portfolio = new WP_Query($args);
        $i = 1;
     while($portfolio->have_posts()) : $portfolio->the_post();
        $job =get_post_meta(get_the_ID(),'_cmb_portfolio_job', true); 
        $cates = get_the_terms(get_the_ID(),'Categories');
        $cate_name ='';
        $cate_slug = '';       
        $url = wp_get_attachment_url(get_post_thumbnail_id() );
	    foreach((array)$cates as $cate){
		      if(count($cates)>0){
		                $cate_name .= $cate->name.' ' ;
		                $cate_slug .= $cate->slug .' ';   
		      } 
	   } 
	    $html.='<li class="'.$cate_slug.'">
					<img src="'.$url.'" alt="" />
					<div class="portfolio-item-content">
						<span class="header">'.get_the_title().'</span>
						<p class="body">'.$job.'</p>
					</div>
					<a href="#project'.$i.'"><i class="more">+</i></a>
				</li>';		  
	    $i++;
    endwhile;
	
    $html.='</ul>';
	
	$html.='<!-- Project Expander -->
	<div id="project-container">
	  <div class="project-navigation">
			<button type="button" class="prev"><i class="fa fa-angle-left"></i></button>
			<button type="button" class="close">&times;</button>
		  <button type="button" class="next"><i class="fa fa-angle-right"></i></button>
	  </div>
	  <div class="project-content">
		  <!-- Open project will be loaded here via AJAX load() -->
	  </div>
	</div>';
	
	
	
    $html.='<!-- Add your projects within this following section -->
	<div id="projects">';
    $i = 1;
     while($portfolio->have_posts()) : $portfolio->the_post();
        $job =get_post_meta(get_the_ID(),'_cmb_portfolio_job', true);       
		$layout =get_post_meta(get_the_ID(),'_cmb_portfolio_layout', true); 
		$format = get_post_format(get_the_ID(), 'portfolio');
		
        $cates = get_the_terms(get_the_ID(),'Categories');
        $cate_name ='';
        $cate_slug = '';       
        $url = wp_get_attachment_url(get_post_thumbnail_id() );
		
        foreach((array)$cates as $cate){
	        if(count($cates)>0){
	                $cate_name .= $cate->name.' &middot; ' ;
	                $cate_slug .= $cate->slug .' ';   
	        } 
       } 
	   
      $gallery = get_post_gallery( get_the_ID(), false );
      $gallery_ids = $gallery['ids'];
      $img_ids = explode(",",$gallery_ids);  
	      
    $html.=	'<div id="project'.$i.'">
			<div class="project-header">
				<h3 class="title"><span>'.get_the_title().'</span></h3>
				<div class="type">'.$cate_name.'</div>
			</div>';
			
			//Layout		
			if($layout == 'one_columm'){
				
			$html.='<div class="col-sm-6 col-sm-offset-3">';
				//Format Content
				if ($format == ( 'video' ) || $format == ( 'audio' ) ) {
					$html.='<p class="text-center">'.excerpt(25).'</p>';
					$src = get_post_meta(get_the_ID(),'_cmb_portfolio_video', true);            
			  		$embed_code =  wp_oembed_get($src, array('height'=> 363));  						  
			    	$html.= $embed_code;
				}elseif ($format == 'gallery') {
					
					if(isset($gallery['ids'])){
						$html.='<ul class="slideshow-fade photobox list-unstyled">';
						foreach( $img_ids AS $img_id ){
							$image_src = wp_get_attachment_image_src($img_id,''); 
							$html.='<li><img src="'.$image_src[0].'" alt=""></li>';
						}	
						$html.='</ul>';
					}
					$html.='<div class="text-center">';
						$html.='<p class="lead">'.excerpt(25).'</p>';
						$html.='<p><a class="btn btn-primary btn-lg" href="'.get_permalink().'">Learn More</a></p>';
					$html.='</div>';	
					
				}else {
					$html.='<img src="'.$url.'" alt="" />';
					$html.='<div class="text-center">';
						$html.='<p class="lead">'.excerpt(25).'</p>';
						$html.='<p><a class="btn btn-primary btn-lg" href="'.the_permalink().'">Learn More</a></p>';
					$html.='</div>';
				} 
				
			$html.='</div>';	
				
			}elseif($layout == 'two_columm') {
				
				$html.='<div class="container">
					<div class="row">
						<div class="col-sm-6">';
						//Format Content
							if ($format == ( 'video' ) || $format == ( 'audio' ) ) {
								$src = get_post_meta(get_the_ID(),'_cmb_portfolio_video', true);            
						  		$embed_code =  wp_oembed_get($src, array('height'=> 363));  						  
						    	$html.= $embed_code;
							}elseif ($format == 'gallery') {
								
									if(isset($gallery['ids'])){
										$html.='<ul class="slideshow-fade photobox list-unstyled">';
										foreach( $img_ids AS $img_id ){
											$image_src = wp_get_attachment_image_src($img_id,''); 
											$html.='<li><img src="'.$image_src[0].'" alt=""></li>';
										}	
										$html.='</ul>';
									}
								
							}else {
								$html.='<img src="'.$url.'" alt="" />';
							} 
						$html.='</div>
						<div class="col-sm-6">
							'.get_the_content().'
							<a href="'.get_permalink().'" class="btn btn-primary btn-lg">View Project</a>
						</div>
					</div>
				</div>';
	
			}else {
				//Format Content
				if ($format == ( 'video' ) || $format == ( 'audio' ) ) {
					$src = get_post_meta(get_the_ID(),'_cmb_portfolio_video', true);            
			  		$embed_code =  wp_oembed_get($src, array('height'=> 490));  
					$html.='<p class="text-center">'.excerpt(25).'</p>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<div class="video-full-width">'.$embed_code.'</div>
						</div>
					</div>';
				}elseif ($format == 'gallery') {
					
					if(isset($gallery['ids'])){
						$html.='<ul class="slideshow-fade photobox list-unstyled">';
						foreach( $img_ids AS $img_id ){
							$image_src = wp_get_attachment_image_src($img_id,''); 							
							$html.='<li><img src="'.$image_src[0].'" alt=""></li>';
						}	
						$html.='</ul>';
					}
					$html.='<div class="text-center">';
						$html.='<p class="lead">'.excerpt(25).'</p>';
						$html.='<p><a class="btn btn-primary btn-lg" href="'.get_permalink().'">Learn More</a></p>';
					$html.='</div>';
				}else {
					$html.='<img src="'.$url.'" alt="" />';
					$html.='<div class="text-center">';
						$html.='<p class="lead">'.excerpt(25).'</p>';
						$html.='<p><a class="btn btn-primary btn-lg" href="'.get_permalink().'">Learn More</a></p>';
					$html.='</div>';
				} 
			}
		$html.='</div>';			
        $i++;
    endwhile;
    $html.='</div>
	<!-- end projects -->'; 
	
	$show_button = ( isset($show_button) ) ? $show_button : 0;
	if($show_button == 1){
		$html.='<div id="contactform" class="viewall_portfolio">';
			$html.=(!empty($link_button) ? '<a href="'.$link_button.'" class="btn btn-default">' : '<a href="'.home_url().'/?post_type=portfolio" class="btn btn-default">');
				$html.= $text_button;		
			$html.='</a>';
		$html.='</div>'; 
	}
	else{}

echo $html;  


    }
    function update($new_instance, $old_instance) {
	    $new_instance = aq_recursive_sanitize($new_instance);
	    return $new_instance;
	}      
}
}