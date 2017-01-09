
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
<script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<script type="text/javascript" src="{views:js/cert/cert.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
            <div class="user_c">
                <div class="user_zhxi">

                    <div class="zhxi_tit">
                        <p><a>仓库管理</a>><a>仓单签发</a></p>
                    </div>
                    <div class="rz_title">
                        <ul class="rz_ul">
                            <li class="rz_start"></li>
                            <li class="rz_li cur"><a class="rz">商品信息</a></li>
                            <li class="rz_li"><a class="yz">入库详细信息</a></li>
                            <li class="rz_end"></li>
                        </ul>

                    </div>
                    <div class="re_xx">
                        <input type="hidden" name="attr_url" value="{url:/ManagerDeal/ajaxGetCategory}"  />
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
            <!--start中间内容-->    
            <div class="user_c">
                <div class="user_zhxi pro_classify">
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>商品类型和规格</b>
                    </div>
  {if: !empty($categorys)}
                        {foreach: items=$categorys item=$category key=$level}   
                            <div class="class_jy" id="level{$level}">
                                <span class="jy_title">市场类型：</span>
                                <ul>
                                    {foreach: items=$category['show'] item=$cate}
                                    <li value="{$cate['id']}"  {if: $key==0} class="a_choose"{/if}  ><a>{$cate['name']}</a></li>
                                    {/foreach}
                                </ul>


                            </div>
                        {/foreach}
                        {/if}
                  
                    <form action="{url:/ManagerDeal/doStoreProduct}" method="POST" auto_submit redirect_url="{url:/managerdeal/storeproductlist}">
                        <table border="0"  >
                            
                            <tr>
                               <th colspan="3">基本挂牌信息</th>
                            </tr>
                            <tr>
                            <td nowrap="nowrap"><span></span>商品标题：</td>
                            <td colspan="2"> 
                                <span><input class="text" type="text" datatype="s1-30" errormsg="填写商品标题" name="warename">
                                    </span>
                                <span></span>
                            </td>
                        </tr>
  <!--                           <tr>
                                <td nowrap="nowrap"><span></span>商品单价：</td>
                                <td> 
                                    <span><input class="text" type="text" datatype="money" errormsg="请正确填写价格" name="price">
                                    </span>
                                    <span></span>
                                </td> -</tr>->

<!--                                 <td> 
    请选择付款方式:
    <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;"> 线上
    <input type ="radio" name ="safe" style="width:auto;height:auto;"> 线下
</td> -->
                            
                            <tr>
                                <td nowrap="nowrap"><span></span>数量：</td>
                                <td> <span>
                                         <input class="text" type="text" datatype="/^\d{1,10}(\.\d{0,5})?$/" errormsg="请正确填写数量" name="quantity">

                                    </span>
                                    <span></span>
                                      </td>
                               <!--  <td> 
                                   请选择支付保证金比例:
                                   <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">
                                           
                               </td> -->

                                <tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>单位：</td>
                                <td>
                                    <span class="unit">{$unit}</span><input type="hidden" name="unit" value="{$unit}"/>
                                </td>
                                <!--  <td>
                                    请选择支付保证金比例:
                                    <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">

                                </td> -->
                            </tr>
{foreach: items=$attrs item=$attr}
                                    <tr class="attr">
                                        <td nowrap="nowrap"><span></span>{$attr['name']}：</td>
                                        <td colspan="2">
                                            <input class="text" type="text" name="attribute[{$attr['id']}]" >
                                        </td>
                                    </tr>
                            {/foreach}
                                 
                            <tr style="display:none" id='productAdd'>
                            <td ></td>
                            <td ></td>
                            </tr>
                            
                            <tr>
                            <td>产地：</td>
                            <td colspan="2" >
                                <span id="areabox">{area:data=getAreaData()}</span>
                                <span></span>
                            </td>
                         
                        </tr>
                            
                               

                            <tr>
                                <td>上传图片：</td>
                                <td>
                                   {include:layout/webuploader.tpl}
                                 </td>
                             </tr>
                         <tr>
                             <th colspan="3"><b>详细信息</b></th>
                        </tr>


                                 </tr>
                                    <tr>
                                        <td><span>*</span>选择仓库：</td>
                                        <td>
                                           <span>
                                               <select name="store_id" id="store_id" datatype="/[1-9]\d{0,10}/">
                                                   <option value="0" >请选择</option>
                                                   {foreach: items=$storeList item=$list}
                                                       <option value="{$list['id']}" >{$list['name']}</option>
                                                   {/foreach}
                                               </select>
                                           </span>
                                            <span></span>
                                        </td>
                                        </tr>
                                        <tr id="address">
                                            <td >仓库地址：
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                   <tr>
                                        <td>是否包装：</td>
                                        <td colspan="2">
                                            <select name="package" id="package">
                                                <option value="1" selected="selected">是</option>
                                                <option value="0">否</option>
                                            </select>
                                        </td>

                                             </tr>

                                            <tr id="packUnit" >
                                                 <td>包装单位：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packUnit">
                                            </td>
                                            </tr>
                                            <tr id='packNumber'>
                                            <td>包装数量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packNumber">
                                            </td>
                                            </tr>
                                            <tr id='packWeight'>
                                            <td>包装重量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packWeight">
                                            </td>
                                            </tr>


