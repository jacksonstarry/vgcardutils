<?php
/*
 Plugin Name: The一灭寂专用咔嚓插件
 Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 Description: The一灭寂专用咔嚓插件
 Version: 1.0
 Author: Colin Trinity
 Author URI: http://blog.colintrinity.com
 */

/*  Copyright 2012-2014 柯林  (email : colintrinityls@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
add_action('admin_menu', 'vg_card_create_menu');

global $vgcardutils_db_table_version;
$vgcardutils_db_table_version = "1.0.3";

function place_vg_card_list_here() {
	echo '
		<div id="queries_result"></div>
		<div id="queries_paging"></div>
	';
}

function place_vg_card($id) {
	global $wpdb;
	$query = "SELECT "
	."`Cards`.`id` AS `id`, "
	."`Cards`.`title`, "
	."`subtitle`, `serial`, `popular_name`, `unittype`, `grade`, `power`, `shield`, `critical`, `trigger`, `skill`, `effect`, `flavor_text`, `illustrator`, `remark`, "
	."`Rarities`.`title` AS `rarity`, "
	."`Expansions`.`title` AS `expansion`, "
	."`Clans`.`title` AS `clan`, "
	."`Nations`.`title` AS `nation` "
	." FROM `" .$wpdb->prefix . "plugin_vgcardutils_cards` AS `Cards`"
	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_rarities"." AS `Rarities` ON (`rarity_id` = `Rarities`.`id`) "
	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_expansions"." AS `Expansions` ON (`expansion_id` = `Expansions`.`id`) "
	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_clans"." AS `Clans` ON (`clan_id` = `Clans`.`id`) "
	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_nations"." AS `Nations` ON (`Clans`.`nation_id` = `Nations`.`id`) "
	."WHERE `Cards`.`id` = %d "
	.'LIMIT 1';
	$result = $wpdb->get_row($wpdb->prepare($query,array('%d'=>$id)));
	if($result) {
		?>
<div class="vgCards view">
<h2>卡牌</h2>
<dl>
	<dt>编号</dt>
	<dd><?php echo $result->serial; ?>&nbsp;</dd>
	<dt>标题</dt>
	<dd><?php echo $result->title; ?>&nbsp;</dd>
	<dt>副标题</dt>
	<dd><?php echo $result->subtitle; ?>&nbsp;</dd>
	<dt>Popular name</dt>
	<dd><?php echo $result->popular_name; ?>&nbsp;</dd>
	<dt>单位类型</dt>
	<dd><?php echo $result->unittype; ?>&nbsp;</dd>
	<dt>卡包</dt>
	<dd><?php echo $result->expansion; ?>&nbsp;</dd>
	<dt>等级</dt>
	<dd><?php echo $result->grade; ?>&nbsp;</dd>
	<dt>力量</dt>
	<dd><?php echo $result->power; ?>&nbsp;</dd>
	<dt>盾护</dt>
	<dd><?php echo $result->shield; ?>&nbsp;</dd>
	<dt>☆</dt>
	<dd><?php echo $result->critical; ?>&nbsp;</dd>
	<dt>触发</dt>
	<dd><?php echo $result->trigger; ?>&nbsp;</dd>
	<dt>国家</dt>
	<dd><?php echo $result->nation; ?>&nbsp;</dd>
	<dt>集团</dt>
	<dd><?php echo $result->clan; ?>&nbsp;</dd>
	<dt>罕见度</dt>
	<dd><?php echo $result->serial; ?>&nbsp;</dd>
	<dt>种族</dt>
	<dd><?php echo $result->rarity; ?>&nbsp;</dd>
	<dt>技能</dt>
	<dd><?php echo $result->skill; ?>&nbsp;</dd>
	<dt>特效</dt>
	<dd><?php echo $result->effect; ?>&nbsp;</dd>
	<dt>台词</dt>
	<dd><?php echo $result->flavor_text; ?>&nbsp;</dd>
	<dt>画师</dt>
	<dd><?php echo $result->illustrator; ?>&nbsp;</dd>
	<dt>备注</dt>
	<dd><?php echo $result->remark; ?>&nbsp;</dd>
	<dt>Card Image</dt>
	<dd><img src="/img/cards/EB01_002.jpg" alt="" /></dd>
	<dt>Card Thumbnail</dt>
	<dd><img src="/img/cards/thumbnail/thumbnail_EB01_002.jpg" alt="" /></dd>
	<dt>Vg Tags</dt>
	<dd>
	<ul id="tagsList">
		<li><a href="javascript:5">手牌丢弃</a></li>
		<li><a href="javascript:29">力量降低</a></li>
	</ul>
	</dd>
</dl>
</div>
		<?php }
}
wp_enqueue_style('vg_card_ajax_style',plugins_url( '/css/styles.css' , __FILE__));
wp_enqueue_script( 'vg_card_ajax_js', plugins_url( '/js/cardajax.js' , __FILE__), array( 'jquery' ));

add_filter('query_vars', 'vgcardutils_queryvars' );

global $__VGPowerEnum__;
$__VGPowerEnum__ = array('-',0,1000,2000,3000,4000,5000,6000,7000,8000,9000,10000,11000,12000,13000);
global $__VGUnittypeEnum__;
$__VGUnittypeEnum__ = array(1=>'普通单位',2=>'触发单位');
global $__VGGradeEnum__;
$__VGGradeEnum__ = array('-',3,2,1,0,4);
global $__VGShieldEnum__;
$__VGShieldEnum__ = array('-','-',0,5000,10000);
global $__VGCriticalEnum__;
$__VGCriticalEnum__ = array('-',1,2,3);
global $__VGTriggerEnum__;
$__VGTriggerEnum__ = array('-','-','醒','治','引','☆');
global $__VGSkillEnum__;
$__VGSkillEnum__ = array('-','双判','截击','支援');


function vgcardutils_queryvars( $vars )
{
	$vars[] = 'card';
	return $vars;
}

function vg_card_create_menu() {
	global $vgcardutils_db_table_version;
	$installed_ver = get_option( "vgcardutils_db_table_version" );
	$main_menu_slug = plugin_dir_path(__FILE__);
	if($installed_ver && $vgcardutils_db_table_version==$installed_ver) {
		//create new top-level menu
		add_menu_page('一灭寂咔嚓™设置', '咔嚓™', 'edit_posts',$main_menu_slug, 'vg_card_list_page', plugins_url('/img/menu-icon.gif', __FILE__));
		add_submenu_page($main_menu_slug,'一灭寂咔嚓设置', '所有卡片', 'read', $main_menu_slug, 'vg_card_list_page');
		add_submenu_page($main_menu_slug,'一灭寂咔嚓设置', '添加卡片', 'edit_posts', $main_menu_slug.'add', 'vg_card_add_page');
		add_submenu_page($main_menu_slug,'一灭寂咔嚓设置', '我的咔嚓', 'edit_posts', $main_menu_slug.'my', 'vg_card_my_page');
		add_submenu_page($main_menu_slug,'一灭寂咔嚓设置', '管理', 'administrator', $main_menu_slug.'options', 'vg_card_settings_page');
	} else {
		include plugin_dir_path(__FILE__).'install.php';
		add_menu_page('一灭寂咔嚓™设置', '咔嚓™', 'administrator',$main_menu_slug, 'vg_card_install_page', plugins_url('/img/menu-icon.gif', __FILE__));
	}
}

?>
<?php
include plugin_dir_path(__FILE__).'list.php';
?>
<?php
include plugin_dir_path(__FILE__).'add.php';
?>
<?php
include plugin_dir_path(__FILE__).'my.php';
?>
<?php
include plugin_dir_path(__FILE__).'ajax.php';
?>
<?php
include plugin_dir_path(__FILE__).'options.php';
?>
