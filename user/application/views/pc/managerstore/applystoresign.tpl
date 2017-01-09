<script type="text/javascript" src="{root:js/upload/ajaxfileupload.js}"></script>
<script type="text/javascript" src="{root:js/upload/upload.js}"></script>
<input type="hidden" name="uploadUrl"  value="{url:/ucenter/upload}" />
			<!--end左侧导航-->	
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>仓单管理</a>><a>仓单签发</a></p>
					</div>
					<div class="center_tabl">
                    <div class="lx_gg">
                        <b>入库详细信息</b>
                    </div>
                    {set:$storeDetail}
                    <div class="list_names">
                        <span>仓库名称:</span>
                        <span>{$storeDetail['sname']}</span>
                    </div>
                     
                    <form action="{url: /ManagerStore/doStoreSign}" method="POST" auto_submit redirect_url="{url:/managerstore/applystorelist?type=2}">
						<table border="0">
                            <tr>
                                <td nowrap="nowrap"><span></span>状态：</td>
                                <td colspan="2">
                                   {$storeDetail['status_txt']}
                                </td>
                            </tr>
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
                                    <input name="inTime" value="{$storeDetail['in_time']}" datatype="date" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" type="text">
                                </td>
                            </tr>
                             <tr>
                                <td nowrap="nowrap"><span></span>租库日期：</td>
                                <td colspan="2"> 
                                    <input name="rentTime" value="{$storeDetail['rent_time']}" datatype="date" errormsg="请选择日期" class="Wdate addw" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'});" type="text">
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
                               <tr >
                                <td nowrap="nowrap"><span></span>是否包装：</td>
                                <td colspan="2"> 
                                    {if: $storeDetail['package'] == 1} 是 {else:} 否{/if}
                                </td>
                            </tr>
                            <tr >
                                <td nowrap="nowrap"><span></span>总重量：</td>
                                <td colspan="2"> 
                                    <input class="text" type="text" name="quantity" datatype="float" errormsg="请填写小数或整数" value="{$storeDetail['quantity']}">({$storeDetail['unit']})
                                </td>
                            </tr>
                                    {if: $storeDetail['package'] == 1} 
                                            <tr id="packUnit" >
                                                 <td>包装单位：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packUnit" value="{$storeDetail['package_unit']}" readonly="readonly">
                                            </td>
                                            </tr>
                                            <tr id='packNumber'>
                                            <td>包装数量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packNumber" value="{$storeDetail['package_num']}">
                                            </td>
                                            </tr>
                                            <tr id='packWeight' >
                                            <td>包装重量：</td>
                                            <td colspan="2">
                                                <input type="text" class='text' name="packWeight" value="{$storeDetail['package_weight']}">
                                            </td>
                                            </tr>
                                  {/if}
                            <tr>
                                <td>双方签字入库单：</td>
                                <td>
                                    <div class="zhxi_con">
                                        <span class="input-file">选择文件<input class="doc" type="file" name="file1" id="file1" onchange="javascript:uploadImg(this);" ></span>
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

                            <input type="submit" value="签发">
                            <input type="hidden" value="{$storeDetail['sid']}" name="id" >


                                
                            </td>
                        </tr>
                         
                 </table>
            	</form>
						
					</div>
				</div>
			</div>
			