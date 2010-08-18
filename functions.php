<?php
/**
 * @package WordPress
 * @subpackage HTML5_Boilerplate
 */

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

       <nav>
         <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
       </nav>
     </article>
    <!-- </li> is added by wordpress automatically -->
<?php
}






$content_width = 450;

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<section>',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

/** @ignore */
function kubrick_head() {
	$head = "<style type='text/css'>\n<!--";
	$output = '';
	if ( kubrick_header_image() ) {
		$url =  kubrick_header_image_url() ;
		$output .= "#header { background: url('$url') no-repeat bottom center; }\n";
	}
	if ( false !== ( $color = kubrick_header_color() ) ) {
		$output .= "#headerimg h1 a, #headerimg h1 a:visited, #headerimg .description { color: $color; }\n";
	}
	if ( false !== ( $display = kubrick_header_display() ) ) {
		$output .= "#headerimg { display: $display }\n";
	}
	$foot = "--></style>\n";
	if ( '' != $output )
		echo $head . $output . $foot;
}

add_action('wp_head', 'kubrick_head');

function kubrick_header_image() {
	return apply_filters('kubrick_header_image', get_option('kubrick_header_image'));
}

function kubrick_upper_color() {
	if (strpos($url = kubrick_header_image_url(), 'header-img.php?') !== false) {
		parse_str(substr($url, strpos($url, '?') + 1), $q);
		return $q['upper'];
	} else
		return '69aee7';
}

function kubrick_lower_color() {
	if (strpos($url = kubrick_header_image_url(), 'header-img.php?') !== false) {
		parse_str(substr($url, strpos($url, '?') + 1), $q);
		return $q['lower'];
	} else
		return '4180b6';
}

function kubrick_header_image_url() {
	if ( $image = kubrick_header_image() )
		$url = get_template_directory_uri() . '/images/' . $image;
	else
		$url = get_template_directory_uri() . '/images/kubrickheader.jpg';

	return $url;
}

function kubrick_header_color() {
	return apply_filters('kubrick_header_color', get_option('kubrick_header_color'));
}

function kubrick_header_color_string() {
	$color = kubrick_header_color();
	if ( false === $color )
		return 'white';

	return $color;
}

function kubrick_header_display() {
	return apply_filters('kubrick_header_display', get_option('kubrick_header_display'));
}

function kubrick_header_display_string() {
	$display = kubrick_header_display();
	return $display ? $display : 'inline';
}

add_action('admin_menu', 'kubrick_add_theme_page');

