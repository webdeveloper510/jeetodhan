<?php
/**
 * The entry list table
 *
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Competitions_For_Woocommerce_Entry_List_Table extends WP_List_Table {

	public function __construct() {
		global $status, $page, $hook_suffix;

		parent::__construct(
			array(
				'singular' => 'ref',     // singular name of the listed records
				'plural'   => 'refs',    // plural name of the listed records
				'ajax'     => false,      // does this table support ajax?,
				'screen'   => false,
			)
		);
	}
	public function column_default( $item, $column_name ) {
		global $product;
		switch ( $column_name ) {
			case 'userid':
				$userdata = get_userdata( $item[ $column_name ] );
				if ( $userdata ) {
					return esc_attr( $userdata->user_nicename );
				} else {
					return 'User id:' . $item[ $column_name ];
				}
			case 'date':
				$date = date_i18n( get_option( 'date_format' ), strtotime(  $item[ $column_name ] )) . ' ' . date_i18n( get_option( 'time_format' ), strtotime(  $item[ $column_name ] ));
				return apply_filters( 'woocommerce_competition_entry_list_column_date', $date, $item, $column_name );
			case 'answer_id':
				$answers = maybe_unserialize( get_post_meta( $product->get_id(), '_competition_answers', true ) );
				$answer  = isset( $answers[ $item[ $column_name ]] ) ? $answers[ $item[ $column_name ]] : false;
				if ( is_array($answers) ) {
					return esc_html( $answer['text'] );
				} else {
					return '';
				}
			default:
				$value = isset( $item[ $column_name ] ) ? $item[ $column_name ] : false;
				return apply_filters( 'woocommerce_competition_entry_list_column_default', $value, $item, $column_name );

		}
	}

	public function column_title( $item ) {
		// Return the title contents
		return sprintf(
			'%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
			/*$1%s*/ $item['hits'],
			/*$2%s*/ $item['ID'],
			/*$3%s*/ $this->row_actions( $actions )
		);
	}

	public function single_row( $item ) {
		$class = apply_filters( 'woocommerce_competition_entry_list_row_class', '', $item );
		echo '<tr class="' . esc_attr( $class ) . '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	/**
	 * Gets the current page number.
	 *
	 * @since 3.1.0
	 *
	 * @return int
	 */
	public function get_pagenum() {
		$pagenum = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

		if ( isset( $this->_pagination_args['total_pages'] ) && $pagenum > $this->_pagination_args['total_pages'] ) {
			$pagenum = $this->_pagination_args['total_pages'];
		}

		return max( 1, $pagenum );
	}
		/** ************************************************************************
		 * REQUIRED! This method dictates the table's columns and titles. This should
		 * return an array where the key is the column slug (and class) and the value
		 * is the column's title text. If you need a checkbox for bulk actions, refer
		 * to the $columns array below.
		 *
		 * The 'cb' column is treated differently than the rest. If including a checkbox
		 * column in your table you must create a column_cb() method. If you don't need
		 * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
		 *
		 * @see WP_List_Table::::single_row_columns()
		 * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
		 **************************************************************************/
	public function get_columns() {
		global $product;

		$columns = array(
			'date'     => __('Date', 'competitions_for_woocommerce') ,
			'userid'        => __('User', 'competitions_for_woocommerce'),
			'orderid'       => __('Order', 'competitions_for_woocommerce'),
		);
		if ( get_post_meta( $product->get_id(), '_competition_use_pick_numbers', false ) ) {
			$columns['ticket_number'] = __('Ticket number', 'competitions_for_woocommerce');
		}

		if ( competitions_for_woocommerce_use_answers( $product->get_id() ) && 'yes' === get_option('competitions_for_woocommerce_answers_in_history', 'yes')  && ( 'no' === get_option('competitions_for_woocommerce_answers_in_history_finished', 'no') || true === $product->is_closed() ) ) {
			$columns['answer_id'] = __('Answer', 'competitions_for_woocommerce');
		}
		return apply_filters( 'woocommerce_competition_entry_list_columns', $columns );
	}
		/** ************************************************************************
		 * Optional. If you want one or more columns to be sortable (ASC/DESC toggle),
		 * you will need to register it here. This should return an array where the
		 * key is the column that needs to be sortable, and the value is db column to
		 * sort by. Often, the key and value will be the same, but this is not always
		 * the case (as the value is a column name from the database, not the list table).
		 *
		 * This method merely defines which columns should be sortable and makes them
		 * clickable - it does not handle the actual sorting. You still need to detect
		 * the ORDERBY and ORDER querystring variables within prepare_items() and sort
		 * your data accordingly (usually by modifying your query).
		 *
		 * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
		 **************************************************************************/
	public function get_sortable_columns() {
		$sortable_columns = array(

		);
		return apply_filters( 'woocommerce_competition_entry_list_sortable_columns', $sortable_columns );
	}
	protected function handle_row_actions( $item, $column_name, $primary ) {
		return;
	}
		/** ************************************************************************
		 * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
		 * For this example package, we will handle it in the class to keep things
		 * clean and organized.
		 *
		 * @see $this->prepare_items()
		 **************************************************************************/
	public function process_bulk_action() {
		return;
	}
		/** ************************************************************************
		 * REQUIRED! This is where you prepare your data for display. This method will
		 * usually be used to query the database, sort and filter the data, and generally
		 * get it ready to be displayed. At a minimum, we should set $this->items and
		 * $this->set_pagination_args(), although the following properties and methods
		 * are frequently interacted with here...
		 *
		 * @global WPDB $wpdb
		 * @uses $this->_column_headers
		 * @uses $this->items
		 * @uses $this->get_columns()
		 * @uses $this->get_sortable_columns()
		 * @uses $this->get_pagenum()
		 * @uses $this->set_pagination_args()
		 **************************************************************************/
	public function prepare_items() {

		global $wpdb, $_wp_column_headers, $wp, $product;

		$current_url = esc_attr( add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );

		$totalitems = $wpdb->query(
						$wpdb->prepare(
							'SELECT * FROM ' . $wpdb->prefix . 'cfw_log
							LEFT JOIN ' . $wpdb->users . ' ON ' . $wpdb->prefix . 'cfw_log.userid = ' . $wpdb->users . '.id
							LEFT JOIN ' . $wpdb->posts . ' ON ' . $wpdb->prefix . 'cfw_log.competition_id = ' . $wpdb->posts . '.ID
							WHERE ' . $wpdb->prefix . 'cfw_log.competition_id = %d',
							$product->get_id()
							)
						);
		$totalitems = apply_filters( 'woocommerce_competition_entry_list_totalitems', $totalitems, $product );
		$user       = get_current_user_id();
		$screen     = get_current_screen();


		if ( empty( $perpage ) || $perpage < 1 ) {
			$perpage = '10';
		}

		// Which page is this?

		$paged = ( get_query_var('paged') ) ? esc_sql( get_query_var('paged') ) : '';   //

		// Page Number
		if ( empty( $paged ) || ! is_numeric( $paged ) || $paged <= 0 ) {
			$paged = 1; }

		// How many pages do we have in total?
		$totalpages = ceil( $totalitems / $perpage );

		$this->set_pagination_args(
			array(
				'total_items' => $totalitems,
				'total_pages' => $totalpages,
				'per_page'    => $perpage,
			)
		);

		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		if ( ! empty( $paged ) && ! empty( $perpage ) ) {
			$offset = ( $paged - 1 ) * $perpage;
			$this->items           = $wpdb->get_results(
										$wpdb->prepare(
											'SELECT * FROM ' . $wpdb->prefix . 'cfw_log
											LEFT JOIN ' . $wpdb->users . ' ON ' . $wpdb->prefix . 'cfw_log.userid = ' . $wpdb->users . '.id
											LEFT JOIN ' . $wpdb->posts . ' ON ' . $wpdb->prefix . 'cfw_log.competition_id = ' . $wpdb->posts . '.ID
											WHERE ' . $wpdb->prefix . 'cfw_log.competition_id = %d LIMIT %d, %d',
											$product->get_id(),
											$offset,
											$perpage

										)
									, ARRAY_A );
		} else {
			$this->items           = $wpdb->get_results(
										$wpdb->prepare(
											'SELECT * FROM ' . $wpdb->prefix . 'cfw_log
											LEFT JOIN ' . $wpdb->users . ' ON ' . $wpdb->prefix . 'cfw_log.userid = ' . $wpdb->users . '.id
											LEFT JOIN ' . $wpdb->posts . ' ON ' . $wpdb->prefix . 'cfw_log.competition_id = ' . $wpdb->posts . '.ID
											WHERE ' . $wpdb->prefix . 'cfw_log.competition_id = %d',
											$product->get_id()
										)
									, ARRAY_A );
		}

	}

	/**
	 * Displays the table.
	 *
	 * @since 3.1.0
	 */
	public function display() {
		$singular = $this->_args['singular'];


		$this->screen->render_screen_reader_content( 'heading_list' );
		?>
			<table class="wp-list-table <?php echo esc_attr( implode( ' ', $this->get_table_classes() ) ); ?>">
			<thead>
			<tr>
				<?php $this->print_column_headers(); ?>
			</tr>
			</thead>

			<tbody id="the-list"
				<?php
				if ( $singular ) {
					echo wp_kses_post( " data-wp-lists='list:$singular'" );
				}
				?>
				>
				<?php $this->display_rows_or_placeholder(); ?>
			</tbody>

			<tfoot>
			<tr>
				<?php $this->print_column_headers( false ); ?>
			</tr>
			</tfoot>

			</table>
		<?php
		$this->display_tablenav( 'bottom' );
	}

}
