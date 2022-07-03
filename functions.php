<?php
/**
 * Framexs functions and definitions
 *
 * @package Framexs
 * @since Framexs 0.1
 */

function xhtml($headers){
	$headers["Content-Type"] = "application/xhtml+xml; charset=UTF-8";
	return $headers;
}
add_filter("wp_headers","xhtml");

add_theme_support( 'title-tag' );

function sidebar() {
$permalink = $_SERVER['REQUEST_URI'];
error_log($permalink);

if($permalink == esc_url( home_url( '/sidebar.xhtml', 'relative') )){
//echo 'test';
include 'sidebar.php';
exit();
}
}
add_action("init","sidebar");

//妥当なXHTMLが出力されるように
function xbr( $content ) {
    $content = str_replace('<br>', '<br/>', $content);
	$content = str_replace('&nbsp;', ' ', $content);
    return $content;
}
add_filter('the_content', 'xbr');

/**
 * Framexsテーマのパネル追加
 */
function theme_settings_page(){
	?>
	    <div class="wrap">
	    <h1>Theme Panel</h1>
	    <form method="post" action="options.php">
			<fieldset>
			<legend>test</legend>
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button();
	        ?>
			</fieldset>
	    </form>
		<form method="post" action="" enctype="multipart/form-data">
			<?php
				settings_fields("section");
	            do_settings_sections("filesystem-controll");      
	            submit_button(); 
			?> 
		</form>
		</div>
	<?php
}

function add_theme_menu_item()
{
	add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");

/**
 * パネルの中身
 */

function display_framexs_themes_location_element()
{
	$ftl = get_option('framexs_themes_location');
	$exists = '存在していません。確認してください。';
	require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystemの使用
	if ( WP_Filesystem() ) {//WP_Filesystemの初期化
		global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
		if($wp_filesystem->exists($ftl)){
			$exists = '';
		}
	}
	?>
		<input type="text" name="framexs_themes_location" id="framexs_themes_location" value="<?php echo $ftl; ?>" />
    <?php
	echo $exists;

}

function display_theme_element()
{
	$framexs_themes = array();
	$ftl = get_option('framexs_themes_location');
	
	require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystemの使用
	if ( WP_Filesystem() ) {//WP_Filesystemの初期化
		global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
		$exists = '';
		foreach($wp_filesystem->dirlist($ftl) as $item){
			$theme_dir_name = $item['name'];
			$theme_location = $ftl.'/'.$theme_dir_name;
			$ftml_location = $theme_location.'/main.ftml';
			if($wp_filesystem->exists($ftml_location)){
				$ftml = $wp_filesystem->get_contents($ftml_location);
				$dom = new SimpleXMLElement($ftml);
				$checked = '';
				if($theme_dir_name === get_option('framexs_theme')) {
					$checked = 'checked=""';
				}
				array_push($framexs_themes, array(
					'dir'=>$theme_dir_name,
					'name'=>$dom->infomation->name,
					'repository'=>$dom->infomation->repository,
					'download'=>$dom->infomation->download,
					'checked'=>$checked
				));
			}
		}
	}
	?>
		<div>
			<ul>
			<?php foreach($framexs_themes as $framexs_theme) {
			?>
				<li>
					<div><input type="radio" name="framexs_theme" id="framexs_theme" value="<?php echo $framexs_theme['dir']; ?>" <?php echo $framexs_theme['checked']?> /></div>
					<div class="text">
						<div class="name"><?php echo $framexs_theme['name'];?></div>
						<div class="description"></div>
						<div>
							<input type="button" onclick="manage('delete','<?php echo $framexs_theme['name'];?>');" value="delete">
							<input type="button" onclick="manage('fetch','<?php echo $framexs_theme['name'];?>');" value="fetch">
							<input type="button" onclick="manage('pull','<?php echo $framexs_theme['name'];?>');" value="pull">
						</div>
					</div>
				</li>
			
			<?php } ?>
			</ul>
		</div>
    <?php
}
function install_theme_element() {
	if($_FILES) {
		echo "uploaded";
	} else {
		echo "yet";
	}
	require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystemの使用
	if ( WP_Filesystem() ) {//WP_Filesystemの初期化
		global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し

	}
	?>
	<div>
		
		zip:<input type="file" name="zip" accept="application/zip">
	</div>
	<?php
}
function display_properties_location_element(){
	$pl = get_option("properties_location");
	require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystemの使用
	$properties_array = array();
	if ( WP_Filesystem() ) {//WP_Filesystemの初期化
		global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
		if($pl){
			foreach($wp_filesystem->dirlist($pl) as $item){
				array_push($properties_array,$item['name']);
			}
		}
	}
	?>
	<div>
		<input type="text" name="properties_location" id="properties_location" value="<?php echo $pl;?>">
	</div>
	<p>削除するファイルにチェックを入れてください。</p>
	<ul>
		<?php
			foreach($properties_array as $item){
				echo "<li><label><input type=\"checkbox\" name=\"file_del[]\" id=\"file_del[]\" value=\"".$item."\">".$item."</label></li>";
			}
		?>
	</ul>
	<?php
}
function upload_properties_element(){
	if($_FILES) {
		echo "uploaded:";
	} else {
		echo "yet";
	}
	$pl = get_option("properties_location");
	require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystemの使用
	if ( WP_Filesystem() ) {//WP_Filesystemの初期化
		global $wp_filesystem;//$wp_filesystemオブジェクトの呼び出し
		if($_FILES && $_FILES['properties']){
			$files = $_FILES['properties'];
			// Count # of uploaded files in array
			$total = count($files['name']);

			// Loop through each file
			for( $i=0 ; $i < $total ; $i++ ) {

			//Get the temp file path
			$tmpFilePath = $files['tmp_name'][$i];

			//Make sure we have a file path
			if ($tmpFilePath != ""){
				//Setup our new file path
				$newFilePath = $pl.'/'.$files['name'][$i];

				//Upload the file into the temp dir
				if($wp_filesystem->move($tmpFilePath, $newFilePath, true)) {

				//Handle other code here

					echo 'success'.$newFilePath;
				}
			}
		}
		}
	}
	?>
	<div>
		<label>properties:<input type="file" name="properties[]" id="properties" accept="text/xml" multiple></label>
	</div>
	<?php
}
function test() {
	?>
	<div>test</div>
	<?php
}
function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
    add_settings_field("framexs_themes_location", "Framexs themes location", "display_framexs_themes_location_element", "theme-options", "section");
    register_setting("section", "framexs_themes_location");

    add_settings_field("framexs_theme", "Framexs theme", "display_theme_element", "theme-options", "section");
    register_setting("section", "framexs_theme");

	add_settings_field("properties_location", "properties location", "display_properties_location_element", "theme-options", "section");
	register_setting("section", "properties_location");

	add_settings_section("test-section", "Test", null, "theme-options");

	add_settings_field("test", "test", "test", "theme-options", "test-section");
	
	add_settings_section("section", "upload", null, "filesystem-controll");

	add_settings_field("install_framexs_theme", "Framex Theme Install", "install_theme_element", "filesystem-controll", "section");

	add_settings_field("upload_properties", "upload properites", "upload_properties_element", "filesystem-controll", "section");

	add_settings_field("test", "test", "test", "filesystem-controll", "section");
}