function kubrick_add_theme_page() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == basename(__FILE__) ) {
		if ( isset( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
			check_admin_referer('kubrick-header');
			if ( isset($_REQUEST['njform']) ) {
				if ( isset($_REQUEST['defaults']) ) {
					delete_option('kubrick_header_image');
					delete_option('kubrick_header_color');
					delete_option('kubrick_header_display');
				} else {
					if ( '' == $_REQUEST['njfontcolor'] )
						delete_option('kubrick_header_color');
					else {
						$fontcolor = preg_replace('/^.*(#[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['njfontcolor']);
						update_option('kubrick_header_color', $fontcolor);
					}
					if ( preg_match('/[0-9A-F]{6}|[0-9A-F]{3}/i', $_REQUEST['njuppercolor'], $uc) && preg_match('/[0-9A-F]{6}|[0-9A-F]{3}/i', $_REQUEST['njlowercolor'], $lc) ) {
						$uc = ( strlen($uc[0]) == 3 ) ? $uc[0]{0}.$uc[0]{0}.$uc[0]{1}.$uc[0]{1}.$uc[0]{2}.$uc[0]{2} : $uc[0];
						$lc = ( strlen($lc[0]) == 3 ) ? $lc[0]{0}.$lc[0]{0}.$lc[0]{1}.$lc[0]{1}.$lc[0]{2}.$lc[0]{2} : $lc[0];
						update_option('kubrick_header_image', "header-img.php?upper=$uc&lower=$lc");
					}

					if ( isset($_REQUEST['toggledisplay']) ) {
						if ( false === get_option('kubrick_header_display') )
							update_option('kubrick_header_display', 'none');
						else
							delete_option('kubrick_header_display');
					}
				}
			} else {

				if ( isset($_REQUEST['headerimage']) ) {
					check_admin_referer('kubrick-header');
					if ( '' == $_REQUEST['headerimage'] )
						delete_option('kubrick_header_image');
					else {
						$headerimage = preg_replace('/^.*?(header-img.php\?upper=[0-9a-fA-F]{6}&lower=[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['headerimage']);
						update_option('kubrick_header_image', $headerimage);
					}
				}

				if ( isset($_REQUEST['fontcolor']) ) {
					check_admin_referer('kubrick-header');
					if ( '' == $_REQUEST['fontcolor'] )
						delete_option('kubrick_header_color');
					else {
						$fontcolor = preg_replace('/^.*?(#[0-9a-fA-F]{6})?.*$/', '$1', $_REQUEST['fontcolor']);
						update_option('kubrick_header_color', $fontcolor);
					}
				}

				if ( isset($_REQUEST['fontdisplay']) ) {
					check_admin_referer('kubrick-header');
					if ( '' == $_REQUEST['fontdisplay'] || 'inline' == $_REQUEST['fontdisplay'] )
						delete_option('kubrick_header_display');
					else
						update_option('kubrick_header_display', 'none');
				}
			}
			//print_r($_REQUEST);
			wp_redirect("themes.php?page=functions.php&saved=true");
			die;
		}
		add_action('admin_head', 'kubrick_theme_page_head');
	}
	add_theme_page(__('Custom Header'), __('Custom Header'), 'edit_themes', basename(__FILE__), 'kubrick_theme_page');
}

function kubrick_theme_page_head() {
?>
<script type="text/javascript" src="../wp-includes/js/colorpicker.js"></script>
<script type='text/javascript'>
// <![CDATA[
	function pickColor(color) {
		ColorPicker_targetInput.value = color;
		kUpdate(ColorPicker_targetInput.id);
	}
	function PopupWindow_populate(contents) {
		contents += '<br /><p style="text-align:center;margin-top:0px;"><input type="button" class="button-secondary" value="<?php esc_attr_e('Close Color Picker'); ?>" onclick="cp.hidePopup(\'prettyplease\')"></input></p>';
		this.contents = contents;
		this.populated = false;
	}
	function PopupWindow_hidePopup(magicword) {
		if ( magicword != 'prettyplease' )
			return false;
		if (this.divName != null) {
			if (this.use_gebi) {
				document.getElementById(this.divName).style.visibility = "hidden";
			}
			else if (this.use_css) {
				document.all[this.divName].style.visibility = "hidden";
			}
			else if (this.use_layers) {
				document.layers[this.divName].visibility = "hidden";
			}
		}
		else {
			if (this.popupWindow && !this.popupWindow.closed) {
				this.popupWindow.close();
				this.popupWindow = null;
			}
		}
		return false;
	}
	function colorSelect(t,p) {
		if ( cp.p == p && document.getElementById(cp.divName).style.visibility != "hidden" )
			cp.hidePopup('prettyplease');
		else {
			cp.p = p;
			cp.select(t,p);
		}
	}
	function PopupWindow_setSize(width,height) {
		this.width = 162;
		this.height = 210;
	}

	var cp = new ColorPicker();
	function advUpdate(val, obj) {
		document.getElementById(obj).value = val;
		kUpdate(obj);
	}
	function kUpdate(oid) {
		if ( 'uppercolor' == oid || 'lowercolor' == oid ) {
			uc = document.getElementById('uppercolor').value.replace('#', '');
			lc = document.getElementById('lowercolor').value.replace('#', '');
			hi = document.getElementById('headerimage');
			hi.value = 'header-img.php?upper='+uc+'&lower='+lc;
			document.getElementById('header').style.background = 'url("<?php echo get_template_directory_uri(); ?>/images/'+hi.value+'") center no-repeat';
			document.getElementById('advuppercolor').value = '#'+uc;
			document.getElementById('advlowercolor').value = '#'+lc;
		}
		if ( 'fontcolor' == oid ) {
			document.getElementById('header').style.color = document.getElementById('fontcolor').value;
			document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value;
		}
		if ( 'fontdisplay' == oid ) {
			document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
		}
	}
	function toggleDisplay() {
		td = document.getElementById('fontdisplay');
		td.value = ( td.value == 'none' ) ? 'inline' : 'none';
		kUpdate('fontdisplay');
	}
	function toggleAdvanced() {
		a = document.getElementById('jsAdvanced');
		if ( a.style.display == 'none' )
			a.style.display = 'block';
		else
			a.style.display = 'none';
	}
	function kDefaults() {
		document.getElementById('headerimage').value = '';
		document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#69aee7';
		document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#4180b6';
		document.getElementById('header').style.background = 'url("<?php echo get_template_directory_uri(); ?>/images/kubrickheader.jpg") center no-repeat';
		document.getElementById('header').style.color = '#FFFFFF';
		document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '';
		document.getElementById('fontdisplay').value = 'inline';
		document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
	}
	function kRevert() {
		document.getElementById('headerimage').value = '<?php echo esc_js(kubrick_header_image()); ?>';
		document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#<?php echo esc_js(kubrick_upper_color()); ?>';
		document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#<?php echo esc_js(kubrick_lower_color()); ?>';
		document.getElementById('header').style.background = 'url("<?php echo esc_js(kubrick_header_image_url()); ?>") center no-repeat';
		document.getElementById('header').style.color = '';
		document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '<?php echo esc_js(kubrick_header_color_string()); ?>';
		document.getElementById('fontdisplay').value = '<?php echo esc_js(kubrick_header_display_string()); ?>';
		document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
	}
	function kInit() {
		document.getElementById('jsForm').style.display = 'block';
		document.getElementById('nonJsForm').style.display = 'none';
	}
	addLoadEvent(kInit);
// ]]>
</script>
<style type='text/css'>
	#headwrap {
		text-align: center;
	}
	#kubrick-header {
		font-size: 80%;
	}
	#kubrick-header .hibrowser {
		width: 780px;
		height: 260px;
		overflow: scroll;
	}
	#kubrick-header #hitarget {
		display: none;
	}
	#kubrick-header #header h1 {
		font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
		font-weight: bold;
		font-size: 4em;
		text-align: center;
		padding-top: 70px;
		margin: 0;
	}

	#kubrick-header #header .description {
		font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
		font-size: 1.2em;
		text-align: center;
	}
	#kubrick-header #header {
		text-decoration: none;
		color: <?php echo kubrick_header_color_string(); ?>;
		padding: 0;
		margin: 0;
		height: 200px;
		text-align: center;
		background: url('<?php echo kubrick_header_image_url(); ?>') center no-repeat;
	}
	#kubrick-header #headerimg {
		margin: 0;
		height: 200px;
		width: 100%;
		display: <?php echo kubrick_header_display_string(); ?>;
	}
	
	.description {
		margin-top: 16px;
		color: #fff;
	}

	#jsForm {
		display: none;
		text-align: center;
	}
	#jsForm input.submit, #jsForm input.button, #jsAdvanced input.button {
		padding: 0px;
		margin: 0px;
	}
	#advanced {
		text-align: center;
		width: 620px;
	}
	html>body #advanced {
		text-align: center;
		position: relative;
		left: 50%;
		margin-left: -380px;
	}
	#jsAdvanced {
		text-align: right;
	}
	#nonJsForm {
		position: relative;
		text-align: left;
		margin-left: -370px;
		left: 50%;
	}
	#nonJsForm label {
		padding-top: 6px;
		padding-right: 5px;
		float: left;
		width: 100px;
		text-align: right;
	}
	.defbutton {
		font-weight: bold;
	}
	.zerosize {
		width: 0px;
		height: 0px;
		overflow: hidden;
	}
	#colorPickerDiv a, #colorPickerDiv a:hover {
		padding: 1px;
		text-decoration: none;
		border-bottom: 0px;
	}
