<input type="hidden" name="attr_url" value="{url:/Managerstore/ajaxGetCategory}"  />
<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<script type="text/javascript" src="{views:js/product/attr.js}" ></script>
<script type="text/javascript" src="{views:js/product/storeproduct.js}"></script>

<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
<form action="{url:/ManagerStore/doUpdateStore}" method="post" auto_submit redirect_url="{url:/managerstore/applystoredetail?id=$detail['id']}">

<div class="user_c">
                <div class="user_zhxi">

                    <div class="zhxi_tit">
                        <p><a>仓库管理</a>><a>仓单签发</a></p>
                    </div>
                    <div class="rz_title">
                        <ul class="rz_ul">
                            <li class="rz_start"></li>
                            <li class="rz_li cur"><a class="rz">卖方信息</a></li>
                            <li class="rz_li "><a class="yz">商品信息</a></li>
                            <li class="rz_li"><a class="shjg">入库详细信息</a></li>
                            <li class="rz_end"></li>
                        </ul>

                    </div>
                    <div class="class_jy" id="cate_box" style="display:none;">
                        <span class="jy_title"></span>
                        <ul>
                            <!-- <li value=""   class="a_choose" ><a></a></li>
                    -->
                        </ul>

                        <ul class="infoslider" style="display: none;">
                            <li value=""   class="a_choose"  ><a></a></li>

                        </ul>


                    </div>
                    <div class="re_xx">
                        <div class="user_c" style="border:0px;margin-left:0px;">
                            <div class="user_zhxi">
                                <div class="center_tabl">
                                    <div class="lx_gg">
                                        <table class="table2" cellpadding="0" cellspacing="0" id="userData">
                                            <tr>
                                                <td class="spmx_title" colspan="2">会员信息</td>
                                            </tr>
                                            <tr>
                                                <td>用户名</td>
                                                <td id="username">{$user['username']}</td>
                                            </tr>
                                            <tr>
                                                <td>企业名称</td>
                                                <td id="company_name">{$user['company_name']}</td>
                                            </tr>
                                            <tr>
                                                <td>地区</td>
                                                <td id="area">{$user['area']}</td>
                                            </tr>
                                            <tr>
                                                <td>地址</td>
                                                <td id="address">{$user['address']}</td>
                                            </tr>
                                            <tr>
                                                <td>联系方式</td>
                                                <td id="mobile">{$user['mobile']}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="zhxi_con">
                                        <span><input class="submit next_step"  type="button"  value="下一步"/></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="yz_img">

            <!--start中间内容-->

                        <div class="user_c" style="border:0px;margin-left:0px;">
                <div class="user_zhxi pro_classify">
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>商品类型</b>
                    </div>
                         {if: !empty($categorys)}
                        {foreach: items=$categorys item=$category key=$level}   
                            <div class="class_jy" id="level{$level}">
                                <span class="jy_title">{$category['childname']}：</span>
                                {set:unset($categorys[$level]['childname'])}
                                <ul>

                                    {foreach: items=$category item=$cate}
                                    <li value="{$cate['id']}"  {if: $cate['id']==$cate_sel[$level]} class="a_choose"{/if}  ><a>{$cate['name']}</a></li>
                                    {/foreach}
                                </ul>


                            </div>
                        {/foreach}
                        {/if}

                        <table border="0"  >
                            <input type="hidden" name="user_id" datatype="n" value="{$user['id']}" />
                            <tr>
                               <th colspan="3">基本挂牌信息</th>
                            </tr>
                            <tr>
                            <td nowrap="nowrap"><span></span>商品标题：</td>
                            <td colspan="2"> 
                                <span><input class="text" type="text" datatype="s1-30" errormsg="填写商品标题" name="warename" value="{$detail['product_name']}">
                                    </span>
                                <span></span>
                            </td>
                        </tr>


<!--                                 <td> 
    请选择付款方式:
    <input type ="radio" name ="safe" checked="checked" style="width:auto;height:auto;"> 线上
    <input type ="radio" name ="safe" style="width:auto;height:auto;"> 线下
</td> -->
                            
                            <tr>
                                <td nowrap="nowrap"><span></span>数量：</td>
                                <td> <span>
                                         <input class="text" type="text" datatype="/^\d{1,10}(\.\d{0,5})?$/" errormsg="请正确填写数量" name="quantity" value="{$detail['quantity']}">

                                    </span>
                                    <span></span>
                                      </td>
                               <!--  <td> 
                                   请选择支付保证金比例:
                                   <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">
                                           
                               </td> -->

                                </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>单位：</td>
                                <td>
                                    <span class="unit">{$detail['unit']}</span><input type="hidden" name="unit"  value="{$detail['unit']}"/>
                                </td>
                                <!--  <td>
                                    请选择支付保证金比例:
                                    <input type="button" id="jian" value="-"><input type="text" id="num" value="1"><input type="button" id="add" value="+">

                                </td> -->
                            </tr>

                            {foreach: items=$detail['attribute'] item=$attr}
                                    <tr class="attr">
                                        <td nowrap="nowrap"><span></span>{$detail['attr_name'][$key]}：</td>
                                        <td colspan="2">
                                            <input class="text" type="text" name="attribute[{$key}]" value="{$attr}">
                                        </td>
                                    </tr>
                            {/foreach}
                                 
                            <tr style="display:none" id='productAdd'>
                            <td ></td>
                            <td ></td>
                            </tr>
                            
