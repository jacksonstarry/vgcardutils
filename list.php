<?phpinclude plugin_dir_path(__FILE__).'includes/class-vgcards-list-table.php';function vg_card_list_page() {	if ( isset($_REQUEST['card']) ) {		vg_card_view_page($_REQUEST['card']);		return;	}	//Create an instance of our package class...	$table = new VgCards_List_Table();	//Fetch, prepare, sort, and filter our data...	$table->prepare_items();	?><div class="wrap"><div id="icon-users" class="icon32"><br /></div><h2>所有卡片</h2><!--                <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">            <p>This page demonstrates the use of the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt> class in plugins.</p>             <p>For a detailed explanation of using the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt>            class in your own plugins, you can view this file <a href="/wp-admin/plugin-editor.php?plugin=table-test/table-test.php" style="text-decoration:none;">in the Plugin Editor</a> or simply open <tt style="color:gray;"><?php echo __FILE__ ?></tt> in the PHP editor of your choice.</p>            <p>Additional class details are available on the <a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WordPress Codex</a>.</p>        </div>                --><!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions --><form id="movies-filter" method="get"><!-- For plugins, we also need to ensure that the form posts back to our current page --><input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" /><!-- Now we can render the completed list table --> <?php $table->display() ?></form></div><?php }?><?php function vg_card_view_page($id) {	global $wpdb;	$query = "SELECT "	."`Cards`.`id` AS `id`, "	."`Cards`.`title`, "	."`subtitle`, `serial`, `popular_name`, `unittype`, `grade`, `power`, `shield`, `critical`, `trigger`, `skill`, `effect`, `flavor_text`, `illustrator`, `remark`, "	."`Rarities`.`title` AS `rarity`, "	."`Expansions`.`title` AS `expansion`, "	."`Clans`.`title` AS `clan`, "	."`Nations`.`title` AS `nation` "	." FROM `" .$wpdb->prefix . "plugin_vgcardutils_cards` AS `Cards`"	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_rarities"." AS `Rarities` ON (`rarity_id` = `Rarities`.`id`) "	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_expansions"." AS `Expansions` ON (`expansion_id` = `Expansions`.`id`) "	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_clans"." AS `Clans` ON (`clan_id` = `Clans`.`id`) "	."LEFT JOIN ".$wpdb->prefix . "plugin_vgcardutils_nations"." AS `Nations` ON (`Clans`.`nation_id` = `Nations`.`id`) "	."WHERE `Cards`.`id` = %d "	.'LIMIT 1';	$result = $wpdb->get_row($wpdb->prepare($query,array('%d'=>$id)));	?><div class="wrap"><div id="icon-plugins" class="icon32"><br></div><h2>查看</h2><table class="form-table">	<tr valign="top">		<th scope="row">序列号</th>		<td><?php echo $result->serial ?></td>	</tr>	<tr valign="top">		<th scope="row">卡名</th>		<td><?php echo $result->title; ?></td>	</tr>	<tr valign="top">		<th scope="row">副卡名</th>		<td><?php echo $result->subtitle; ?></td>	</tr>	<tr valign="top">		<th scope="row">俗称</th>		<td><?php echo $result->popular_name; ?></td>	</tr>	<tr valign="top">		<th scope="row">单位类型</th>		<td><?php switch( $result->unittype) {				case 1:			?>			普通单位			<?php break?>			<?php case 2:?>			触发单位			<?php break?>		<?php }?></td>	</tr>	<tr valign="top">		<th scope="row">卡包</th>		<td><?php			echo $result->expansion;		?></td>	</tr>	<tr valign="top">		<th scope="row">等级</th>		<td><?php echo $result->grade; ?></td>	</tr>	<tr valign="top">		<th scope="row">力量</th>		<td><?php echo $result->power; ?></td>	</tr>	<tr valign="top">		<th scope="row">盾护</th>		<td><?php echo $result->shield; ?></td>	</tr>	<tr valign="top">		<th scope="row">☆</th>		<td><?php echo $result->critical; ?></td>	</tr>	<tr valign="top">		<th scope="row">触发</th>		<td><?php echo $result->trigger; ?></td>	</tr>	<tr valign="top">		<th scope="row">国家</th>		<td><?php echo $result->nation; ?></td>	</tr>	<tr valign="top">		<th scope="row">集团</th>		<td><?php echo $result->clan; ?></td>	</tr>	<tr valign="top">		<th scope="row">罕见度</th>		<td><?php echo $result->rarity; ?></td>	</tr>	<tr valign="top">		<th scope="row">种族</th>		<td><?php echo $result->race; ?></td>	</tr>	<tr valign="top">		<th scope="row">技能</th>		<td><?php echo $result->skill; ?></td>	</tr>	<tr valign="top">		<th scope="row">特效</th>		<td><?php echo $result->effect; ?></td>	</tr>	<tr valign="top">		<th scope="row">台词</th>		<td><?php echo $result->flavor_text; ?></td>	</tr>	<tr valign="top">		<th scope="row">画师</th>		<td><?php echo $result->illustrator; ?></td>	</tr>	<tr valign="top">		<th scope="row">卡图</th>		<td><img src="http://vgproject.colintrinity.com/img/cards/EB01_002.jpg" alt="" /></td>		</tr>		<tr valign="top">		<th scope="row">备注</th>		<td><?php echo $result->remark; ?></td>	</tr></table></div><?php }?>
