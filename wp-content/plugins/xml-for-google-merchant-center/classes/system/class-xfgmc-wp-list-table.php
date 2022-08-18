<?php // https://2web-master.ru/wp_list_table-%E2%80%93-poshagovoe-rukovodstvo.html https://wp-kama.ru/function/wp_list_table
class XFGMC_WP_List_Table extends WP_List_Table {
	function __construct() {
		global $status, $page;
		parent::__construct( array(
			'plural'	=> '', 		// По умолчанию: '' ($this->screen->base); Название для множественного числа, используется во всяких заголовках, например в css классах, в заметках, например 'posts', тогда 'posts' будет добавлен в класс table.
			'singular'	=> '', 		// По умолчанию: ''; Название для единственного числа, например 'post'. 
			'ajax'		=> false,	//  По умолчанию: false; Должна ли поддерживать таблица AJAX. Если true, класс будет вызывать метод _js_vars() в подвале, чтобы передать нужные переменные любому скрипту обрабатывающему AJAX события.
			'screen'	=> null, 	//  По умолчанию: null; Строка содержащая название хука, нужного для определения текущей страницы. Если null, то будет установлен текущий экран.
		) );
		add_action('admin_footer', array($this, 'admin_header')); // меняем ширину колонок
	}

	/*	Сейчас у таблицы стандартные стили WordPress. Чтобы это исправить, вам нужно адаптировать классы CSS, которые были 
	*	автоматически применены к каждому столбцу. Название класса состоит из строки «column-» и ключевого имени 
	* 	массива $columns, например «column-isbn» или «column-author».
	*	В качестве примера мы переопределим ширину столбцов (для простоты, стили прописаны непосредственно в HTML разделе head)
	*/
	function admin_header() {
		echo '<style type="text/css">'; 
		echo '#xfgmc_feed_id, .column-xfgmc_feed_id {width: 7%;}';
		echo '</style>';
	}

