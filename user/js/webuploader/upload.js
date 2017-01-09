/**
 * Created by Administrator on 2016/7/4 0004.
 */

$(function(){
    var percentages = {};
    var uploadNum = 0;//成功上传的数目
    var uploader = WebUploader.create({
        auto : true,
        // swf文件路径
        swf: $('input[name=swfUrl]').val(),

        // 文件接收服务端。
        server: $('input[name=uploadUrl]').val(),

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });


    //开始上传
    //$('#beginUpload').on('click',function(){
    //    uploader.upload();
    //});

    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
                '<li id="' + file.id + '" class="file-item thumbnail">' +
                    // '<p class="title">' + file.name + '</p>' +
                '<p ><img /></p>' +
                '<p class="progress"><span style="display:block;"></span></p>' +
                '<p class="res"></p>'+
                '</li>'

            ),
            $img = $li.find('img');


        // $list为容器jQuery实例
        $('#filelist').append( $li );
        $li.on('dblclick',function(){
            $(this).remove();
            uploader.removeFile(file.id,true);
        })

        percentages[file.id] = [file.size,0];

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, 100, 100 );
    });


    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {

        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );

        percentages[file.id][1] = percentage;
     //   updateTotalProgress();


    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ,response) {
        $( '#'+file.id).find('.progress').remove();
        if(response && response.flag==1){
            $( '#'+file.id).append('<input type="hidden" name="imgData[]" value="'+response.img+'" />');
            $( '#'+file.id).find('.res').css('display','block').addClass('success');
        }
        else{
            $( '#'+file.id).find('.res').css('display','block').addClass('error').text('上传失败');
        }

    });

    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });

    //更新总的上传进度
    function updateTotalProgress() {
        var loaded = 0,
            total = 0,
            percent;
        var  spans = $('.totalprogress').find('span');
        $('.totalprogress').show();
        $.each( percentages, function( k, v ) {
            total += v[ 0 ];
            loaded += v[ 0 ] * v[ 1 ];
        } );

        percent = total ? loaded / total : 0;
        spans.eq(0).text( Math.round( percent * 100 ) + '%' );
        spans.eq(1).css( 'width', Math.round( percent * 100 ) + '%' );


    }


})