<!--
                            
                            <tr id="sarea" >
                            <td>产地：</td>
                            <td colspan="2" >
                                <span id="areabox">{area:data=$detail['produce_area']}</span>
                                <span><!-- <a onclick="showArea(0)">返回</a> --></span>
                            </td>
                         
                        </tr>
                               

                            <tr>
                                <td>上传图片：</td>
                                <td colspan="2" >
                                    {include:layout/webuploader.tpl}
                                 </td>
                             </tr>

                         <tr>
                             <th colspan="3"><b>详细信息</b></th>
                        </tr>


                                   <tr>
                                        <td>是否包装：</td>
                                        <td colspan="2">
                                            <select name="package" id="package">
                                                <option value="1" {if: $detail['package'] == 1}selected="selected"{/if}>是</option>
                                                <option value="0" {if: $detail['package'] == 0}selected="selected"{/if}>否</option>
                                            </select>
                                        </td>

                                   </tr>

                                   <tr id="packUnit" {if: $detail['package'] == 0}style="display:none;"{/if}>
                                                 <td>包装单位：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packUnit" value="{$detail['package_unit']}">
                                            </td>
                                            </tr >
                                            <tr id='packNumber' {if: $detail['package'] == 0}style="display:none;"{/if}>
                                            <td>包装数量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packNumber" value="{$detail['package_num']}">
                                            </td>
                                            </tr >
                                            <tr id='packWeight' {if: $detail['package'] == 0}style="display:none;"{/if}>
                                            <td>包装重量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packWeight" value="{$detail['package_weight']}">
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
                                <textarea name="note">{$detail['note']}</textarea>
                            </td>
                        </tr>
                        <input type="hidden" name="token" value="{$token}" />
                        <tr>
                            <td></td>
                            <td colspan="2" class="btn">
                            <input type="hidden" name='cate_id' id="cate_id" value="{$detail['cate_id']}">
                            <input type="hidden" name='product_id' id="cate_id" value="{$detail['product_id']}">
                            <input type="hidden" name='id' id="cate_id" value="{$detail['sid']}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8">
                                <div class="zhxi_con">
                                    <span><input class="submit next_step"  type="button"  value="下一步"/></span>
                                </div>
                            </td>
                        </tr>
                         
                 </table>
                        
                    </div>
                </div>
            </div>
                        

                    </div>

                    <div class="sh_jg">
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
            <!--end左侧导航-->  
            <!--start中间内容-->    
            <div class="user_c" style="border:0px;margin-left:0px;">
                <div class="user_zhxi">
                    <div class="center_tabl">
                    <div class="lx_gg">
                        <b>入库详细信息</b>
                    </div>
                     
                        <table border="0">

                            <tr>
                                <td nowrap="nowrap"><span></span>库位：</td>
                                <td colspan="2"> 
                                    <span>
                                        <input class="text" value="{$detail['store_pos']}" type="text" name="pos" datatype="*1-20" errormsg="库位请填写1-20位字符" />
                                    </span>
                                    <span></span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>仓位：</td>
                                <td colspan="2"> 
                                    <input class="text" name="cang" type="text"  value="{$detail['cang_pos']}">
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>租库价格：</td>
                                <td colspan="2">
                                    <span>
                                      <input name="store_price" class="text" value="{$detail['store_price']}" datatype="money" errormsg="请填写价格" type="text" />

                                    </span>
                                    <span></span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>价格单位：</td>
                                <td colspan="2">
                                    元/ <span>
                                                    <select name="store_unit" >
                                                        <option value="d" {if:$detail['store_unit']=='d'}selected{/if}>天</option>
                                                        <option value="m" {if:$detail['store_unit']=='m'}selected{/if}>月</option>
                                                        <option value="y" {if:$detail['store_unit']=='y'}selected{/if}>年</option>
                                                    </select>

                                                </span>/
                                    <span class="unit"> {$detail['unit']}</span>

                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap"><span></span>入库日期：</td>
                                <td colspan="2"> 
                                    <span>
                                        <input name="inTime"  value="{$detail['in_time']}" datatype="datetime" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" type="text">
                                    </span>
                                    <span></span>
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>租库日期：</td>
                                <td colspan="2">
                                    <span>
                                        <input name="rentTime"  value="{$detail['rent_time']}" datatype="datetime" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" type="text">

                                    </span>
                                    <span></span>
                                     </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>检测机构：</td>
                                <td colspan="2"> 
                                    <input class="text" name="check" type="text"  value="{$detail['check_org']}">
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>质检证书编号：</td>
                                <td colspan="2"> 
                                    <input class="text" name="check_no" type="text"  value="{$detail['check_no']}">
                                </td>
                            </tr>
                              
                            <tr>
                                <td>双方签字入库单：</td>
                                <td>
                                    <div class="zhxi_con">
                                        <span class="input-file">选择文件<input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" ></span>
                                        <input type="hidden" name="imgfile1" value="{$detail['confirm']}" datatype="*" nullmsg="请上传签字入库单" />

                                    </div>
                                   
                                    <img name="file1"  src="{$detail['confirm_thumb']}" />
                                </td>
                            </tr>

                            <tr>
                                <td>质检证书：</td>
                                <td>
                                    <div class="zhxi_con">
                                        <span class="input-file">选择文件<input class="doc" type="file" name="file2" id="file2" onchange="javascript:uploadImg(this);" ></span>
                                        <input type="hidden" name="imgfile2" value="{$detail['quality']}" datatype="*" nullmsg="请上传质检证书" />

                                    </div>
                                   
                                    <img name="file2" src="{$detail['quality_thumb']}"/>
                                </td>
                            </tr>
                            <tr colspan="8">
                                <td>
                                    <div class="zhxi_con">
                                        <span><input class="submit"  type="submit" value="签发"></span>
                                    </div>
                                </td>
                            </tr>

                 </table>
                        
                    </div>
                </div>
            </div><input type="hidden" id="ajaxGetAddress" value="{url:/Ucenter/ajaxGetStoreAddress}">
            
                        
                    </div>

                </div>
            </div>
</form>







       




