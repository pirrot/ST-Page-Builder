<?php
/* Post Block */
if(!class_exists('ST_Twitter_Block')) {
class ST_Twitter_Block extends AQ_Block {

	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-twitter"></i> Twitter',
		'size' => 'col-md-12',
	);
	
	//create the widget
	parent::__construct('st_twitter_block', $block_options);

	}
   function form($instance){
        $defaults = array(
            'user' =>'evanto',
            'num' =>1,
            'photo' =>'',
            'id'    => 'twitter'
  
        );
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);  ?>
        
        <div class="description third">
		<label for="<?php echo $this->get_field_id('user') ?>">
			User<br/><em style="font-size: 0.8em;">(Your user in twitter)</em><br/>
			<?php echo aq_field_input('user', $block_id, $user, $size = 'full',$type = 'text') ?>
		</label>
    	</div>
    	<div class="description third">
		<label for="<?php echo $this->get_field_id('num') ?>">
			Number Status<br/><em style="font-size: 0.8em;">(Your Number Status you want show:)</em><br/>
			<?php echo aq_field_input('num', $block_id, $num, $size = 'min',$type='number' ) ?>
		</label>
    	</div>
        <div class="description third">
		<label for="<?php echo $this->get_field_id('id') ?>">
			ID<br/><em style="font-size: 0.8em;">(Your ID if you want twitters)</em><br/>
			<?php echo aq_field_input('id', $block_id, $id, $size = 'full') ?>
		</label>
    	</div>
        
    	<div class="description half">
    		<label for="<?php echo $this->get_field_id('photo') ?>">
    			Photo <em style="font-size: 0.8em;">(Your Photo)</em><br/>
    			<?php echo aq_field_input('photo', $block_id, $photo, $size = 'full',$type = 'text') ?>
    			<a href="#" class="aq_upload_button button" rel="image">Upload</a><p></p>
    		</label>
        </div>
  <?php
    }
    function block($instance){
    extract($instance);
    $output='';
    $output.='
    <div class="twitter-feed">
		<div class="twitter-bg parallax-bg">
			<div class="info-container">
				<div class="info">
					<div class="container cbp-so-side cbp-so-side-top">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2 livet">
								
								<!-- twitter author -->
								<div class="twitter_author"><a href="https://twitter.com/'.$user.'" target="_blank"><img class="twitter_img left pulsate-opacity" src="'.$photo.'" alt=""></a></div>
								<!-- tweets display -->
								<div id="'.$id.'">
								</div>
								<!-- End tweets display-->
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End live twitter feed -->
	</div>
    ';
    echo $output;
    ?>
    <script>
    //Twitter feed
	jQuery(function(){
		jQuery('#<?php echo $id; ?>').tweetable({
		username: '<?php echo $user;?>', //twitter username 
		time: true, 
		rotate: true, 
		speed: 7000, 
		limit: <?php echo $num; ?>, 
		replies: true,
		position: 'append',
		failed: "Sorry, twitter is currently unavailable for this user.",
		loading: "Loading tweets...",
		html5: true,
		onComplete:function($ul){
			$('time').timeago();
		}
		});
	});
    </script>
    <?php
    }
    function update($new_instance, $old_instance) {
    $new_instance = aq_recursive_sanitize($new_instance);
    return $new_instance;
}
}
}
 ?>