	/*	Метод get_columns() необходим для маркировки столбцов внизу и вверху таблицы. 
	*	Ключи в массиве должны быть теми же, что и в массиве данных, 
	*	иначе соответствующие столбцы не будут отображены.
	*/
	function get_columns() {
		$columns = array(
			'cb'					=> '<input type="checkbox" />', // флажок сортировки. см get_bulk_actions и column_cb
			'xfgmc_feed_id'			=> __('Feed ID', 'xfgmc'),
			'xfgmc_url_xml_file'	=> __('XML File', 'xfgmc'),
			'xfgmc_run_cron'		=> __('Automatic file creation', 'xfgmc'),
			'xfgmc_step_export'		=> __('Step of export', 'xfgmc'),
		);
		return $columns;
	}
	/*	
	*	Метод вытаскивает из БД данные, которые будут лежать в таблице
	*	$this->table_data();
	*/
	private function table_data() {
		$xfgmc_settings_arr = xfgmc_optionGET('xfgmc_settings_arr');
		$result_arr = array();
		if ($xfgmc_settings_arr == '' || empty($xfgmc_settings_arr)) {return $result_arr;}
		$xfgmc_settings_arr_keys_arr = array_keys($xfgmc_settings_arr);
		for ($i = 0; $i < count($xfgmc_settings_arr_keys_arr); $i++) {
			$key = $xfgmc_settings_arr_keys_arr[$i];

			$text_column_xfgmc_feed_id = $key;

			if ($xfgmc_settings_arr[$key]['xfgmc_file_url'] === '') {
				$text_column_xfgmc_url_xml_file = __('Not created yet', 'xfgmc'); 
			} else {
				$text_column_xfgmc_url_xml_file = '<a target="_blank" href="'.urldecode($xfgmc_settings_arr[$key]['xfgmc_file_url']).'">'.urldecode($xfgmc_settings_arr[$key]['xfgmc_file_url']).'</a>';
			}
			if ($xfgmc_settings_arr[$key]['xfgmc_feed_assignment'] === '') {
			} else {
				$text_column_xfgmc_url_xml_file = $text_column_xfgmc_url_xml_file. '<br/>('. __('Feed assignment', 'xfgmc').': '.$xfgmc_settings_arr[$key]['xfgmc_feed_assignment'].')';
			}

			$xfgmc_status_cron = $xfgmc_settings_arr[$key]['xfgmc_status_cron'];
			switch($xfgmc_status_cron) {
				case 'off': $text_column_xfgmc_run_cron = __("Off", "xfgmc"); break;
				case 'five_min':  $text_column_xfgmc_run_cron = __('Every five minutes', 'xfgmc'); break;
				case 'hourly':  $text_column_xfgmc_run_cron = __('Hourly', 'xfgmc'); break;
				case 'six_hours':  $text_column_xfgmc_run_cron = __('Every six hours', 'xfgmc'); break;
				case 'twicedaily':  $text_column_xfgmc_run_cron = __('Twice a day', 'xfgmc'); break;
				case 'daily':  $text_column_xfgmc_run_cron = __('Daily', 'xfgmc'); break;
				default: $text_column_xfgmc_run_cron = __("Don't start", "xfgmc"); 
			}

			$result_arr[$i] = array(
				'xfgmc_feed_id' => $text_column_xfgmc_feed_id,
				'xfgmc_url_xml_file' => $text_column_xfgmc_url_xml_file,
				'xfgmc_run_cron' => $text_column_xfgmc_run_cron,
				'xfgmc_step_export' => $xfgmc_settings_arr[$key]['xfgmc_step_export']
			);
		}

		return $result_arr;
	}
	/*
	*	prepare_items определяет два массива, управляющие работой таблицы:
	*	$hidden определяет скрытые столбцы https://2web-master.ru/wp_list_table-%E2%80%93-poshagovoe-rukovodstvo.html#screen-options
	*	$sortable определяет, может ли таблица быть отсортирована по этому столбцу.
	*
	*/
	function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns(); // вызов сортировки
		$this->_column_headers = array($columns, $hidden, $sortable);
		// пагинация 
		$per_page = 5;
		$current_page = $this->get_pagenum();
		$total_items = count($this->table_data());
		$found_data = array_slice($this->table_data(), (($current_page - 1) * $per_page), $per_page);
		$this->set_pagination_args(array(
			'total_items' => $total_items, // Мы должны вычислить общее количество элементов
			'per_page'	  => $per_page // Мы должны определить, сколько элементов отображается на странице
		));
		// end пагинация 
		$this->items = $found_data; // $this->items = $this->table_data() // Получаем данные для формирования таблицы
	}
	/*
	* 	Данные таблицы.
	*	Наконец, метод назначает данные из примера на переменную представления данных класса — items.
	*	Прежде чем отобразить каждый столбец, WordPress ищет методы типа column_{key_name}, например, function column_xfgmc_url_xml_file. 
	*	Такой метод должен быть указан для каждого столбца. Но чтобы не создавать эти методы для всех столбцов в отдельности, 
	*	можно использовать column_default. Эта функция обработает все столбцы, для которых не определён специальный метод:
	*/ 
	function column_default($item, $column_name) {
		switch( $column_name ) {
			case 'xfgmc_feed_id':
			case 'xfgmc_url_xml_file':
			case 'xfgmc_run_cron':
			case 'xfgmc_step_export':
				return $item[ $column_name ];
			default:
				return print_r( $item, true ) ; // Мы отображаем целый массив во избежание проблем
		}
	}
	/*
	* 	Функция сортировки.
	*	Второй параметр в массиве значений $sortable_columns отвечает за порядок сортировки столбца. 
	*	Если значение true, столбец будет сортироваться в порядке возрастания, если значение false, столбец сортируется в порядке 
	*	убывания, или не упорядочивается. Это необходимо для маленького треугольника около названия столбца, который указывает порядок
	*	сортировки, чтобы строки отображались в правильном направлении
	*/
	function get_sortable_columns() {
		$sortable_columns = array(
			'xfgmc_url_xml_file'	=> array('xfgmc_url_xml_file', false),
			// 'xfgmc_run_cron'		=> array('xfgmc_run_cron', false)
		);
		return $sortable_columns;
	}
	/*
	* 	Действия.
	*	Эти действия появятся, если пользователь проведет курсор мыши над таблицей
	*	column_{key_name} - в данном случае для колонки xfgmc_url_xml_file - function column_xfgmc_url_xml_file
	*/
	function column_xfgmc_url_xml_file($item) {
		$actions = array(
			'edit'		=> sprintf('<a href="?page=%s&action=%s&feed_id=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['xfgmc_feed_id']),
			'delete'	=> sprintf('<a href="?page=%s&action=%s&feed_id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['xfgmc_feed_id']),
		);

		return sprintf('%1$s %2$s', $item['xfgmc_url_xml_file'], $this->row_actions($actions) );
	}
	/*
	* 	Массовые действия.
	*	Bulk action осуществляются посредством переписывания метода get_bulk_actions() и возврата связанного массива
	*	Этот код просто помещает выпадающее меню и кнопку «применить» вверху и внизу таблицы
	*	ВАЖНО! Чтобы работало нужно оборачивать вызов класса в form:
	*	<form id="events-filter" method="get"> 
	*	<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" /> 
	*	<?php $wp_list_table->display(); ?> 
	*	</form> 
	*/
	function get_bulk_actions() {
		$actions = array(
			'delete'	=> __('Delete', 'xfgmc')
		);
		return $actions;
	}
	// Флажки для строк должны быть определены отдельно. Как упоминалось выше, есть метод column_{column} для отображения столбца. cb-столбец – особый случай:
	function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="checkbox_xml_file[]" value="%s" />', $item['xfgmc_feed_id']
		);
	}
	/*
	* Нет элементов.
	* Если в списке нет никаких элементов, отображается стандартное сообщение «No items found.». Если вы хотите изменить это сообщение, вы можете переписать метод no_items():
	*/
	function no_items() {
		_e('No XML feed found', 'xfgmc');
	}
}
?>