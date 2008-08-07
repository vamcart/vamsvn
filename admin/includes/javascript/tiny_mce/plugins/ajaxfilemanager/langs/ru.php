<?
	/**
	 * language pack
	 * @author Logan Cai (cailongqun@yahoo.com.cn)
	 * @link www.phpletter.com
	 * @since 22/April/2007
	 *
	 */
	define('DATE_TIME_FORMAT', 'd/M/Y H:i:s');
	//Label
		//Top Action
		define('LBL_ACTION_REFRESH', 'Обновить');
		define("LBL_ACTION_DELETE", 'Удалить');
		define('LBL_ACTION_CUT', 'Вырезать');
		define('LBL_ACTION_COPY', 'Копировать');
		define('LBL_ACTION_PASTE', 'Вставить');
		//File Listing
	define('LBL_NAME', 'Имя');
	define('LBL_SIZE', 'Размер');
	define('LBL_MODIFIED', 'Изменён');
		//File Information
	define('LBL_FILE_INFO', 'Информация о файле:');
	define('LBL_FILE_NAME', 'Имя:');	
	define('LBL_FILE_CREATED', 'Создан:');
	define("LBL_FILE_MODIFIED", 'Изменён:');
	define("LBL_FILE_SIZE", 'Размер файла:');
	define('LBL_FILE_TYPE', 'Тип файла:');
	define("LBL_FILE_WRITABLE", 'Запись:');
	define("LBL_FILE_READABLE", 'Чтение:');
		//Folder Information
	define('LBL_FOLDER_INFO', 'Информация о папке');
	define("LBL_FOLDER_PATH", 'Путь:');
	define("LBL_FOLDER_CREATED", 'Создана:');
	define("LBL_FOLDER_MODIFIED", 'Изменена:');
	define('LBL_FOLDER_SUDDIR', 'Поддиректории:');
	define("LBL_FOLDER_FIELS", 'Файлы:');
	define("LBL_FOLDER_WRITABLE", 'Запись:');
	define("LBL_FOLDER_READABLE", 'Чтение:');
		//Preview
	define("LBL_PREVIEW", 'Предварительный просмотр');
	//Buttons
	define('LBL_BTN_SELECT', 'Выбрать');
	define('LBL_BTN_CANCEL', 'Отменить');
	define("LBL_BTN_UPLOAD", 'Загрузить');
	define('LBL_BTN_CREATE', 'Создать');
	define('LBL_BTN_CLOSE', 'Закрыть');
	define("LBL_BTN_NEW_FOLDER", 'Новая папка');
	define('LBL_BTN_EDIT_IMAGE', 'Изменить');
	//Cut
	define('ERR_NOT_DOC_SELECTED_FOR_CUT', 'Не выбраны элементы для вырезания.');
	//Copy
	define('ERR_NOT_DOC_SELECTED_FOR_COPY', 'Не выбраны элементы для копирования.');
	//Paste
	define('ERR_NOT_DOC_SELECTED_FOR_PASTE', 'Не выбраны элементы для вставки.');
	define('WARNING_CUT_PASTE', 'Вы действительно хотите переместить выбранные элементы в текущую папку?');
	define('WARNING_COPY_PASTE', 'Вы действительно хотите скопировать выбранные элементы в текущую папку?');
	
	//ERROR MESSAGES
		//deletion
	define('ERR_NOT_FILE_SELECTED', 'Выберите файл.');
	define('ERR_NOT_DOC_SELECTED', 'Не выбраны элементы для удаления.');
	define('ERR_DELTED_FAILED', 'Не могу удалить выбранные элементы.');
	define('ERR_FOLDER_PATH_NOT_ALLOWED', 'Указанный путь не разрешён.');
		//class manager
	define("ERR_FOLDER_NOT_FOUND", 'Не могу найти указанную папку: ');
		//rename
	define('ERR_RENAME_FORMAT', 'Пожалуйста, указывается названия, содержащие только буквы, цифры, пробелы, дефисы и подчёркивания.');
	define('ERR_RENAME_EXISTS', 'Пожалуйста, указывайте уникальные, не повторяющиеся названия в данной папке.');
	define('ERR_RENAME_FILE_NOT_EXISTS', 'Файл/папка не найдены.');
	define('ERR_RENAME_FAILED', 'Не могу переименовать, попробуйте снова.');
	define('ERR_RENAME_EMPTY', 'Укажите имя.');
	define("ERR_NO_CHANGES_MADE", 'Изменения не были внесены.');
	define('ERR_RENAME_FILE_TYPE_NOT_PERMITED', 'У Вас нет доступа для выполнения данной операции.');
		//folder creation
	define('ERR_FOLDER_FORMAT', 'Пожалуйста, указывается названия, содержащие только буквы, цифры, пробелы, дефисы и подчёркивания.');
	define('ERR_FOLDER_EXISTS', 'Пожалуйста, указывайте уникальные, не повторяющиеся названия в данной папке.');
	define('ERR_FOLDER_CREATION_FAILED', 'Не могу создать папку, попробуйте снова.');
	define('ERR_FOLDER_NAME_EMPTY', 'Укажите имя.');
	
		//file upload
	define("ERR_FILE_NAME_FORMAT", 'Пожалуйста, указывается названия, содержащие только буквы, цифры, пробелы, дефисы и подчёрчкивания.');
	define('ERR_FILE_NOT_UPLOADED', 'Не выбран файл для загрузки.');
	define('ERR_FILE_TYPE_NOT_ALLOWED', 'Вы не можете загружать файлы данного типа.');
	define('ERR_FILE_MOVE_FAILED', 'Не могу переместить файл.');
	define('ERR_FILE_NOT_AVAILABLE', 'Файл недоступен.');
	define('ERROR_FILE_TOO_BID', 'Размер файла слишком большой. (максимум: %s)');
	

	//Tips
	define('TIP_FOLDER_GO_DOWN', 'Нажмите один раз чтобы перейти в данную папку...');
	define("TIP_DOC_RENAME", 'Нажмите два раза для редактирования...');
	define('TIP_FOLDER_GO_UP', 'Нажмите один раз чтобы подняться на один уровень выше...');
	define("TIP_SELECT_ALL", 'Выделить всё');
	define("TIP_UNSELECT_ALL", 'Убрать выделение');
	//WARNING
	define('WARNING_DELETE', 'Вы действительно хотите удалить выбранные файлы.');
	define('WARNING_IMAGE_EDIT', 'Выберите изображение для редактирования.');
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
		define('IMG_WARNING_NO_CHANGE_BEFORE_SAVE', "You have not made any changes to the images.");
		
		//General
		define('IMG_GEN_IMG_NOT_EXISTS', 'Редактор изображений отключён');
		define('IMG_WARNING_LOST_CHANAGES', 'All unsaved changes made to the image will lost, are you sure you wish to continue?');
		define('IMG_WARNING_REST', 'All unsaved changes made to the image will be lost, are you sure to reset?');
		define('IMG_WARNING_EMPTY_RESET', 'No changes has been made to the image so far');
		define('IMG_WARING_WIN_CLOSE', 'Are you sure to close the window?');
		define('IMG_WARNING_UNDO', 'Are you sure to restore the image to previous state?');
		define('IMG_WARING_FLIP_H', 'Are you sure to flip the image horizotally?');
		define('IMG_WARING_FLIP_V', 'Are you sure to flip the image vertically');
		define('IMG_INFO', 'Image Information');
		
		//Mode
			define('IMG_MODE_RESIZE', 'Resize:');
			define('IMG_MODE_CROP', 'Crop:');
			define('IMG_MODE_ROTATE', 'Rotate:');
			define('IMG_MODE_FLIP', 'Flip:');		
		//Button
		
			define('IMG_BTN_ROTATE_LEFT', '90&deg;CCW');
			define('IMG_BTN_ROTATE_RIGHT', '90&deg;CW');
			define('IMG_BTN_FLIP_H', 'Flip Horizontal');
			define('IMG_BTN_FLIP_V', 'Flip Vertical');
			define('IMG_BTN_RESET', 'Reset');
			define('IMG_BTN_UNDO', 'Undo');
			define('IMG_BTN_SAVE', 'Save');
			define('IMG_BTN_CLOSE', 'Close');
		//Checkbox
			define('IMG_CHECKBOX_CONSTRAINT', 'Constraint?');
		//Label
			define('IMG_LBL_WIDTH', 'Width:');
			define('IMG_LBL_HEIGHT', 'Height:');
			define('IMG_LBL_X', 'X:');
			define('IMG_LBL_Y', 'Y:');
			define('IMG_LBL_RATIO', 'Ratio:');
			define('IMG_LBL_ANGLE', 'Angle:');
		//Editor

			
		//Save
		define('IMG_SAVE_EMPTY_PATH', 'Empty image path.');
		define('IMG_SAVE_NOT_EXISTS', 'Image does not exist.');
		define('IMG_SAVE_PATH_DISALLOWED', 'You are not allowed to access this file.');
		define('IMG_SAVE_UNKNOWN_MODE', 'Unexpected Image Operation Mode');
		define('IMG_SAVE_RESIZE_FAILED', 'Failed to resize the image.');
		define('IMG_SAVE_CROP_FAILED', 'Failed to crop the image.');
		define('IMG_SAVE_FAILED', 'Failed to save the image.');
		define('IMG_SAVE_BACKUP_FAILED', 'Unable to backup the original image.');
		define('IMG_SAVE_ROTATE_FAILED', 'Unable to rotate the image.');
		define('IMG_SAVE_FLIP_FAILED', 'Unable to flip the image.');
		define('IMG_SAVE_SESSION_IMG_OPEN_FAILED', 'Unable to open image from session.');
		define('IMG_SAVE_IMG_OPEN_FAILED', 'Unable to open image');
		
		//UNDO
		define('IMG_UNDO_NO_HISTORY_AVAIALBE', 'No history avaiable for undo.');
		define('IMG_UNDO_COPY_FAILED', 'Unable to restore the image.');
		define('IMG_UNDO_DEL_FAILED', 'Unable to delete the session image');
	
	//88888888888   Above for Image Editor   888888888888888888888
	
	//88888888888   Session   888888888888888888888
		define("SESSION_PERSONAL_DIR_NOT_FOUND", 'Не могу найти папку session');
		define("SESSION_COUNTER_FILE_CREATE_FAILED", 'Не могу открыть файл сессии.');
		define('SESSION_COUNTER_FILE_WRITE_FAILED', 'Не могу записать файл сессии.');
	//88888888888   Session   888888888888888888888
	
	
?>