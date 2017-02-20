<?php

namespace Library;
use \Library\url;

class PlUpload{

     private $_uploadJsPaht;

     /**
      * 上传文件的大小
      * @var
      */
     private $_fileSize = '2mb';

     /**
      * 上传文件的类型
      * @var array
      */
     private $_fileType = array(
          'img' => '{title : "Image files", extensions : "jpg,gif,png"}', 
          'zip' => '{title : "Zip files", extensions : "zip"}'
     );

     private $_uploadUrl;

     /**
      * 当前支持的上传类型
      * @var string
      */
     private $_nowUploadType = '';

     public $browse_button = 'pickfiles';
     public $imgContainer = 'imgContainer';
     public $uploadfiles = 'uploadfiles';
     public $multi_selection = true;
     public $save = 'imgData';

     public function __construct($uploadUrl, $otherParams=array(),  $size = '2mb', $types = array('img')){
          $this->_uploadJsPaht = url::getBaseUrl() . '/js/plupload/';
          $this->_uploadUrl = $uploadUrl;
          // 设置文件大小
          $this->_fileSize = $size;
          // 设置上传的类型
          foreach ($types as $type) {
               $this->_nowUploadType .= $this->_fileType[$type];
          }

          foreach ($otherParams as $key => $value) {
               $this->{$key} = $value;
          }
     }

     public function show(){
          return <<< EOF
          <script type="text/javascript" src="{$this->_uploadJsPaht}/plupload.full.min.js"></script>
          <script type="text/javascript" src="{$this->_uploadJsPaht}/handler.js"></script>
          <script type="text/javascript">
          var uploader = new plupload.Uploader({
               runtimes : 'html5,flash,silverlight,html4',
               browse_button : '{$this->browse_button}', // you can pass an id...
               container: document.getElementById('{$this->imgContainer}'), // ... or DOM Element itself
               url : "{$this->_uploadUrl}",
               flash_swf_url : '{$this->_uploadJsPaht}/Moxie.swf',
               silverlight_xap_url : '{$this->_uploadJsPaht}/js/Moxie.xap',
               multi_selection: '{$this->multi_selection}',

               filters : {
                    max_file_size : "{$this->_fileSize}",
                    mime_types: [
                         {$this->_nowUploadType}
                    ]
               },

               init: {
                    PostInit: function(up) {
                         document.getElementById('{$this->uploadfiles}').onclick = function() {
                              up.start();
                              return false;
                         };
                    },

                    FilesAdded: function(up, files) {
                         uploadAddFiles(up, files);
                    },

                    UploadProgress: function(up, file) {
                         uploadProgress(up, file);
                    },

                    FileUploaded: function(up, file, serverData){
                         var imgobj = $('#{$this->imgContainer}');
                         uploadSuccess(up, file, serverData, imgobj, '{$this->save}');
                    },

                    Error: function(up, err) {
                         uploadError(up, err);
                    }
               }
          });

          uploader.init();

          </script>
EOF;
     }

}