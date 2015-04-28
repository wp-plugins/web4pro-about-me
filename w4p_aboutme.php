<?php
/*
Plugin Name: Web4pro Aboutme
Plugin URI:
Description: Create widget with information about the site owner
Version: 1.1
Author: Web4pro
Author URI: http://www.web4pro.net/
*/
add_action('admin_enqueue_scripts', 'web4pro_aboutme_uploadscript'); //Enable upload javascript for admin side
add_action('wp_enqueue_scripts', 'web4pro_aboutme_uploadscript');
add_action('wp_enqueue_scripts', 'w4p_add_front_style'); //Enable css for user side
add_action('widgets_init', create_function('', 'register_widget( "Web4pro_Aboutme_Widget" );')); //Widget registration

add_filter('image_size_names_choose', 'w4p_size'); //Add image size "About me" to the upload form
add_image_size('w4p_aboutme_photo', 50, 50, true);

function w4p_size($defaultSizes)
{
//Registering "About me" picture size
    $size = array(
        'w4p_aboutme_photo' => 'About me',
    );

    return array_merge($defaultSizes, $size);
}

function web4pro_aboutme_uploadscript($hook) //Registering upload javascript
{
    // wp_enqueue_script('jquery');
    if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
    wp_enqueue_style('w4p_widget_style', plugins_url('css/style.css', __FILE__), false);
    wp_enqueue_style('thickbox');

    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');

    if($hook == 'widgets.php') {
        wp_enqueue_script('w4p_upload', plugins_url('js/upload.js', __FILE__), array('jquery'), null, false);
    }
}

