{set: $mess=new \nainai\message($userId)}
	<div class="user_body">
            <!-- 中间内容strat -->
			<div class="user_c_list news">
                <div class="user_zhxi">
                    <div class="zhxi_tit">
                        <p><a>消息管理</a>><a>系统消息</a></p>
                    </div>
                    <div class="chp_xx">
                        <div class="xx_center">
                            <table class="mail_table" border="0"  cellpadding="" cellspacing="">
                                <tr class="title" >
                                    <td colspan="">
                                        <div class="selck">
                                            <input id="controlAll" name="checkbox" type="checkbox" class="check"/>
                                            <span>全选</span>
                                        </div>
                                        <div class="colab bjdele">
                                            <span class="colab"><a onclick="allCheck()">标记已读</a></span>
                                            |
                                            <span class="colab"><a onclick="allDelete()">批量删除</a></span>
                                        </div>
                                        <div class="noinfor">
                                            <span class="">未读消息:</span>
                                            <span class="cold6" id="nm">{$countNeedMessage}</span>
                                        </div>
                                    </td>
                                </tr>
                                <input type="hidden" name="url" id="messUrl" value="{url:message/readMess}" />
                                {foreach:items=$messList}
                                <tr>
                                    <td>
                                        <div class="clear">
                                            <div class="tact" messID="{$item['id']}">
                                                <input value="{$item['id']}" type="checkbox" name="checkbox" class="check"/>
                                               <a class="right-a" {if:$item['write_time']==null} style="color: red" {/if} href="javascript:void(0)" >{$item['title']}</a>
                                            </div>
                                            <div class="colab data">
                                                {set:$year=date('Y-m-d',strtotime($item['send_time']))}
                                                {set:$day=date('H:i:s',strtotime($item['send_time']))}
                                                <span>{$year}</span>
                                                <span>{$day}</span>
                                            </div>
                                            <a class="colab cz-tab" title="删除" onclick="delMess({$item['id']},this)"><i class="icon-trash"></i></a>
                                        </div>
                                        <div class="jy_deal">
                                            <div class="c-tip-arrow"><em></em><ins></ins></div>
                                            <div class="jx_num">
                                                {$item['title']}
                                            </div>
                                            <div class="jxrong">
                                                {$item['content']}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {/foreach}
                            </table>

                        </div>
                        
                       
                        <div class="page_num clear">
                           <div class="pages_bar">
                               {$pageBar}
                            </div>                        
                        </div>
                        
                    </div>
                </div>

            </div>
        <script text="text/javascript">
            $(function(){
                $('.mail_cont').css('display','none');
                $('[type=checkbox]').prop('checked',false);
                $('#controlAll').click(function(){
                    $("input[name='checkbox']").prop("checked", this.checked);
                    if(!this.checked) {
                        $('.chp_xx').find('input').removeAttr('checked');

                    }else{
                        $('.chp_xx').find('input').attr('checked', 'checked');

                    }
                });

                $('input[name=checkbox]').click(function(){
                    var $subs = $("input[name='checkbox']");
                    $('#controlAll').prop("checked" , $subs.length == $subs.filter(":checked").length ? true :false);
                    check_goods(this);
                });
            });
            function readMess(id,obj){
                $(obj).attr('class','colab right-a');
                $(obj).prevAll('img').attr('src',"{views:/images/center/show_mail.png}");
                var id=id;
                var url="{url:/message/readMess}";
                $.ajax({
                            type:'post',
                            url:url,
                            data:{id:id},
                            dataType:'json',
                            success:function(msg){
                                //alert(1);
                                getNeedMessage();
                            }
                        }
                );
            }
            //批量标记已读
            function allCheck(){
                // alert(1);
                var url="{url:/message/allRead}";
                var ids=new Array();
                $('input[name="checkbox"]:checkbox').each(function() {
                    if($(this).is(':checked')){
                        $(this).nextAll('img').attr('src',"{views:/images/center/show_mail.png}");
                        $(this).nextAll('a').attr('class','colab right-a');
                        ids.push($(this).val());
                    }

                })
                $.ajax({
                    type:'post',
                    url:url,
                    data:{ids:ids.toString()},
                    dataType:'json',
                    success:function(ms){
                        getNeedMessage();
                        layer.msg('修改成功',{time:2000});
                    }
                });
            }
            //批量删除
            function allDelete(){
                var url="{url:/message/batchDel}";
                var ids=new Array();
                $('input[name="checkbox"]:checkbox').each(function() {
                    if($(this).is(':checked')){

                        //$(this).nextAll('a').attr('class','colab right-a');
                        $(this).parent().parent().parent().parent().remove();
                        ids.push($(this).val());
                    }
                })
                $.ajax({
                    type:'post',
                    url:url,
                    data:{ids:ids.toString()},
                    dataType:'json',
                    success:function(ms){
                        getNeedMessage();
                        layer.msg('修改成功',{time:2000});
                    }
                });
            }
            function delMess(id,obj){
                var url="{url:/message/delMessage}";
                var data={id:id};
                layer.confirm('确定要删除吗?',{btn:['确定','取消']},function(){
                    $.ajax({
                        type:'post',
                        url:url,
                        data:data,
                        dataType:'json',
                        success:function(ms){
                            if(ms.success==1){
                                $(obj).parent().parent().parent().remove();
                                layer.msg('删除成功',{time:2000});
                                getNeedMessage();
                            }else{
                                layer.msg('删除失败',{time:2000});
                            }
                        }
                    })
                },function(){})
            }
            function getNeedMessage(){
                $.ajax({
                    type:'post',
                    url:"{url:/message/NeedCountMessage}",
                    success:function(msg){
                        $('#nm').html(msg+'个');
                        $('.information').html(msg);
                    }
                })
            }
        </script>