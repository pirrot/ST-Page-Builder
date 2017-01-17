<?php
/* Letwork Block */
if(!class_exists('ST_Letwork_Block')) {
class ST_Letwork_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-th"></i> Let work',
		'size' => 'col-md-12',
	);
    
	
	//create the widget
	parent::__construct('st_letwork_block', $block_options);


}
   function form($instance){
        $defaults = array(
            'chosen' =>'',
            'title' =>'',
            'link' =>'',
            'image' =>'',
            'video' =>'',
  
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
        $chosen_options = array(
                'image' => 'Image',
                'video' => 'Video',    
            )
        ?>
  <h3 style="text-align: center;">Let Work</h3>
   	<div class="description">
		<label for="<?php echo $this->get_field_id('title') ?>">
			Title<br/><em style="font-size: 0.8em;">(Example: Let's work together)</em><br/>
			<?php echo aq_field_input('title', $block_id, $title, $size = 'full') ?>
		</label>
	</div>
	<div class="description half">
		<label for="<?php echo $this->get_field_id('link') ?>">
			Link<br/><em style="font-size: 0.8em;">(Example: yoursite.com)</em><br/>
			<?php echo aq_field_input('link', $block_id, $link, $size = 'full') ?>
		</label>
	</div>
	<div class="description half last">
    	<label for="<?php echo $this->get_field_id('chosen') ?>">
    	Chosen<br/><em style="font-size: 0.8em;">(Chosen a version)</em><br/>
    	<?php echo aq_field_select('chosen', $block_id, $chosen_options, $chosen) ?>
    	</label>
	</div> 
	<div class="description half">
		<label for="<?php echo $this->get_field_id('video') ?>">
			Video<br/><em style="font-size: 0.8em;">(Example: http://www.youtube.com/watch?v=tDvBwPzJ7dY )<br /><code> tDvBwPzJ7dY </code> </em><br/><br />
			<?php echo aq_field_input('video', $block_id, $video, $size = 'full') ?>
		</label>
	</div>
	<div class="description half last">
		<label for="<?php echo $this->get_field_id('image') ?>">
			Image<br/><em style="font-size: 0.8em;">(Please enter image url)</em><br/>
			<?php echo aq_field_upload('image', $block_id, $image, $media_type = 'image') ?>
		</label>
	</div>    
  
        <?php
        }

  function block($instance){
    extract($instance);  
    $output = '';
    $link = (!empty($link) ? esc_url($link) : ''); 
    $video = (!empty($video) ? esc_attr($video) : '');
    $image = (!empty($image) ? esc_url($image) : '');
   
        
    if($chosen == 'video'){
        $output.='
    <article class="container-video">
        <div class="parallax-info">';
    $output.=(!empty($title) ? '<div class="p-video-title"><a href="'.$link.'" class="btn btn-outline-white btn-big">'.esc_attr($title).'</a></div>' : ''); 
    $output.='</div>
        <div class="mk-video-mask"></div>
		<div class="video-container"><div id="player"></div></div>
    </article>
        ';
       ?>
    <script>
    		// 1. This code loads the IFrame Player API code asynchronously.
		var tag = document.createElement('script');
		tag.src = "http://www.youtube.com/player_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      // 2. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubePlayerAPIReady() {
        player = new YT.Player('player', {
          height: '100%',
          width: '100%',			
          playerVars: { 'rel':0 , 'autoplay': 1, 'loop':1, 'controls':0, 'start':30, 'autohide':1,'wmode':'opaque' },
          videoId: '<?php echo $video;?>',
          events: {
            'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange}
        });
      }
	// 3. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.mute();
//		event.target.setSize(width:100, height:750);
      }
	  
	 // when video ends
        function onPlayerStateChange(event) {        
            if(event.data === 0) {          
                event.target.playVideo();
            }
        }
        
    </script>    
       <?php 
    }
    if($chosen == 'image'){
        $output.='
   	<div class="getInTouch" >
		<div class="getInTouch-bg parallax-bg" style="
       background-image: url('.$image.')!important;
       ">
			<div class="info-container">
				<div class="info">
					<div class="container cbp-so-side cbp-so-side-top">';
    $output.=(!empty($title) ? '<a href="'.$link.'" class="btn btn-outline-white btn-big">'.esc_attr($title).'</a>' : '');
     $output.='
					</div>
				</div>
			</div>
		</div>
	</div>
        
        ';
    }
    echo $output;
    }
  function update($new_instance, $old_instance) {
    $new_instance = aq_recursive_sanitize($new_instance);
    return $new_instance;
}
}
}