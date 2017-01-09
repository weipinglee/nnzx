/**
 * Created by weipinglee on 2016/4/19.
 */

var attr_url = $('input[name=attr_url]').val();

$(document).ready(function(){
    $('#divide').change(function(){
        if ($('#divide').val() == 1) {
            $('.nowrap').show();
        }else{
            $('.nowrap').hide();
        }
    });

    $('#package').change(function(){
        if ($('#package').val() == 1) {
            $('#packUnit').show();
            $('#packNumber').show();
            $('#packWeight').show();
        }else{
            $('#packUnit').hide();
            $('#packNumber').hide();
            $('#packWeight').hide();
        }
    });


    $('input[name=insurance]').on('click', function(){
        if ($(this).val() == 1){
            $('#riskdata').show();
        }else{
            $('#riskdata').hide();
        }
    });

    $('[id^=level]').find('li').on('click',getCategory);

    $('#storeList').change(function(){
        $.ajax({
             'url' :  $('#ajaxGetStoreUrl').val(),
            'type' : 'post',
            'data' : {pid : $('#storeList').val()},
            'dataType': 'json',
            success:function(data){
                $('#pname').html(data.product_name);
                var cate_text = '';
                $.each(data.cate,function(index,val){
                    if(cate_text=='')
                        cate_text = cate_text + val.name;
                    else
                        cate_text = cate_text +'>'+ val.name;
                })
                $('#cname').html(cate_text);
                $('#create_time').html(data.create_time);
                $('#unit').html(data.unit);
                $('#quantity').html(data.quantity);
                $('input[name="quantity"]').val(data.quantity);
                $('#attrs').html(data.attrs);
                $('#id').val(data.sid);
                $('#product_id').val(data.product_id);
                var areaData= getAreaData();
                var p =  areaData[0];
                var q = areaData[1];
                var dis_arr = areaData[2];
                var d = 0;
                var b = 0;
                var l = 0;
                if (data.produce_area != undefined) {
                    d = parseInt(data.produce_area.substring(0,2));
                    if(data.produce_area.length>3) b = parseInt(data.produce_area.substring(0,4));
                    if(data.produce_area.length>5) l = parseInt(data.produce_area.substring(0,6));
                 }
                if(dis_arr[b]!=undefined) {
                    $('#area').html(p[d] + q[d][b] + dis_arr[b][l]);
                }else{
                    $('#area').html(p[d]+q[d][b]);
                }
                var insertHtml = '';
                $.each(data.photos, function(key, value){
                    insertHtml += '<img src="' + value + '" />';
                });
                $('#photos').html(insertHtml);
                
                $('#riskdata').children('td').eq(1).remove();
                if (data.risk_data) {
                    var check_box = '<td><span>';
                    $.each(data.risk_data, function(k, v){
                        check_box += '<input type="checkbox" name="risk[]" value="' +v.risk_id+ '">' + v.name;
                        if (v.mode == 1) {
                            check_box += '比例';
                            check_box += '('+v.fee+'‰)&nbsp;&nbsp;';
                        }else{
                            check_box += '定额';
                            check_box += '('+v.fee+')&nbsp;&nbsp;';
                        }
                    });
                    check_box += '</sapn></td>';
                    $('#riskdata').append(check_box);
                }else{
                    $('#riskdata').append('<td>该分类没有设置保险</td>');
                }
            }
        });
    });

    $('#storeList').trigger('change');

});

