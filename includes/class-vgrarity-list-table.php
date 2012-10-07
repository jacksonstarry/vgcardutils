<?phpif(!class_exists('WP_List_Table')){	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );}if(!class_exists('VgRarity_CURLObject')){	require_once plugin_dir_path(__FILE__).'../curl/class-vgrarity-curl-object.php';}class VgRarities_List_Table extends WP_List_Table {	/**	 *	 * @var VgRarity_CURLObject	 */	var $_model;		function __construct(){		global $status, $page;		$this->_model = new VgRarity_CURLObject();		//Set parent defaults		parent::__construct( array(            'singular'  => 'rarity',     //singular name of the listed records            'plural'    => 'rarities',    //plural name of the listed records            'ajax'      => false        //does this table support ajax?		) );	}	function column_default($item, $column_name){		switch($column_name){			default:				return print_r($item,true); //Show the whole array for troubleshooting purposes		}	}		function column_title($item){		//Return the title contents		return sprintf('<a href="?page=%1$s&exid=%2$s"> %3$s</a>',		/*$1%s*/ $_REQUEST['rarity-paged'],		/*$2%s*/ $item->id,		/*$3%s*/ $item->title		);	}	//	function column_serial($item){////		//Build row actions//		$actions = array(//            'edit'      => sprintf('<a href="?page=%s&action=%s&card=%s">'.__('Edit').'</a>',$_REQUEST['page'],'edit',$item->id),//            'delete'    => sprintf('<a href="?page=%s&action=%s&card=%s">'.__('Delete').'</a>',$_REQUEST['page'],'delete',$item->id),//		);////		//Return the title contents//		return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',//		/*$1%s*/ $item->serial,//		/*$2%s*/ $item->id,//		/*$3%s*/ $this->row_actions($actions)//		);//	}	function column_cb($item){		return sprintf(            '<input type="checkbox" name="%1$s[]" value="%2$s" />',		/*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")		/*$2%s*/ $item->id                //The value of the checkbox should be the record's id		);	}	function get_columns(){		$columns = array(            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text			'title'		=> __('Title'),            );            return $columns;	}	function get_sortable_columns() {		$sortable_columns = array(            'title'     => array('title',true),     //true means its already sorted		);		return $sortable_columns;	}		function get_bulk_actions() {		$actions = array(            'delete'    => __('Delete')            );            return $actions;	}	function process_bulk_action() {		if( 'delete'===$this->current_action() ) {			wp_die('Items deleted (or they would be if we had items to delete)!');		}	}		/**	 * Get the current page number	 *	 * @since 3.1.0	 * @access protected	 *	 * @return int	 */	function get_pagenum() {		$pagenum = isset( $_REQUEST['rarity-paged'] ) ? absint( $_REQUEST['rarity-paged'] ) : 0;			if( isset( $this->_pagination_args['total_pages'] ) && $pagenum > $this->_pagination_args['total_pages'] )			$pagenum = $this->_pagination_args['total_pages'];			return max( 1, $pagenum );	}		/**	 * An internal method that sets all the necessary pagination arguments	 *	 * @param array $args An associative array with information about the pagination	 * @access protected	 */	function set_pagination_args( $args ) {		$args = wp_parse_args( $args, array(				'total_items' => 0,				'total_pages' => 0,				'per_page' => 0,		) );			if ( !$args['total_pages'] && $args['per_page'] > 0 )			$args['total_pages'] = ceil( $args['total_items'] / $args['per_page'] );			// redirect if page number is invalid and headers are not already sent		if ( ! headers_sent() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && $args['total_pages'] > 0 && $this->get_pagenum() > $args['total_pages'] ) {			wp_redirect( add_query_arg( 'rarity-paged', $args['total_pages'] ) );			exit;		}			$this->_pagination_args = $args;	}		/**	 * Access the pagination args	 *	 * @since 3.1.0	 * @access public	 *	 * @param string $key	 * @return array	 */	function get_pagination_arg( $key ) {		if ( 'rarity-page' == $key )			return $this->get_pagenum();			if ( isset( $this->_pagination_args[$key] ) )			return $this->_pagination_args[$key];	}		/**	 * Display the pagination.	 *	 * @since 3.1.0	 * @access protected	 */	function pagination( $which ) {		if ( empty( $this->_pagination_args ) )			return;			extract( $this->_pagination_args, EXTR_SKIP );			$output = '<span class="displaying-num">' . sprintf( _n( '1 item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';			$current = $this->get_pagenum();			$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];			$current_url = remove_query_arg( array( 'hotkeys_highlight_last', 'hotkeys_highlight_first' ), $current_url );			$page_links = array();			$disable_first = $disable_last = '';		if ( $current == 1 )			$disable_first = ' disabled';		if ( $current == $total_pages )			$disable_last = ' disabled';			$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",				'first-page' . $disable_first,				esc_attr__( 'Go to the first page' ),				esc_url( remove_query_arg( 'rarity-paged', $current_url ) ),				'&laquo;'		);			$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",				'prev-page' . $disable_first,				esc_attr__( 'Go to the previous page' ),				esc_url( add_query_arg( 'rarity-paged', max( 1, $current-1 ), $current_url ) ),				'&lsaquo;'		);			if ( 'bottom' == $which )			$html_current_page = $current;		else			$html_current_page = sprintf( "<input class='current-page' title='%s' type='text' name='paged' value='%s' size='%d' />",					esc_attr__( 'Current page' ),					$current,					strlen( $total_pages )			);			$html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );		$page_links[] = '<span class="paging-input">' . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . '</span>';			$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",				'next-page' . $disable_last,				esc_attr__( 'Go to the next page' ),				esc_url( add_query_arg( 'rarity-paged', min( $total_pages, $current+1 ), $current_url ) ),				'&rsaquo;'		);			$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",				'last-page' . $disable_last,				esc_attr__( 'Go to the last page' ),				esc_url( add_query_arg( 'rarity-paged', $total_pages, $current_url ) ),				'&raquo;'		);			$pagination_links_class = 'pagination-links';		if ( ! empty( $infinite_scroll ) )			$pagination_links_class = ' hide-if-js';		$output .= "\n<span class='$pagination_links_class'>" . join( "\n", $page_links ) . '</span>';			if ( $total_pages )			$page_class = $total_pages < 2 ? ' one-page' : '';		else			$page_class = ' no-pages';			$this->_pagination = "<div class='tablenav-pages{$page_class}'>$output</div>";			echo $this->_pagination;	}	/** ************************************************************************	 * REQUIRED! This is where you prepare your data for display. This method will	 * usually be used to query the database, sort and filter the data, and generally	 * get it ready to be displayed. At a minimum, we should set $this->items and	 * $this->set_pagination_args(), although the following properties and methods	 * are frequently interacted with here...	 *	 * @uses $this->_column_headers	 * @uses $this->items	 * @uses $this->get_columns()	 * @uses $this->get_sortable_columns()	 * @uses $this->get_pagenum()	 * @uses $this->set_pagination_args()	 **************************************************************************/	function prepare_items() {		$per_page = 5;		$columns = $this->get_columns();		$hidden = array();		$sortable = $this->get_sortable_columns();		$this->_column_headers = array($columns, $hidden, $sortable);		$current_page = $this->get_pagenum();		$total_items = $this->_model->counts();		$this->items = $this->_model->listItem($current_page, $per_page);				$this->set_pagination_args( array(            'total_items' => $total_items,                  //WE have to calculate the total number of items            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages		) );	}		function description() {		?>        <div style="background:#eee;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">           <p>这里是稀有度列表的描述文字</p>           <br />        </div>		<?php 	}}?><?phpfunction vg_rarities_list_page() {	$table = new VgRarities_List_Table();	$table->prepare_items();	?><div class="wrap"><div id="icon-users" class="icon32"><br /></div><h2>所有稀有度</h2><?php $table->description()?><form id="movies-filter" method="get"><input type="hidden" name="page"value="<?php echo $_REQUEST['rarity-paged'] ?>" /><?php $table->display() ?></form></div><?php }?>
