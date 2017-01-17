<?php
/* number Block */
if(!class_exists('ST_Number_Block')) {
class ST_Number_Block extends AQ_Block {
	function __construct() {
		$block_options = array(
		'name' => '<i class="fa fa-clock-o"></i> Number',
		'size' => 'col-md-12',
	);

		//create the widget
		parent::__construct('st_number_block', $block_options);

	//add ajax functions
	add_action('wp_ajax_aq_block_check6_add_new', array($this, 'add_check6_item'));

	}    
   function form($instance){
        $defaults = array(
			'title' => '', 
			'subtitle' =>'', 
            'column' =>'3',
            'items' => array(
	            1 => array(
		            'title' => 'New Desc',
		            'number' =>'',
	            )
            ),
            );
       	    
        $instance = wp_parse_args($instance, $defaults);
        extract($instance);
		$column_option = array(
                '6' => '2 Column',
                '4' => '3 Column',
                '3' => '4 Column',
                '2' => '6 Column',
            ); 
			
   ?>
   <div class="description cf">
	    <ul id="aq-sortable-list-<?php echo $block_id ?>" class="aq-sortable-list" rel="<?php echo $block_id ?>">
			<?php
				$items = is_array($items) ? $items : $defaults['items'];
				$count = 1;
				foreach($items as $item) {	
					$this->item($item, $count);
					$count++;
				}
			?>
	    </ul>
	    <p></p>
	    	<a href="#" rel="check6" class="aq-sortable-add-new button">Add New</a>
	    <p></p>
    </div> 
    <div class="description half">
		<label for="<?php echo $this->get_field_id('column') ?>">
			Column<br/><em style="font-size: 0.8em;">(Example: 4)</em><br/>
			<?php echo aq_field_select('column', $block_id, $column_option, $column, $block_id) ?>
		</label>
	</div>
<?php
}
 function item($item = array(), $count = 0) {  ?>
     <li id="sortable-item-<?php echo $count ?>" class="sortable-item" rel="<?php echo $count ?>">
        <div class="sortable-head cf">
            <div class="sortable-title">
            	<strong><?php echo $item['desc'] ?></strong>
            </div>
            <div class="sortable-handle">
            	<a href="#">Open / Close</a>
            </div>
        </div>
        <div class="sortable-body">
            <div class="tab-desc description">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-desc">
                Title<br/><em style="font-size: 0.8em;">(Example: hours of work)</em><br/>
                <input type="text" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-desc" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][desc]" value="<?php echo $item['desc'] ?>" />
                </label>
            </div>    
            <div class="tab-desc description third last">
                <label for="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-number">
                Number<br/><em style="font-size: 0.8em;">(Example: 9432)</em><br/>
                <input type="number" id="<?php echo $this->get_field_id('items') ?>-<?php echo $count ?>-number" class="input-full" name="<?php echo $this->get_field_name('items') ?>[<?php echo $count ?>][number]" value="<?php echo $item['number'] ?>" />
                </label>
            </div>
            <div class="cf"> </div>  
            <p class="tab-desc description"><a href="#" class="sortable-delete">Delete</a></p>
            <div class="cf"> </div>     
        </div>
    </li>

<?php }

    function block($instance){
    extract($instance);
    $output = '';
    $output.='
    	<div class="statistics">
		<div class="container">
			<div class="row">
    ';
    $i = 1;
    $a = 0;
    foreach($items as $item){
        $output.='<div class="col-sm-';
        $output.=strip_tags(12/$column);
        $output.='">';
        $output.='<h1 class="big">';
        $output.=(!empty($item['icon']) ? '<i class="fa fa-'.esc_attr($item['icon']).'"></i>' : ''); 
        $output.=(!empty($item['number']) ? '<span id="number'.$i.'">'.esc_attr($item['number']).'</span>' : '');
        $output.=(!empty($item['desc']) ? '<span class="desc">'.esc_attr($item['desc']).'</span>' : '');
        $output.='</h1>';
        $output.='</div>';
        $i++;
    }
    $output.='</div>
		</div>
	</div>';
   echo $output;
   
       ?>
   <script>
	//Count numbers
	(function(g){
	g.fn.countUp=function(k){
		var m=parseInt(g(this).text(),10),l,o=g(this);
		function n(){m++;o.text(m.toString());l=setTimeout(n,k)}l=setTimeout(n,k)};g(document).ready(function(){
		  <?php 
          foreach($items as $item){
            $run = ( isset($item['run']) ) ? $item['run'] : 1;
            $a++;
            if($run == '1'){
          ?>
          g("#number<?php echo $a;?>").countUp(2000);
          
          <?php } }?>
          });})(jQuery);
   </script> 
    <?php 
	
    }
function add_check6_item() {
    $nonce = $_POST['security'];	
    if (! wp_verify_nonce($nonce, 'aqpb-settings-page-nonce') ) die('-1');
    
    $count = isset($_POST['count']) ? absint($_POST['count']) : false;
    $this->block_id = isset($_POST['block_id']) ? $_POST['block_id'] : 'aq-block-9999';
    
    //default key/value for the testimonial
    $item = array(
            'title' => 'New Desc',
            'number' =>'',  
    );
    
    if($count) {
    $this->item($item, $count);
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
