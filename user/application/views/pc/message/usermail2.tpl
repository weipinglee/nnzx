{set: $mess=new \nainai\message($userId)}
<div class="user_body">
		<div class="user_b">
            <!-- 中间内容strat -->
			<div class="user_c_list">
                <div class="user_zhxi">
                    <div class="zhxi_tit">
                        <p><a>消息管理</a>><a>系统消息</a></p>
                    </div>
                    <div class="chp_xx">
                        <div class="xx_center">
                            <table class="mail_table" border="0"  cellpadding="" cellspacing="">
                                <tr class="title">
                                    <td width="80px">
                                        <input id="controlAll" type="checkbox" class="check"/>
                                        <span>全选</span>
                                    </td>
                                    <td>
                                        <span class="colab"><a onclick="allCheck()">标记已读</a></span>
                                        |
                                        <span class="colab"><a onclick="allDelete()">批量删除</a></span>
                                    </td>
                                    <td width="150px">
                                        <div style="text-align:center;">
                                        <span class="col50">未读消息</span>
                                        <span id="nm" class="cold6">{$countNeedMessage}个</span>
                                        </div>
                                    </td>
                                </tr>
                                {foreach:items=$messList}
                                <tr>
                                    <td valign="top">
                                        <div class="data">
                                            {set: $year=date('Y-m',strtotime($item['send_time']))}
                                            {set: $day=date('d',strtotime($item['send_time']))}
                                            <p class="data_year">{$year}</p>
                                            <p class="data_day"><b>{$day}</b></p>
                                        </div>
                                    </td>
                                    <td >
                                        <div class="tact">
                                            <input value="{$item['id']}" type="checkbox" name="checkbox" class="check"/>
                                            {set: $time=date('H:i:s',strtotime($item['send_time']))}
                                            <span>{$time}</span>
                                            {if:$item['write_time']!=NULL}
                                            <img src="{views:/images/center/show_mail.png}"/>
                                            {else:}
                                                <img src="{views:/images/center/no_mail.png}">
                                            {/if}
                                            <span class="colab">系统消息</span>
                                            <p class="mail_cont" >{$item['content']}
                                                 <a class="up_jt"><i class="icon-double-angle-up"></i></a>
                                            </p>
                                            {if:$item['write_time']!=NULL}
                                                <a class="colab right-a" onclick="readMess({$item['id']},this)">点击查看详情</a>
                                            {else:}
                                                <a class="cold6 right-a" onclick="readMess({$item['id']},this)">点击查看详情</a>
                                            {/if}
                                        </div>
                                       
                                    </td>
                                    <td><a class="cz-tab" title="删除" onclick="delMess({$item['id']},this)"><i class="icon-trash"></i></a></td>
                                </tr>
                                {/foreach}
                            </table>

                        </div>
                        
                        
                        <div class="page_num">
                           {$pageBar}
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
                $(this).parent().parent().parent().remove();
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
                        $(obj).parent().parent().remove();
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
            }
        })
    }
</script>