function w4p_add_front_style() //Registering css
{
    wp_register_script('w4p_front_style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('w4p_front_style');
}


class Web4pro_Aboutme_Widget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'Web4pro_Aboutme_Widget', //Widget identify
            __('Web4pro Aboutme'), //Widget name
            array('description' => __('Create widget with information about the site owner'))
        );
    }

    public function form($instance)
    {

        $default = plugins_url('images/no-image.jpg', __FILE__); //Default image
        $title = isset($instance['title']) ? $instance['title'] : __('About me'); //Title of the widget
        $name = isset($instance['name']) ? $instance['name'] : '';
        $image = isset($instance['image_uri']) ? $instance['image_uri'] : $default; //Photo field
        $caption = isset($instance['caption']) ? $instance['caption'] : '';
        $text = isset($instance['text']) ? $instance['text'] : '';
        //Start the social links
        $facebook = isset($instance['facebook']) ? $instance['facebook'] : '';
        $twitter = isset($instance['twitter']) ? $instance['twitter'] : '';
        $google = isset($instance['google']) ? $instance['google'] : '';
        $linkedin = isset($instance['linkedin']) ? $instance['linkedin'] : '';
        $flickr = isset($instance['flickr']) ? $instance['flickr'] : '';
        $youtube = isset($instance['youtube']) ? $instance['youtube'] : '';
        $feed_burner = isset($instance['feedburner']) ? $instance['feedburner'] : '';
        $skype = isset($instance['skype']) ? $instance['skype'] : '';
        $lastfm = isset($instance['lastfm']) ? $instance['lastfm'] : '';
        $instagram = isset($instance['instagram']) ? $instance['instagram'] : '';
        $deviantart = isset($instance['deviantart']) ? $instance['deviantart'] : '';
        $pinterest = isset($instance['pinterest']) ? $instance['pinterest'] : '';
        ?>
        <!-- Widget title -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget title'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <!-- Photo field -->
        <p>
            <label
                for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Your Photo(50x50 pixels)'); ?></label><br/>
            <img src="<?php echo $image; ?>" class="widefat image" style="width: 50px; height: 50px;">
            <input type="hidden" class="img" name="<?php echo $this->get_field_name('image_uri'); ?>"
                   id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $image; ?>"/>

        </p>
        <!-- Name field -->
        <p>
            <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Your name'); ?></label>
            <input type="text" class="widefat" value="<?php echo esc_attr($name); ?>" placeholder="Enter your name"
                   id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>">
        </p>
        <!-- Caption field -->
        <p>
            <label for="<?php echo $this->get_field_id('caption'); ?>"><?php _e('Caption'); ?></label>
            <textarea id="<?php echo $this->get_field_id('caption'); ?>"
                      name="<?php echo $this->get_field_name('caption') ?>"
                      class="widefat"><?php echo $caption; ?></textarea>
        </p>
        <!-- Main text field -->
        <p>
            <label
                for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Your main text (you can use HTML tags)'); ?></label>
            <textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text') ?>"
                      class="widefat" rows="15"><?php echo $text; ?></textarea>
        </p>
        <!-- start social links fields -->
        <h3 style="text-align: center"><?php _e('Social links'); ?></h3>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/FB.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('facebook'); ?>"
                   name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo esc_attr($facebook); ?>"
                   placeholder="http://facebook.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/Twitter.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('twitter'); ?>"
                   name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo esc_attr($twitter); ?>"
                   placeholder="http://twitter.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/LinkedIn.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('linkedin'); ?>"
                   name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo esc_attr($linkedin); ?>"
                   placeholder="https://www.linkedin.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/G+.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('google'); ?>"
                   name="<?php echo $this->get_field_name('google'); ?>" value="<?php echo esc_attr($google); ?>"
                   placeholder="http://google.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/Flickr.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('flickr'); ?>"
                   name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo esc_attr($flickr); ?>"
                   placeholder="http://flickr.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/YouTube.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('youtube'); ?>"
                   name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo esc_attr($youtube); ?>"
                   placeholder="http://youtube.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/FeedBurner.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('feedburner'); ?>"
                   name="<?php echo $this->get_field_name('feedburner'); ?>"
                   value="<?php echo esc_attr($feed_burner); ?>"
                   placeholder="http://feedburner.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/Skype.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('skype'); ?>"
                   name="<?php echo $this->get_field_name('skype'); ?>" value="<?php echo esc_attr($skype); ?>"
                   placeholder="http://skype.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/LastFM.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('lastfm'); ?>"
                   name="<?php echo $this->get_field_name('lastfm'); ?>" value="<?php echo esc_attr($lastfm); ?>"
                   placeholder="http://last.fm">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/Instagram.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('instagram'); ?>"
                   name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo esc_attr($instagram); ?>"
                   placeholder="https://instagram.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/Deviantart.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('deviantart'); ?>"
                   name="<?php echo $this->get_field_name('deviantart'); ?>" value="<?php echo esc_attr($deviantart); ?>"
                   placeholder="http://www.deviantart.com">
        </div>
        </p>
        <p>
        <div class="social-links-list">
            <img src="<?php echo plugins_url('images/Pinterest.jpg', __FILE__); ?>" class="social-link-image">
            <input type="text" id="<?php echo $this->get_field_id('pinterest'); ?>"
                   name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo esc_attr($pinterest); ?>"
                   placeholder="https://www.pinterest.com">
        </div>
        </p>
    <?php
    }

    public function update($new_instance, $old_instance)
    {
        //Saving fields after edit
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['image_uri'] = (!empty($new_instance['image_uri'])) ? strip_tags($new_instance['image_uri']) : '';
        $instance['name'] = (!empty($new_instance['name'])) ? strip_tags($new_instance['name']) : '';
        $instance['caption'] = (!empty($new_instance['caption'])) ? strip_tags($new_instance['caption']) : '';
        $instance['text'] = (!empty($new_instance['text'])) ? strip_tags($new_instance['text']) : '';
        $instance['facebook'] = (!empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
        $instance['twitter'] = (!empty($new_instance['twitter'])) ? strip_tags($new_instance['twitter']) : '';
        $instance['linkedin'] = (!empty($new_instance['linkedin'])) ? strip_tags($new_instance['linkedin']) : '';
        $instance['google'] = (!empty($new_instance['google'])) ? strip_tags($new_instance['google']) : '';
        $instance['flickr'] = (!empty($new_instance['flickr'])) ? strip_tags($new_instance['flickr']) : '';
        $instance['feedburner'] = (!empty($new_instance['feedburner'])) ? strip_tags($new_instance['feedburner']) : '';
        $instance['youtube'] = (!empty($new_instance['youtube'])) ? strip_tags($new_instance['youtube']) : '';
        $instance['skype'] = (!empty($new_instance['skype'])) ? strip_tags($new_instance['skype']) : '';
        $instance['lastfm'] = (!empty($new_instance['lastfm'])) ? strip_tags($new_instance['lastfm']) : '';
        $instance['instagram'] = (!empty($new_instance['instagram'])) ? strip_tags($new_instance['instagram']) : '';
        $instance['deviantart'] = (!empty($new_instance['deviantart'])) ? strip_tags($new_instance['deviantart']) : '';
        $instance['pinterest'] = (!empty($new_instance['pinterest'])) ? strip_tags($new_instance['pinterest']) : '';
        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']); ?>
        <div class="w4p-main-wrapper">
        <?php echo $before_widget; //Before widget tags
        if (!empty($title)) {
            echo $before_title . $title . $after_title; //Output title with the before-after tags
        } ?>

        <div class="w4p-aboutme">
            <div class="w4p-aboutme-head">
                <div class="w4p-aboutme-photo">
                    <img src="<?php echo $instance['image_uri']; ?>"> <!-- Photo image -->
                </div>
            </div>
            <div class="w4p-aboutme-name-caption">
                <div class="w4p-aboutme-name"><?php echo $instance['name']; ?></div>
                <div class="w4p-aboutme-caption"><?php echo $instance['caption']; ?></div>
            </div>
            <div class="w4p-aboutme-body">
                <div class="body-text"><?php echo $instance['text']; ?></div>
            </div>
            <ul class="social-links">
                <?php //start social links output
                if (isset($instance['facebook']) && !empty($instance['facebook'])) {
                    ?>
                    <li class="w4p-facebook">
                        <a href="<?php echo $instance['facebook']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/FB.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['twitter']) && !empty($instance['twitter'])) {
                    ?>
                    <li class="w4p-twitter">
                        <a href="<?php echo $instance['twitter']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/Twitter.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['linkedin']) && !empty($instance['linkedin'])) {
                    ?>
                    <li class="w4p-linkedin">
                        <a href="<?php echo $instance['linkedin']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/LinkedIn.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['google']) && !empty($instance['google'])) {
                    ?>
                    <li class="w4p-google">
                        <a href="<?php echo $instance['google']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/G+.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['flickr']) && !empty($instance['flickr'])) {
                    ?>
                    <li class="w4p-flickr">
                        <a href="<?php echo $instance['flickr']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/Flickr.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['feedburner']) && !empty($instance['feedburner'])) {
                    ?>
                    <li class="w4p-feedburner">
                        <a href="<?php echo $instance['feedburner']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/FeedBurner.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['youtube']) && !empty($instance['youtube'])) {
                    ?>
                    <li class="w4p-youtube">
                        <a href="<?php echo $instance['youtube']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/YouTube.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['skype']) && !empty($instance['skype'])) {
                    ?>
                    <li class="w4p-skype">
                        <a href="<?php echo $instance['skype']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/Skype.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['lastfm']) && !empty($instance['lastfm'])) {
                    ?>
                    <li class="w4p-lastfm">
                        <a href="<?php echo $instance['lastfm']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/LastFM.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['instagram']) && !empty($instance['instagram'])) {
                    ?>
                    <li class="w4p-instagram">
                        <a href="<?php echo $instance['instagram']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/Instagram.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['deviantart']) && !empty($instance['deviantart'])) {
                    ?>
                    <li class="w4p-deviantart">
                        <a href="<?php echo $instance['deviantart']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/Deviantart.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                if (isset($instance['pinterest']) && !empty($instance['pinterest'])) {
                    ?>
                    <li class="w4p-pinterest">
                        <a href="<?php echo $instance['pinterest']; ?>" target="_blank">
                            <img src="<?php echo plugins_url('images/Pinterest.jpg', __FILE__); ?>">
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    <?php
    }
}