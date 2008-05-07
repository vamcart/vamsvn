<?php
	/**
	 * language pack
	 * @author Logan Cai (cailongqun [at] yahoo [dot] com [dot] cn)
	 * @link www.phpletter.com
	 * @since 22/April/2007
	 *
	 */
	define('DATE_TIME_FORMAT', 'd/M/Y H:i:s');
	//Common
	//Menu
	
	
	
	
	define('MENU_SELECT', 'Выбрать');
	define('MENU_DOWNLOAD', 'Скачать');
	define('MENU_PREVIEW', 'Предпросмотр');
	define('MENU_RENAME', 'Переименовать');
	define('MENU_EDIT', 'Редактировать');
	define('MENU_CUT', 'Вырезать');
	define('MENU_COPY', 'Копировать');
	define('MENU_DELETE', 'Удалить');
	define('MENU_PLAY', 'Смотреть');
	define('MENU_PASTE', 'Вставить');
	
	//Label
		//Top Action
		define('LBL_ACTION_REFRESH', 'Обновить');
		define('LBL_ACTION_DELETE', 'Удалить');
		define('LBL_ACTION_CUT', 'Вырезать');
		define('LBL_ACTION_COPY', 'Копировать');
		define('LBL_ACTION_PASTE', 'Вставить');
		define('LBL_ACTION_CLOSE', 'Закрыть');
		define('LBL_ACTION_SELECT_ALL', 'Выделить все');
		//File Listing
	define('LBL_NAME', 'Имя');
	define('LBL_SIZE', 'Размер');
	define('LBL_MODIFIED', 'Изменён');
		//File Information
	define('LBL_FILE_INFO', 'Информация о файле:');
	define('LBL_FILE_NAME', 'Имя:');	
	define('LBL_FILE_CREATED', 'Создан:');
	define('LBL_FILE_MODIFIED', 'Изменён:');
	define('LBL_FILE_SIZE', 'Размер файла:');
	define('LBL_FILE_TYPE', 'Тип файла:');
	define('LBL_FILE_WRITABLE', 'Запись:');
	define('LBL_FILE_READABLE', 'Чтение:');
		//Folder Information
	define('LBL_FOLDER_INFO', 'Информация о папке');
	define('LBL_FOLDER_PATH', 'Папка:');
	define('LBL_CURRENT_FOLDER_PATH', 'Текущая папка:');
	define('LBL_FOLDER_CREATED', 'Создана:');
	define('LBL_FOLDER_MODIFIED', 'Изменена:');
	define('LBL_FOLDER_SUDDIR', 'Поддиректории:');
	define('LBL_FOLDER_FIELS', 'Файлы:');
	define('LBL_FOLDER_WRITABLE', 'Запись:');
	define('LBL_FOLDER_READABLE', 'Чтение:');
	define('LBL_FOLDER_ROOT', 'Корень');
		//Preview
	define('LBL_PREVIEW', 'Предварительный просмотр');
	define('LBL_CLICK_PREVIEW', 'Нажмите для предварительного просмотра.');
	//Buttons
	define('LBL_BTN_SELECT', 'Выбрать');
	define('LBL_BTN_CANCEL', 'Отменить');
	define('LBL_BTN_UPLOAD', 'Загрузить');
	define('LBL_BTN_CREATE', 'Создать');
	define('LBL_BTN_CLOSE', 'Закрыть');
	define('LBL_BTN_NEW_FOLDER', 'Новая папка');
	define('LBL_BTN_NEW_FILE', 'Новый файл');
	define('LBL_BTN_EDIT_IMAGE', 'Изменить');
	define('LBL_BTN_VIEW', 'Вид');
	define('LBL_BTN_VIEW_TEXT', 'Текст');
	define('LBL_BTN_VIEW_DETAILS', 'Детали');
	define('LBL_BTN_VIEW_THUMBNAIL', 'Картинки');
	define('LBL_BTN_VIEW_OPTIONS', 'Смотреть:');
	//pagination
	define('PAGINATION_NEXT', 'Вперёд');
	define('PAGINATION_PREVIOUS', 'Назад');
	define('PAGINATION_LAST', 'Последняя');
	define('PAGINATION_FIRST', 'Первая');
	define('PAGINATION_ITEMS_PER_PAGE', 'Показано %s элементов на странице');
	define('PAGINATION_GO_PARENT', 'Перейти в корневую папку');
	//System
	define('SYS_DISABLED', 'Доступ запрещён.');
	
	//Cut
	define('ERR_NOT_DOC_SELECTED_FOR_CUT', 'Не выбраны элементы для вырезания.');
	//Copy
	define('ERR_NOT_DOC_SELECTED_FOR_COPY', 'Не выбраны элементы для копирования.');
	//Paste
	define('ERR_NOT_DOC_SELECTED_FOR_PASTE', 'Не выбраны элементы для вставки.');
	define('WARNING_CUT_PASTE', 'Вы действительно хотите переместить выбранные элементы в текущую папку?');
	define('WARNING_COPY_PASTE', 'Вы действительно хотите скопировать выбранные элементы в текущую папку?');
	define('ERR_NOT_DEST_FOLDER_SPECIFIED', 'Не указана папка.');
	define('ERR_DEST_FOLDER_NOT_FOUND', 'Папка не существует.');
	define('ERR_DEST_FOLDER_NOT_ALLOWED', 'Нет доступа для перемещения файлов в данную папку.');
	define('ERR_UNABLE_TO_MOVE_TO_SAME_DEST', 'Не могу переместить файл (%s): Оригинальный путь идентичен указанной папке для перемещения.');
	define('ERR_UNABLE_TO_MOVE_NOT_FOUND', 'Не могу переместить файл (%s): Файл не найден.');
	define('ERR_UNABLE_TO_MOVE_NOT_ALLOWED', 'Не могу переместить файл (%s): Нет доступа к файлу.');
 
	define('ERR_NOT_FILES_PASTED', 'Ни одного файла не было вставлено.');

	//Search
	define('LBL_SEARCH', 'Поиск');
	define('LBL_SEARCH_NAME', 'Название файла:');
	define('LBL_SEARCH_FOLDER', 'Искать в:');
	define('LBL_SEARCH_QUICK', 'Быстрый поиск');
	define('LBL_SEARCH_MTIME', 'Дата изменения:');
	define('LBL_SEARCH_SIZE', 'Размер файла:');
	define('LBL_SEARCH_ADV_OPTIONS', 'Расширенные опции');
	define('LBL_SEARCH_FILE_TYPES', 'Тип файла:');
	define('SEARCH_TYPE_EXE', 'Приложение');
	
	define('SEARCH_TYPE_IMG', 'Картинка');
	define('SEARCH_TYPE_ARCHIVE', 'Архив');
	define('SEARCH_TYPE_HTML', 'HTML файл');
	define('SEARCH_TYPE_VIDEO', 'Видео');
	define('SEARCH_TYPE_MOVIE', 'Фильм');
	define('SEARCH_TYPE_MUSIC', 'Музыка');
	define('SEARCH_TYPE_FLASH', 'Анимация');
	define('SEARCH_TYPE_PPT', 'Презентация');
	define('SEARCH_TYPE_DOC', 'Документ');
	define('SEARCH_TYPE_WORD', 'Word');
	define('SEARCH_TYPE_PDF', 'PDF');
	define('SEARCH_TYPE_EXCEL', 'Excel');
	define('SEARCH_TYPE_TEXT', 'Текст');
	define('SEARCH_TYPE_UNKNOWN', 'Неизвестно');
	define('SEARCH_TYPE_XML', 'XML файл');
	define('SEARCH_ALL_FILE_TYPES', 'Все типы');
	define('LBL_SEARCH_RECURSIVELY', 'Рекурсивный поиск:');
	define('LBL_RECURSIVELY_YES', 'Да');
	define('LBL_RECURSIVELY_NO', 'Нет');
	define('BTN_SEARCH', 'Искать');
	//thickbox
	define('THICKBOX_NEXT', 'Вперёд &gt;');
	define('THICKBOX_PREVIOUS', '&lt; Назад');
	define('THICKBOX_CLOSE', 'Закрыть');
	//Calendar
	define('CALENDAR_CLOSE', 'Закрыть');
	define('CALENDAR_CLEAR', 'Очистить');
	define('CALENDAR_PREVIOUS', '&lt; Назад');
	define('CALENDAR_NEXT', 'Вперёд &gt;');
	define('CALENDAR_CURRENT', 'Сегодня');
	define('CALENDAR_MON', 'Пн');
	define('CALENDAR_TUE', 'Вт');
	define('CALENDAR_WED', 'Ср');
	define('CALENDAR_THU', 'Чт');
	define('CALENDAR_FRI', 'Пт');
	define('CALENDAR_SAT', 'Сб');
	define('CALENDAR_SUN', 'Вс');
	define('CALENDAR_JAN', 'Янв');
	define('CALENDAR_FEB', 'Фев');
	define('CALENDAR_MAR', 'Мар');
	define('CALENDAR_APR', 'Апр');
	define('CALENDAR_MAY', 'Май');
	define('CALENDAR_JUN', 'Июнь');
	define('CALENDAR_JUL', 'Июль');
	define('CALENDAR_AUG', 'Авг');
	define('CALENDAR_SEP', 'Сен');
	define('CALENDAR_OCT', 'Окт');
	define('CALENDAR_NOV', 'Ноя');
	define('CALENDAR_DEC', 'Дек');
	//ERROR MESSAGES
		//deletion
	define('ERR_NOT_FILE_SELECTED', 'Выберите файл.');
	define('ERR_NOT_DOC_SELECTED', 'Не выбраны элементы для удаления.');
	define('ERR_DELTED_FAILED', 'Не могу удалить выбранные элементы.');
	define('ERR_FOLDER_PATH_NOT_ALLOWED', 'Указанный путь не разрешён.');
		//class manager
	define('ERR_FOLDER_NOT_FOUND', 'Не могу найти указанную папку: ');
		//rename
	define('ERR_RENAME_FORMAT', 'Пожалуйста, указывается названия, содержащие только буквы, цифры, пробелы, дефисы и подчёркивания.');
	define('ERR_RENAME_EXISTS', 'Пожалуйста, указывайте уникальные, не повторяющиеся названия в данной папке.');
	define('ERR_RENAME_FILE_NOT_EXISTS', 'Файл/папка не найдены.');
	define('ERR_RENAME_FAILED', 'Не могу переименовать, попробуйте снова.');
	define('ERR_RENAME_EMPTY', 'Укажите имя.');
	define('ERR_NO_CHANGES_MADE', 'Изменения не были внесены.');
	define('ERR_RENAME_FILE_TYPE_NOT_PERMITED', 'У Вас нет доступа для выполнения данной операции.');
		//folder creation
	define('ERR_FOLDER_FORMAT', 'Пожалуйста, указывается названия, содержащие только буквы, цифры, пробелы, дефисы и подчёркивания.');
	define('ERR_FOLDER_EXISTS', 'Пожалуйста, указывайте уникальные, не повторяющиеся названия в данной папке.');
	define('ERR_FOLDER_CREATION_FAILED', 'Не могу создать папку, попробуйте снова.');
	define('ERR_FOLDER_NAME_EMPTY', 'Укажите имя.');
	define('FOLDER_FORM_TITLE', 'Новая папка');
	define('FOLDER_LBL_TITLE', 'Название папки:');
	define('FOLDER_LBL_CREATE', 'Создать папку');
	//New File
	define('NEW_FILE_FORM_TITLE', 'Новый файл');
	define('NEW_FILE_LBL_TITLE', 'Название файла:');
	define('NEW_FILE_CREATE', 'Создать файл');
		//file upload
	define('ERR_FILE_NAME_FORMAT', 'Пожалуйста, указывается названия, содержащие только буквы, цифры, пробелы, дефисы и подчёрчкивания.');
	define('ERR_FILE_NOT_UPLOADED', 'Не выбран файл для загрузки.');
	define('ERR_FILE_TYPE_NOT_ALLOWED', 'Вы не можете загружать файлы данного типа.');
	define('ERR_FILE_MOVE_FAILED', 'Не могу переместить файл.');
	define('ERR_FILE_NOT_AVAILABLE', 'Файл недоступен.');
	define('ERROR_FILE_TOO_BID', 'Размер файла слишком большой. (максимум: %s)');
	define('FILE_FORM_TITLE', 'Загрузка файла');
	define('FILE_LABEL_SELECT', 'Выберите файл');
	define('FILE_LBL_MORE', 'Добавить файл');
	define('FILE_CANCEL_UPLOAD', 'Отменить');
	define('FILE_LBL_UPLOAD', 'Загрузить');
	//file download
	define('ERR_DOWNLOAD_FILE_NOT_FOUND', 'Не выбраны файлы.');
	//Rename
	define('RENAME_FORM_TITLE', 'Переименование');
	define('RENAME_NEW_NAME', 'Новое название');
	define('RENAME_LBL_RENAME', 'Переименовать');

	//Tips
	define('TIP_FOLDER_GO_DOWN', 'Нажмите один раз чтобы перейти в данную папку...');
	define('TIP_DOC_RENAME', 'Нажмите два раза для редактирования...');
	define('TIP_FOLDER_GO_UP', 'Нажмите один раз чтобы подняться на один уровень выше...');
	define('TIP_SELECT_ALL', 'Выделить всё');
	define('TIP_UNSELECT_ALL', 'Убрать выделение');
	//WARNING
	define('WARNING_DELETE', 'Вы действительно хотите удалить выбранные файлы.');
	define('WARNING_IMAGE_EDIT', 'Выберите изображение для редактирования.');
	define('WARNING_NOT_FILE_EDIT', 'Выберите файл для редактирования.');
	define('WARING_WINDOW_CLOSE', 'Вы действительно хотите закрыть окно?');
	//Preview
	define('PREVIEW_NOT_PREVIEW', 'Предварительный просмотр недоступен.');
	define('PREVIEW_OPEN_FAILED', 'Не могу открыть файл.');
	define('PREVIEW_IMAGE_LOAD_FAILED', 'Не могу загрузить изображение');

	//Login
	define('LOGIN_PAGE_TITLE', 'Вход');
	define('LOGIN_FORM_TITLE', 'Вход');
	define('LOGIN_USERNAME', 'Логин:');
	define('LOGIN_PASSWORD', 'Пароль:');
	define('LOGIN_FAILED', 'Неверный логин и/или пароль.');
	
	
	//88888888888   Below for Image Editor   888888888888888888888
		//Warning 
		define('IMG_WARNING_NO_CHANGE_BEFORE_SAVE', 'Вы не сделали никаких изменений.');
		
		//General
		define('IMG_GEN_IMG_NOT_EXISTS', 'Картинка не найдена');
		define('IMG_WARNING_LOST_CHANAGES', 'Все изменения, которые не были сохранены, будут утеряны, продолжить?');
		define('IMG_WARNING_REST', 'Все изменения, которые не были сохранены, будут утеряны, продолжить?');
		define('IMG_WARNING_EMPTY_RESET', 'Никаких изменений не производилось');
		define('IMG_WARING_WIN_CLOSE', 'Вы действительно хотите закрыть окно?');
		define('IMG_WARNING_UNDO', 'Вы действительно хотите восстановить картинку?');
		define('IMG_WARING_FLIP_H', 'Вы действительно хотите отразить по горизонтали?');
		define('IMG_WARING_FLIP_V', 'Вы действительно хотите отразить по вертикали?');
		define('IMG_INFO', 'Информация');
		
		//Mode
			define('IMG_MODE_RESIZE', 'Масштабировать:');
			define('IMG_MODE_CROP', 'Порезать:');
			define('IMG_MODE_ROTATE', 'Повернуть:');
			define('IMG_MODE_FLIP', 'Отразить:');		
		//Button
		
			define('IMG_BTN_ROTATE_LEFT', '90&deg; против часовой');
			define('IMG_BTN_ROTATE_RIGHT', '90&deg; по часовой');
			define('IMG_BTN_FLIP_H', 'Отразить по горизонтали');
			define('IMG_BTN_FLIP_V', 'Отразить по вертикали');
			define('IMG_BTN_RESET', 'Сбросить');
			define('IMG_BTN_UNDO', 'Назад');
			define('IMG_BTN_SAVE', 'Сохранить');
			define('IMG_BTN_CLOSE', 'Закрыть');
			define('IMG_BTN_SAVE_AS', 'Сохранить как');
			define('IMG_BTN_CANCEL', 'Отменить');
		//Checkbox
			define('IMG_CHECKBOX_CONSTRAINT', 'Ограничить?');
		//Label
			define('IMG_LBL_WIDTH', 'Ширина:');
			define('IMG_LBL_HEIGHT', 'Высота:');
			define('IMG_LBL_X', 'X:');
			define('IMG_LBL_Y', 'Y:');
			define('IMG_LBL_RATIO', 'Пропорция:');
			define('IMG_LBL_ANGLE', 'Угол:');
			define('IMG_LBL_NEW_NAME', 'Новое название:');
			define('IMG_LBL_SAVE_AS', 'Сохранить как');
			define('IMG_LBL_SAVE_TO', 'Сохранить в:');
			define('IMG_LBL_ROOT_FOLDER', 'Корень');
		//Editor
		//Save as 
		define('IMG_NEW_NAME_COMMENTS', 'Пожалуйсте, не указывайте расширение файла.');
		define('IMG_SAVE_AS_ERR_NAME_INVALID', 'Указывайте название, состоящее из букв, цифр, пробелов.');
		define('IMG_SAVE_AS_NOT_FOLDER_SELECTED', 'Не указана папка.');	
		define('IMG_SAVE_AS_FOLDER_NOT_FOUND', 'Указанный путь отсутствует.');
		define('IMG_SAVE_AS_NEW_IMAGE_EXISTS', 'Картинка с таким именем уже существует.');

		//Save
		define('IMG_SAVE_EMPTY_PATH', 'Путь к картинке не указан.');
		define('IMG_SAVE_NOT_EXISTS', 'Картинка не найдена.');
		define('IMG_SAVE_PATH_DISALLOWED', 'У Вас нет доступа к файлу.');
		define('IMG_SAVE_UNKNOWN_MODE', 'Неизвестная операция');
		define('IMG_SAVE_RESIZE_FAILED', 'Невозможно изменить размер картинки.');
		define('IMG_SAVE_CROP_FAILED', 'Невозможно порезать картинку.');
		define('IMG_SAVE_FAILED', 'Невозможно сохранить картинку.');
		define('IMG_SAVE_BACKUP_FAILED', 'Unable to backup the original image.');
		define('IMG_SAVE_ROTATE_FAILED', 'Unable to rotate the image.');
		define('IMG_SAVE_FLIP_FAILED', 'Unable to flip the image.');
		define('IMG_SAVE_SESSION_IMG_OPEN_FAILED', 'Unable to open image from session.');
		define('IMG_SAVE_IMG_OPEN_FAILED', 'Unable to open image');
		
		
		//UNDO
		define('IMG_UNDO_NO_HISTORY_AVAIALBE', 'Нет истории изменений для отката.');
		define('IMG_UNDO_COPY_FAILED', 'Невозможно восстановить картинку.');
		define('IMG_UNDO_DEL_FAILED', 'Невозможно удалить картинку.');
	
	//88888888888   Above for Image Editor   888888888888888888888
	
	//88888888888   Session   888888888888888888888
		define('SESSION_PERSONAL_DIR_NOT_FOUND', 'Не могу найти папку session');
		define('SESSION_COUNTER_FILE_CREATE_FAILED', 'Не могу открыть файл сессии.');
		define('SESSION_COUNTER_FILE_WRITE_FAILED', 'Не могу записать файл сессии.');
	//88888888888   Session   888888888888888888888
	
	//88888888888   Below for Text Editor   888888888888888888888
		define('TXT_FILE_NOT_FOUND', 'Файл не найден.');
		define('TXT_EXT_NOT_SELECTED', 'Выберите расширение файла');
		define('TXT_DEST_FOLDER_NOT_SELECTED', 'Выберите папку');
		define('TXT_UNKNOWN_REQUEST', 'Неизвестный запрос.');
		define('TXT_DISALLOWED_EXT', 'Вы можете добавлять/редактировать следующие типы файлов.');
		define('TXT_FILE_EXIST', 'Файл уже существует.');
		define('TXT_FILE_NOT_EXIST', 'Ничего не найдено.');
		define('TXT_CREATE_FAILED', 'Невозможно создать новый файл.');
		define('TXT_CONTENT_WRITE_FAILED', 'Не могу записать информацию в файл.');
		define('TXT_FILE_OPEN_FAILED', 'Невозможно открыть файл.');
		define('TXT_CONTENT_UPDATE_FAILED', 'Невозможно обновить содержимое файла.');
		define('TXT_SAVE_AS_ERR_NAME_INVALID', 'Пожалуйста, указывайте название, состоящее только из букв, цифр.');
	//88888888888   Above for Text Editor   888888888888888888888
	
	
?>