<?phpif(!class_exists('WP_VG_CURLObject')){	require_once plugin_dir_path(__FILE__).'class-curl-object.php';}class VgRace_CURLObject extends WP_VG_CURLObject {	public static $OptionName = 'vgcardutils_db_table_races_version';	public static $Name = 'plugin_vgcardutils_races';	public static $Prefix = "vgrace";		function __construct(){			}	//Create cards table	public function create(){	//Get the table name with the WP database prefix	global $wpdb;	$table_name = $wpdb->prefix . self::$Name;	global $vgcardutils_db_table_races_version;	$installed_ver = get_option( self::$OptionName );	//Check if the table already exists and if the table is up to date, if not create it	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name	||  $installed_ver != $vgcardutils_db_table_races_version ) {		$sql = "CREATE TABLE " . $table_name . " (  `id` INT(11) NOT NULL AUTO_INCREMENT ,  `title` VARCHAR(255) NOT NULL ,  PRIMARY KEY (`id`)            );";		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');		dbDelta($sql);		update_option( self::$OptionName, $vgcardutils_db_table_races_version );	}	//Add database table versions to options	add_option(self::$OptionName, $vgcardutils_db_table_races_version);}	/**	 * 	 * @return mixed Database query results	 * @param int $current_page	 * @param int $per_page	 */	public function listItem($current_page, $per_page) {		global $wpdb;		$query = "SELECT "		."`Races`.`id` AS `id`, "		."`Races`.`title` "		." FROM `" .$wpdb->prefix . self::$Name. "` AS `Races`"		.'LIMIT '.$per_page		.' OFFSET ' . ($current_page-1) * $per_page;		return $wpdb->get_results($query);	}		public static function listAll() {		global $wpdb;		$query = "SELECT "		."`Races`.`id` AS `id`, "		."`Races`.`title` "		." FROM `" .$wpdb->prefix . self::$Name. "` AS `Races`";		$result = $wpdb->get_results($query);		$count = count($result);		$list = array();		for ($i = 0; $i < $count; $i++) {			$item = $result[$i];			$list[$item->id] = $item->title;		}		return $list;	}		public function counts() {		global $wpdb;		$count = $wpdb->get_row("SELECT count(*) AS `count` FROM `" .$wpdb->prefix . self::$Name. "`");		return $count->count;	}}