</style>
<?php
}

function kubrick_theme_page() {
	if ( isset( $_REQUEST['saved'] ) ) echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';
?>
<div class='wrap'>
	<h2><?php _e('Customize Header'); ?></h2>
	<div id="kubrick-header">
		<div id="headwrap">
			<div id="header">
				<div id="headerimg">
					<h1><?php bloginfo('name'); ?></h1>
					<div class="description"><?php bloginfo('description'); ?></div>
				</div>
			</div>
		</div>
		<br />
		<div id="nonJsForm">
			<form method="post" action="">
				<?php wp_nonce_field('kubrick-header'); ?>
				<div class="zerosize"><input type="submit" name="defaultsubmit" value="<?php esc_attr_e('Save'); ?>" /></div>
					<label for="njfontcolor"><?php _e('Font Color:'); ?></label><input type="text" name="njfontcolor" id="njfontcolor" value="<?php echo esc_attr(kubrick_header_color()); ?>" /> <?php printf(__('Any CSS color (%s or %s or %s)'), '<code>red</code>', '<code>#FF0000</code>', '<code>rgb(255, 0, 0)</code>'); ?><br />
					<label for="njuppercolor"><?php _e('Upper Color:'); ?></label><input type="text" name="njuppercolor" id="njuppercolor" value="#<?php echo esc_attr(kubrick_upper_color()); ?>" /> <?php printf(__('HEX only (%s or %s)'), '<code>#FF0000</code>', '<code>#F00</code>'); ?><br />
				<label for="njlowercolor"><?php _e('Lower Color:'); ?></label><input type="text" name="njlowercolor" id="njlowercolor" value="#<?php echo esc_attr(kubrick_lower_color()); ?>" /> <?php printf(__('HEX only (%s or %s)'), '<code>#FF0000</code>', '<code>#F00</code>'); ?><br />
				<input type="hidden" name="hi" id="hi" value="<?php echo esc_attr(kubrick_header_image()); ?>" />
				<input type="submit" name="toggledisplay" id="toggledisplay" value="<?php esc_attr_e('Toggle Text'); ?>" />
				<input type="submit" name="defaults" value="<?php esc_attr_e('Use Defaults'); ?>" />
				<input type="submit" class="defbutton" name="submitform" value="&nbsp;&nbsp;<?php esc_attr_e('Save'); ?>&nbsp;&nbsp;" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="njform" value="true" />
			</form>
		</div>
		<div id="jsForm">
			<form style="display:inline;" method="post" name="hicolor" id="hicolor" action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>">
				<?php wp_nonce_field('kubrick-header'); ?>
	<input type="button"  class="button-secondary" onclick="tgt=document.getElementById('fontcolor');colorSelect(tgt,'pick1');return false;" name="pick1" id="pick1" value="<?php esc_attr_e('Font Color'); ?>"></input>
		<input type="button" class="button-secondary" onclick="tgt=document.getElementById('uppercolor');colorSelect(tgt,'pick2');return false;" name="pick2" id="pick2" value="<?php esc_attr_e('Upper Color'); ?>"></input>
		<input type="button" class="button-secondary" onclick="tgt=document.getElementById('lowercolor');colorSelect(tgt,'pick3');return false;" name="pick3" id="pick3" value="<?php esc_attr_e('Lower Color'); ?>"></input>
				<input type="button" class="button-secondary" name="revert" value="<?php esc_attr_e('Revert'); ?>" onclick="kRevert()" />
				<input type="button" class="button-secondary" value="<?php esc_attr_e('Advanced'); ?>" onclick="toggleAdvanced()" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="fontdisplay" id="fontdisplay" value="<?php echo esc_attr(kubrick_header_display()); ?>" />
				<input type="hidden" name="fontcolor" id="fontcolor" value="<?php echo esc_attr(kubrick_header_color()); ?>" />
				<input type="hidden" name="uppercolor" id="uppercolor" value="<?php echo esc_attr(kubrick_upper_color()); ?>" />
				<input type="hidden" name="lowercolor" id="lowercolor" value="<?php echo esc_attr(kubrick_lower_color()); ?>" />
				<input type="hidden" name="headerimage" id="headerimage" value="<?php echo esc_attr(kubrick_header_image()); ?>" />
				<p class="submit"><input type="submit" name="submitform" class="button-primary" value="<?php esc_attr_e('Update Header'); ?>" onclick="cp.hidePopup('prettyplease')" /></p>
			</form>
			<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;visibility:hidden;"> </div>
			<div id="advanced">
				<form id="jsAdvanced" style="display:none;" action="">
					<?php wp_nonce_field('kubrick-header'); ?>
					<label for="advfontcolor"><?php _e('Font Color (CSS):'); ?> </label><input type="text" id="advfontcolor" onchange="advUpdate(this.value, 'fontcolor')" value="<?php echo esc_attr(kubrick_header_color()); ?>" /><br />
					<label for="advuppercolor"><?php _e('Upper Color (HEX):');?> </label><input type="text" id="advuppercolor" onchange="advUpdate(this.value, 'uppercolor')" value="#<?php echo esc_attr(kubrick_upper_color()); ?>" /><br />
					<label for="advlowercolor"><?php _e('Lower Color (HEX):'); ?> </label><input type="text" id="advlowercolor" onchange="advUpdate(this.value, 'lowercolor')" value="#<?php echo esc_attr(kubrick_lower_color()); ?>" /><br />
					<input type="button" class="button-secondary" name="default" value="<?php esc_attr_e('Select Default Colors'); ?>" onclick="kDefaults()" /><br />
					<input type="button" class="button-secondary" onclick="toggleDisplay();return false;" name="pick" id="pick" value="<?php esc_attr_e('Toggle Text Display'); ?>"></input><br />
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>
