<?php 
/*
 Plugin Name: Post Events
 Plugin URI: http://dylanreeve.com/
 Description: Post Events
 Author: Dylan Reeve
 Version: 1.1
 Author URI: http://dylanreeve.com/
 */

function listEvents() {
    global $wpdb;
    global $post;
    
    $options = postEvents_getOptions();
    
    $querystr = "
SELECT wposts.*, wpostmeta.meta_value AS event_date
FROM $wpdb->posts wposts
	LEFT JOIN $wpdb->postmeta wpostmeta ON wposts.ID = wpostmeta.post_id 
WHERE wpostmeta.meta_key = 'event-date'
	AND wpostmeta.meta_value >= CURDATE()
	AND wposts.post_status = 'publish'

ORDER BY wpostmeta.meta_value ASC
LIMIT ".$options['limit'];

    $pageposts = $wpdb->get_results($querystr, OBJECT);
    $thisdate = '';
	$firstdate = true;
    foreach ($pageposts as $post) {
        if ($thisdate != $post->event_date) {
        	
            if (!$firstdate) {
                echo "</ul>";
            }
            echo "<h4 class='postevents-date'>".date($options['dateformat'], strtotime($post->event_date))."</h4><ul class='postevents-events'>\n";
            $thidate = $post->event_date;
			$firstdate = false;
        }
        echo "<li class='postevents-event'><a href=\"".get_permalink($post->ID)."\">".$post->post_title."</a></li>\n";

        
    }
}

function postEvents_getOptions() {
    $options = get_option("widget_postEvents");
    if (!is_array($options)) {
        $options = array('title'=>'Upcoming Events', 'limit'=>'5', 'dateformat'=>'j F');
    }
    
    return $options;
}

function postEvents_control() {
    $options = postEvents_getOptions();
    
    if ($_POST['postEvents-Submit']) {
        $options['title'] = htmlspecialchars($_POST['postEvents-WidgetTitle']);
        $options['limit'] = htmlspecialchars($_POST['postEvents-WidgetLimit']);
        $options['dateformat'] = htmlspecialchars($_POST['postEvents-WidgetDateFormat']);
        update_option("widget_postEvents", $options);
    }
    
?>
<p>
    <label for="postEvents-WidgetTitle">
        Title: 
    </label><br />
    <input class="widefat" type="text" id="postEvents-WidgetTitle" name="postEvents-WidgetTitle" value="<?php echo $options['title'];?>" />
    <br /><br /><label for="postEvents-WidgetLimit">
        Maximum Events: 
    </label><br />
    <input class="widefat" type="text" id="postEvents-WidgetLimit" name="postEvents-WidgetLimit" value="<?php echo $options['limit'];?>" />
    <br /><br /><label for="postEvents-WidgetDateFormat">
        Date Format: 
    </label><br />
    <input class="widefat" type="text" id="postEvents-WidgetDateFormat" name="postEvents-WidgetDateFormat" value="<?php echo $options['dateformat'];?>" /><input type="hidden" id="postEvents-Submit" name="postEvents-Submit" value="1" />
</p>
<?php 
}


function widget_postEvents($args) {
    extract($args);
    $options = postEvents_getOptions();
    
    echo $before_widget;
    echo $before_title;
    
    echo $options['title'];
    echo $after_title;
    listEvents();
    echo $after_widget;
}

function postEvents_init() {
    register_sidebar_widget(__('Post Events'), 'widget_postEvents');
	register_widget_control(__('Post Events'), 'postEvents_control');
}
add_action("plugins_loaded", "postEvents_init");
?>