add_action("admin_init", "display_theme_panel_fields");

add_action('admin_print_scripts', 'myplugin_js_admin_header' );

function myplugin_js_admin_header() // これはPHP関数
{
  // JavascriptのSACKライブラリをAjaxに使用
  wp_print_scripts( array( 'sack' ));

  // カスタムJavascript関数の定義
?>
<script type="text/javascript">
//<![CDATA[
function myplugin_ajax_elevation( lat_field, long_field, elev_field )
{
    jQuery(function($){
    $('.more').click(function(){
         var id = $(this).attr('data-id');

		$.ajax({
            type : "post",
            data : {
                action: 'get_post_content',
                post_id: id,
            },
            url : "<?php echo admin_url('admin-ajax.php'); ?>",
            success: function(res) {
               // ここに受け取ったデータの処理を書く
			   $('#post-' + id).html(res);
            }
        });
    });
});
} // Javascript関数myplugin_ajax_elevation終わり
//]]>
</script>
<?php
// PHP関数myplugin_js_admin_header終わり
}
function manage_framexs_theme()
{
	$themes_location = get_option('framexs_themes_location');
	$theme = $_POST['theme'];
	$method = $_POST['method'];
	$output = array();
	$result_code = 0;
	$json = null;
	if($method == 'delete') {

	} else if($method == 'fetch') {
		exec("fetch.sh ".$themes_location.$theme, $output, $result_code);
		$json = array('output'=>'"'.$output.'"', 'status_code'=>$result_code);
	} else if($method == 'pull') {

	} else if($method == 'download') {

	}
	echo $json;
	wp_die();
}
add_action('wp_ajax_manage', 'manage_framexs_theme');
?>