<!--                               <tr>
                            <td>是否投保：</td>
                            <td colspan="2">
  <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;">投保
      <input type ="radio" name ="safe" style="width:auto;height:auto;"> 不投保
                            </td>
                        </tr> -->
                        <tr>
                            <td>产品描述：</td>
                            <td colspan="2">
                                <textarea name="note"></textarea>
                            </td>
                        </tr>
                        <input type="hidden" name="token" value="{$token}" />
                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" name='cate_id' id="cate_id" value="{$cate_id}">


                                
                            </td>
                        </tr>
                         
                 </table>
                        
                    </div>
                </div>
            </div>
                        
                        <div class="zhxi_con">
                            <span><input class="submit" id="next_step" type="button"  value="下一步"/></span>
                        </div>

                    </div>

                    <div class="yz_img">
                       <script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
            <!--end左侧导航-->  
            <!--start中间内容-->    
            <div class="user_c">
                <div class="user_zhxi">
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>入库详细信息</b>
                    </div>
                     
                        <table border="0">
                            <tr>
                                <td nowrap="nowrap"><span></span>库位：</td>
                                <td colspan="2"> 
                                    <input class="text" type="text" name="pos" datatype="s1-20" errormsg="库位请填写1-20位字符" {if: !empty($storeDetail['store_pos'])} value="{$storeDetail['store_pos']}" readonly="readonly" {/if}>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>仓位：</td>
                                <td colspan="2"> 
                                    <input class="text" name="cang" type="text">
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>租库价格：</td>
                                <td colspan="2">
                                    <input name="store_price" class="text" value=""  type="text" />（/{$storeDetail['unit']}/天）
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>入库日期：</td>
                                <td colspan="2"> 
                                    <input name="inTime" value="{$storeDetail['in_time']}" datatype="date" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'});" type="text">
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>租库日期：</td>
                                <td colspan="2"> 
                                    <input name="rentTime" value="{$storeDetail['rent_time']}" datatype="date" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd H:mm:ss'});" type="text">
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>检测机构：</td>
                                <td colspan="2"> 
                                    <input class="text" name="check" type="text">
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>质检证书编号：</td>
                                <td colspan="2"> 
                                    <input class="text" name="check_no" type="text">
                                </td>
                            </tr>
                              
                            <tr>
                                <td>双方签字入库单：</td>
                                <td>
                                    <div class="zhxi_con">
                                        <span><input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" ></span>
                                        <input type="hidden" name="imgfile1" value="" datatype="*" nullmsg="请上传签字入库单" />

                                    </div>
                                   
                                    <img name="file1" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td>图片预览：</td>
                                <td colspan="2">
                    <span class="zhs_img">
                                    {foreach: items=$storeDetail['photos'] item=$url}
                        <img src="{$url}"/>
                                    {/foreach}
                    </span>
                                </td>              
                            </tr>
                            
                      

                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" value="{$storeDetail['sid']}" name="id" >


                                
                            </td>
                        </tr>
                         
                 </table>
                        
                    </div>
                </div>
            </div><input type="hidden" id="ajaxGetAddress" value="{url:/Ucenter/ajaxGetStoreAddress}">
            
                        <div class="zhxi_con">
                            <span><input class="submit"  type="submit" value="签发"></span>
                        </div>
                    </div>
                </form>
                </div>
            </div>
<script type="text/javascript">
    $(function(){
        nextTab({$certShow['step']});

        $('#store_id').on('change', getStoreArea);

        function getStoreArea(){
            var val = $('select[name=store_id]').val();
            $('#address').children('td').eq(1).html('');
            if (val == 0) {return;}
                $.ajax({
                    'url' :  $('#ajaxGetAddress').val(),
                    'type' : 'post',
                    'data' : {id : val},
                    'dataType': 'json',
                    success:function(data){
                        if (data.id) {
                            var areaObj = new Area();
                            var area_text = areaObj.getAreaText(data.area);
                            $('#address').children('td').eq(1).html(area_text +' '+ data.address);
                        }
                    }
                })
        }
    })
</script>




       




