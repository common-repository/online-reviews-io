<?php
/*
Plugin Name: Sessionly.io
Plugin URI: https://Sessionly.io
Description: Sessionly.io is an All-in-one Feedback and CRO Suite for marketers. With our software, you receive 8 hot features accessible all over 1 tool. Start using Features like Heatmaps, Conversion Funnels, Website Feedback, Surveys, Polls, Customer Reviews and much more to optimize your webshop. The plugin allows you to easily setup Sessionly on your WordPress website. Install the plugin, add your Sessionly tracking code and start optimizing your website straight away.
Author: onlinereviewsio
Version: 1.1.0
*/

if (!defined('ABSPATH')) die();

register_deactivation_hook(__FILE__, 'online_reviews_io_uninstall');

$plugin = plugin_basename(__FILE__);

function online_reviews_io_uninstall()
{
    delete_option('online_reviews_io_options');
}

function online_reviews_io_init()
{
    register_setting('online_reviews_io_plugin_options', 'online_reviews_io_options', 'online_reviews_io_validate_options');
}
add_action ('admin_init', 'online_reviews_io_init');

// add the options page
function online_reviews_io_add_options_page()
{
    add_options_page('Sessionly.io', 'Sessionly.io', 'administrator', 'online_reviews_io_settings', 'online_reviews_io_render_form');
}
add_action ('admin_menu', 'online_reviews_io_add_options_page');

function online_reviews_io_render_form()
{
    $options = get_option('online_reviews_io_options'); ?>

    <h1>Sessionly.io <?php _e('Settings') ?></h1>
    <?php
    if (isset($options) && !empty($options)) { ?>
        <?php ?>
        <div class="updated">
            <p><?php _e('Tracking code is installed.') ?></p>
        </div>
    <?php } else { ?>
        <div class="error">
            <p><?php _e('Tracking code is not installed.') ?></p>
        </div>
    <?php } ?>

    <form method="post" action="options.php">
        <?php
        settings_fields('online_reviews_io_plugin_options');
        ?>
        <h3>Insert your Sessionly.io tracking code (save empty field to delete):</h3>
        <textarea name="online_reviews_io_options[online_reviews_io_tracking_code]" style="height:140px;width:50%;" spellcheck="false"><?= (isset($options['online_reviews_io_tracking_code']) && !empty($options['online_reviews_io_tracking_code'])) ? htmlspecialchars($options['online_reviews_io_tracking_code'], ENT_QUOTES) : '' ?></textarea>
        <p class="submit">
            <input type="submit" class="button button-primary button-large" name="update_message" value="<?php echo _e('Save Changes') ?>">
        </p>
    </form>
    <p> If you don’t have an Sessionly.io ID yet, please go to our <a href="http://Sessionly.io">website</a> and register your WordPress website to gain one.</p>
<?php
}
function online_reviews_io_print_errors()
{
    settings_errors('unique_identifyer');
}

function online_reviews_io_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=online_reviews_io_settings">Settings</a>';
    array_unshift($links, $settings_link);

    return $links;
}
add_filter("plugin_action_links_{$plugin}", 'online_reviews_io_settings_link');

function online_reviews_io_add_script()
{
    $options = get_option('online_reviews_io_options');

    if (isset($options['online_reviews_io_tracking_code'])) {
        echo $options['online_reviews_io_tracking_code'];
    }
}

add_action('wp_head', 'online_reviews_io_add_script');