//异步获取分类
//cate 默认的cate_id
//data 属性和保险数据
function getCategory(cate,attr){
    var cate_id;
    var click = true;//是否是点击获取
    if(typeof cate == 'object'){
         cate_id = parseInt($(this).attr('value'));
        if ($('#cid').val() == cate_id) {return;}
        $('#cid').val(cate_id);
        var _this = $(this);
        _this.parents('.class_jy').find('li').removeClass('a_choose');
        _this.addClass('a_choose');
    }
    else{
        click = false;
         cate_id = cate;
    }
    var mode = $('#mode').val();

    $.ajax({
        'url' :  attr_url,
        'type' : 'post',
        'data' : {pid : cate_id, 'mode':mode},
        'dataType': 'json',
        success:function(data){//alert(JSON.stringify(data));
            if(click){
                var this_div =  _this.parents('.class_jy');
                this_div.nextAll('.class_jy').remove();
                var pro_add = $('#productAdd');
                $('input[name=cate_id]').val(data.defaultCate);

                  if (mode == 'weitou') {
                            if (data.rate.type == 0) {
                                 $('#weitou').html(data.rate.value + '%');
                            }else if(data.rate.type == 1){
                                $('#weitou').html(data.rate.value + '元');
                            }else{
                                $('#weitou').html(0);
                            }
                           
                        }
                if(data.cate){
                    $.each(data.cate,function(k,v){

                        var box = $('#cate_box').clone();
                        box.attr('id','');
                        if(v.show){
                            $.each(v.show,function(key,value){
                                if (key == 0) {
                                    box.find('.jy_title').text(data.childname+'：');
                                    if(value.childname){
                                        data.childname = value.childname;
                                    }else{
                                        data.childname = '商品分类';
                                    }
                                }

                                if(key==0)
                                    box.find('ul').eq(0).append('<li class="a_choose" value="'+ value.id+'"><a href="javascript:void(0)">'+ value.name+'</a></li>');
                                else
                                    box.find('ul').eq(0).append('<li  value="'+ value.id+'"><a href="javascript:void(0)">'+ value.name+'</a></li>');

                            })
                        }
                        box.css('display','block').insertAfter(this_div);

                        box.find('li').on('click',getCategory);
                        this_div = box;
                    })
                };
            }

            $('.attr').remove();
            if(data.attr){
                var attr_value = '';
                $.each(data.attr,function(k,v){
                    var attr_box = $('#productAdd').clone();
                    attr_box.show();
                    attr_box.addClass('attr');

                    //判断是否有默认的属性值
                    if(typeof attr != 'undefined' && typeof attr[v.id] !='undefined'){
                        attr_value = attr[v.id];
                    }

                    if(v.type==1){
                        attr_box.children('td').eq(0).html(v.name+'：');

                        attr_box.children('td').eq(1).html(' <input class="text" type="text" name="attribute['+ v.id+']" value="'+attr_value+'" />');
                    }
                    else if(v.type==2){//2是单选
                        var radio = v.value.split(',');
                        var radio_text = '';

                        attr_box.children('td').eq(0).html(v.name+'：');

                        $.each(radio,function(i,val){
                            if(val==attr_value){
                                radio_text += '<label style="margin-right:5px;"><input type="radio" checked="true" name="attribute['+ v.id+']" value="'+val+'" />'+val+'</label>' ;
                            }
                            else{
                                radio_text += '<label style="margin-right:5px;"><input type="radio" name="attribute['+ v.id+']" value="'+val+'" />'+val+'</label>' ;
                            }
                            attr_box.children('td').eq(1).html(radio_text);
                        });
                    }
                    else if(v.type==3){
                        attr_box.children('td').eq(0).html(v.name+'：');
                        attr_box.children('td').eq(1).html(' <input name="attribute['+ v.id+']" value="'+attr_value+'" datatype="*" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:\'yyyy-MM-dd\'});" type="text">');

                    }

                    $('#productAdd').after(attr_box);
                });
                bindRules();
            };


            $('#riskdata').children('td').eq(1).remove();
            if (data.risk_data) {
                var check_box = '<td><span>';
                $.each(data.risk_data, function(k, v){
                    check_box += '<input type="checkbox" name="risk[]" value="' +v.risk_id+ '">' + v.name;
                    if (v.mode == 1) {
                        check_box += '比例';
                        check_box += '('+v.fee+'‰)&nbsp;&nbsp;';
                    }else{
                        check_box += '定额';
                        check_box += '('+v.fee+')&nbsp;&nbsp;';
                    }

                });
                check_box += '</sapn></td>';
                $('#riskdata').append(check_box);
            }else{
                $('#riskdata').append('<td>该分类没有设置保险</td>');
            }


        }
    });
}





//验证规则添加

$(function(){
    bindRules();
    minimumRules();
});

function bindRules(){
    //为地址选择框添加验证规则
    var rules = [
        {
            ele:"input[name^=attribute]",
            datatype:"*1-20",
            nullmsg:"请填写信息！",
            errormsg:"请填写信息！"
        }
    ];
    formacc.addRule(rules);
}

//最小起订量的限制规则
function minimumRules(){
    //最小起订量
    formacc.addDatatype('compare',function(gets){
        if($('[class^=nowrap]').css('display')=='none')
            return true;
        if(!gets.match(/^\d+\.?\d*$/i)){
            return false;
        }
        var quantity = parseFloat($('#quantity').text());
        if(!quantity){
            quantity = parseFloat($('input[name=quantity]').val());
        }
        if(!quantity){
            quantity = 0;
        }
        var minstep = parseFloat($('input[name=minstep]').val());
        var max = quantity - minstep;
        gets = parseFloat(gets) ;

        if( gets>max || gets<=0 )
            return false;
       return true;
    });
    //最小递增量
    formacc.addDatatype('minsteprule',function(gets){
        if($('[class^=nowrap]').css('display')=='none')
            return true;
        var quantity = parseFloat($('#quantity').text());
        var max = 0;
        var minimum = 0;
        if(!quantity){
            quantity = parseFloat($('input[name=quantity]').val());
        }
        if(!quantity){
            quantity = 0;
        }
        else{
             minimum = parseFloat($('input[name=minimum]').val());
            if(!minimum)
                minimum = 0;
            max = quantity - minimum;
        }

        if(!gets.match(/^\d+\.?\d*$/i)){
            return false;
        }
        gets = parseFloat(gets) ;

        if(  gets>max || gets<=0)
            return false;
        return true;
    });

    var rules = [{
        ele:"input[name=minimum]",
        datatype:"compare",
        nullmsg:"请输入最小起订量！",
        errormsg:"最小起订量大于0且必须小于等于总量和最小递增量之差！"
    },
        {
            ele:"input[name=minstep]",
            datatype:"minsteprule",
            nullmsg:"请输入最小递增量！",
            errormsg:"最小递增量大于0且必须小于等于总量和最小起订量之差！"
        }
    ];
    formacc.addRule(rules);
}
