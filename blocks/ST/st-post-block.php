<?php
/* Post Block */
if(!class_exists('ST_Post_Block')) {
class ST_Post_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-th"></i> Show post',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_post_block', $block_options);


}
   function form($instance){
        $defaults = array(
			'title' => '', 
			'subtitle' =>'', 
            'length' =>'25',
            'read' =>'Read more',
            'show' =>'',
			'excludecate' => ''
  
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);  ?>
        
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
		
		<div class="description fourth">
			<label for="<?php echo $this->get_field_id('excludecate') ?>">
                Exclude Category id <br />Ex: <code>-3,-21,-44,-23</code><br/>
				<?php echo aq_field_input('excludecate', $block_id, $excludecate) ?>
			</label>
		</div>	
        <div class="description fourth">
		<label for="<?php echo $this->get_field_id('length') ?>">
			Length excerpt<br/><em style="font-size: 0.8em;">(Number: 30)</em><br/>
			<?php echo aq_field_input('length', $block_id, $length, $size = 'full',$type = 'number') ?>
		</label>
    	</div>
    	<div class="description fourth">
		<label for="<?php echo $this->get_field_id('read') ?>">
			Text read<br/><em style="font-size: 0.8em;">(Example: READ BLOG POST)</em><br/>
			<?php echo aq_field_input('read', $block_id, $read, $size = 'full') ?>
		</label>
    	</div>
    	<div class="description fourth last">
		<label for="<?php echo $this->get_field_id('show') ?>">
			Show post<br/><em style="font-size: 0.8em;">(Number: 8)</em><br/>
			<?php echo aq_field_input('show', $block_id, $show, $size = 'full',$type = 'number') ?>
		</label>
    	</div>
  <?php
    }
    function block($instance){
    extract($instance);
	
    $textdoimain = 'birva';
    ?>
       <div class="container">
		<!-- heading -->
		<div class="row">
			<div class="section-heading text-center picture" data-animated="fadeInDown">
				<h1 class="title"><span><?php echo esc_attr($title); ?></span></h1>
				<p class="subtitle"><?php echo esc_attr($subtitle); ?></p>				
			</div>
		</div>
	</div>
		<!-- end heading -->
<!-- Recent post section -->
	<div id="blogpost" class="clearfix">
		<div class="container">
			<div class="isotope" id="fullwidth">	
   <?php 
    $show = (!empty($show) ? ' '.esc_attr($show) : '');  
    $excludecate = (!empty($excludecate) ? ' '.esc_attr($excludecate) : '');
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
          $args=array(
		  	'paged' => $paged,  
		  	'post_type' => 'post',
            'posts_per_page' => $show,
         	'cat' => $excludecate,
         	'order' => 'DESC',
         	'orderby' => 'date',
         	'post__not_in' => get_option( 'sticky_posts' ),			
        );
         $wp_query = new WP_query($args);
         if ( $wp_query -> have_posts() ) :
         while ($wp_query -> have_posts()): $wp_query -> the_post(); 
   ?>
   				
		<article class="postlist isotope-item">       
			<div class="thumb">
				<div class="date"><span><?php the_time('F'); ?><br /><?php the_time('j'); ?></span></div>
			<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_post_thumbnail('full'); ?></a>
			</div>
			<div class="postcontent">
				<h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
				<p><?php if($length >= '1'){dynamic_excerpt($length);}else{dynamic_excerpt(30);}?></p>
			<a href="<?php the_permalink();?>"><?php echo $read; ?> <i class="fa fa-long-arrow-right"></i></a>
				<br class="clearfix"/>						
			</div>
		</article> 	

    <?php endwhile;?>
	
    			</div><!-- end fullwidth -->
			<div class="clearfix"></div>
			<div class=" text-center">
				<ul class="pagination">
	                <li>
				        <?php   
							$big = 999999999; // need an unlikely integer
		                    echo paginate_links( array(
		                         'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		                         'format' => '?paged=%#%',
		                         'current' => max(1, get_query_var('paged') ),
		                         'total' => $wp_query->max_num_pages,
		                         'next_text'    => __('&raquo;','icreative'),
		                         'prev_text'    => __('&laquo;','icreative'),      
		                     ) );
				        ?>
	                </li>
			    </ul>
			</div> 
			
			<?php
				//echo '<div id="pagenavi_birva">';
					//birva_numeric_posts_nav();
				//echo '</div>';
				endif;
			?>	
		</div>
	</div>
	<!-- end Recent post section -->
    <?php
    }
    function update($new_instance, $old_instance) {
	    $new_instance = aq_recursive_sanitize($new_instance);
	    return $new_instance;
	}
}
}
 ?>