<?php
function wp_child_theme()
{
	wp_enqueue_style("parent-stylesheet", get_template_directory_uri()."/style.css");
	wp_enqueue_style("child-stylesheet", get_stylesheet_uri());
	wp_enqueue_script("child-scripts", get_stylesheet_directory_uri() . "/js/scripts.js", array("jquery"), "6.1.1", true);
}
add_action("wp_enqueue_scripts", "wp_child_theme");

if((get_option("wp_child_theme_setting")) == 1) 
{
	function wp_child_theme_parent() 
	{
		wp_dequeue_style("parent-stylesheet");
	}
	add_action("wp_enqueue_scripts", "wp_child_theme_parent");
}

function wp_child_theme_register_settings() 
{ 
	register_setting("wp_child_theme_options_page", "wp_child_theme_setting", "wct_callback");
    register_setting("wp_child_theme_options_page", "wp_child_theme_setting_html", "wct_callback");
}
add_action("admin_init", "wp_child_theme_register_settings");

function wp_child_theme_register_options_page() 
{
	add_options_page("Child Theme Settings", "Child Theme", "manage_options", "wp_child_theme", "wp_child_theme_register_options_page_form");
}
add_action("admin_menu", "wp_child_theme_register_options_page");

if(get_option("wp_child_theme_setting_html") != 1)
{
	function html_credit()
	{
	if(is_home()){
	?>
	<div style="text-align:center;"><a href="https://www.wordpresschildtheme.com">wordpresschildtheme.com</a></div>
	<?php
	}
	}
	add_action("wp_footer", "html_credit", 9);
}

function wp_child_theme_register_options_page_form()
{ 
?>
<div id="wp_child_theme">
	<h1>Child Theme Options</h1>
	<form method="post" action="options.php">
		<?php settings_fields("wp_child_theme_options_page"); ?>
		<p><label><input size="3" type="checkbox" name="wp_child_theme_setting" value="1" <?php if((get_option("wp_child_theme_setting") == 1)) { echo " checked "; } ?> > Tick to disable the parent stylesheet<label></p>
        <p><label><input size="3" type="checkbox" name="wp_child_theme_setting_html" value="1" <?php if((get_option("wp_child_theme_setting_html") == 1)) { echo " checked "; } ?> > Tick to disable the thank you link in the footer</p>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}