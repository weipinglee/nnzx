<?php
/**
 * @copyright Copyright(c) 2011
 * @file swfupload.php
 * @brief swfupload上传组件
 * @author nswe
 * @date 2013/3/18 15:54:25
 */
namespace Library;
use \Library\url;
class Swfupload
{
	//插件路径
	public $path;

	//提交地址
	public $submit;

	//按钮ID
	public $buttonID;

	public $buttonAction=-110;

	public $imgContainer ;

	/**
	 * @brief 构造函数
	 * @param array $params 参数数组
	 *
	 */
	public function __construct($params=array())
	{
		$this->path   = url::getBaseUrl().'/js/swfupload/';
		$this->submit = isset($params['upload_url']) ? url::createUrl($params['upload_url']) : 'ucenter/upload';
		$this->buttonID = isset($params['button_placeholder_id']) ? $params['button_placeholder_id'] : 'uploadButton';

		$this->imgContainer = isset($params['imgContainer']) ? $params['imgContainer'] : 'imgContainer';

	}

	/**
	 * @brief 展示插件
	 */
	public function show()
	{

return <<< OEF
		<script type="text/javascript">
		window.onload = function()
		{
			new SWFUpload({
				// Backend Settings
				upload_url: "{$this->submit}",

				post_params:{},
				// File Upload Settings
				file_types : "*.jpg;*.jpge;*.png;*.gif",

				// Event Handler Settings - these functions as defined in Handlers.js
				//  The handlers are not part of SWFUpload but are part of my website and control how
				//  my website reacts to the SWFUpload events.
				swfupload_preload_handler : preLoad,
				swfupload_load_failed_handler : loadFailed,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				//upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Button Settings
				button_placeholder_id : "{$this->buttonID}",
				button_width: 50,
				button_height: 21,
				button_text : '选择...',
				button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
				button_cursor: SWFUpload.CURSOR.HAND,

				// Flash Settings
				flash_url : "{$this->path}swfupload.swf",

				custom_settings : {
					upload_target : "{$this->imgContainer}"
				},

				// Debug Settings
				debug: false
			});
		};
		</script>
OEF;
	}
}