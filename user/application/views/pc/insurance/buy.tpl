
            <!--end左侧导航-->  
            <!--start中间内容-->    
                        <style type="text/css">.center_tabl .table2 {width: 96%;margin: 0 2%;}.user_c{width:948px;}.center_tabl .table2 i{color: #d61515}</style>
            <div class="user_c">
                <div class="user_zhxi">
                    <div class="zhxi_tit">
                        <p><a>投保管理</a>><a>投保缴费详情</a></p>
                    </div>
                    <div class="center_tabl">
                    <form action="{url:/Insurance/buy}" method="POST" auto_submit="1" redirect_url="{url:/contract/sellerdetail?id/$info['id']}">
                       <table class="table2" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td class="spmx_title" colspan="8">商品投保费用缴纳详情</td>
                            </tr>
                            <tr>
                                <td colspan="2">保险产品</td>
                                <td colspan="2">{$risk_data['name']}</td>
                                <td colspan="2">合同单号</td>
                                <td colspan="2">{$info['order_no']}</td>
                            </tr>
                            <tr>
                                <td colspan="2">保险人名称</td>
                                <td colspan="2"><input type="text" name="baoName"><i>*</i></td>
                                <td colspan="2">保险人地址</td>
                                <td colspan="2"><input type="text" name="baoAddress"><i>*</i></td>
                            </tr>
                            <tr>
                                <td colspan="2">保险人联系电话</td>
                                <td colspan="2"><input type="text" name="baoTel"><i>*</i></td>
                                <td colspan="2">保险人Email</td>
                                <td colspan="2"><input type="text" name="baoEmail" placeholder="购买成功后发送电子保单"><i>*</i></td>
                            </tr>
                            <tr>
                                <td colspan="2">保险人证件类型</td>
                                <td colspan="2">
                                <select name="baoidentType">
                                {foreach: items=$identity}
                                <option value="{$key}">{$item}</option>
                                {/foreach}
                                <i>*</i></td>
                                <td colspan="2">保险人证件号</td>
                                <td colspan="2"><input type="text" name="baoidentNO"><i>*</i></td>
                            </tr>
                            <tr>
                                <td colspan="2">被保险人名称</td>
                                <td colspan="2"><input type="text" name="theName"><i>*</i></td>
                                <td colspan="2">被保险人地址</td>
                                <td colspan="2"><input type="text" name="theAddress"><i>*</i></td>
                            </tr>
                            <tr>
                                <td colspan="2">被保险人联系电话</td>
                                <td colspan="2"><input type="text" name="theTel"><i>*</i></td>
                                <td colspan="2">被保险人Email</td>
                                <td colspan="2"><input type="text" name="theEmail" placeholder="购买成功后发送电子保单"><i>*</i></td>
                            </tr>
                            <tr>
                                <td colspan="2">证件类型</td>
                                <td colspan="2">
                                 <select name="theidentType" id="theidentType">
                                {foreach: items=$identity}
                                <option value="{$key}">{$item}</option>
                                {/foreach}
                                </select><i>*</i></td>
                                <td colspan="2">被保人证件号</td>
                                <td colspan="2"><input type="text" name="theidentNo"><i>*</i></td>
                            </tr>
                             <tr>
                                <td colspan="2">与被保人的关系</td>
                                <td colspan="2">
                                <select name="relation">
                                {foreach: items=$relation}
                                <option value="{$key}">{$item}</option>
                                {/foreach}
                                <i>*</i></td>
                                <td colspan="2" class="birthday" style="display:none;">被保险人出生日期</td>
                                <td colspan="2" class="birthday" style="display:none;"><input class="Wdate" type="text" name="birthday"  onclick="WdatePicker()"> <i>*</i></td>
                            </tr>
                             <tr>
                             <td colspan="3">角色：  <select name="role">
                                {foreach: items=$role}
                                <option value="{$key}">{$item}</option>
                                {/foreach}
                                <td colspan="3">投保区域：  <select name="area">
                                {foreach: items=$area}
                                <option value="{$key}">{$item}</option>
                                {/foreach}</td>
                                <td colspan="2">产品类型：{$info['cate_name']}<i>*</i></td>
                            </tr>
                             <tr>
                                <td colspan="3">产品名称：{$info['name']}</td>
                                <td colspan="3">生产日期：{$info['product_time']}</td>
                                <td colspan="2">数量(单位：{$info['unit']})：{$info['num']}</td>
                            </tr>
                            <tr>
                                <td colspan="3">保质期限：1年</td>
                                <td colspan="3">投保日期：<input class="Wdate" type="text" name="baoDate" value="{$beginDate}" onclick="WdatePicker()"> 
                                <i>*</i></td>
                                <td colspan="2">销售额(单位：元)：{$info['amount']}<i>*</i>
                                <input type="hidden" name="fee" value="{$info['amount']}">
                                <input type="hidden" name="code" value="{$risk_data['code']}">
                                <input type="hidden" name="project_code" value="{$risk_data['project_code']}">
                                <input type="hidden" name="limit" value="{$risk_data['limit']}">
                                {if: $risk_data['mode'] == 1}
                                <input type="hidden" name="rate" value="{$risk_data['rate']}">
                                {else:}
                                <input type="hidden" name="rate" value="{$risk_data['fee']}">
                                {/if}
                                
                                </td>
                            </tr>
                            <!-- <tr>
                                <td colspan="3">保费收入账户：139206242598</td>
                                <td colspan="3">开户行：中国银行阳泉市城区支行</td>
                                <td colspan="2">名称：中国人民财产保险股份有限公司阳泉分公司<i>*</i></td>
                            </tr> -->
                            <tr>
                                <td class="spmx_title" colspan="8">备注说明</td>
                            </tr>
                            <tr>
                                <td colspan="8">
<p>特别约定：<br/>
1.“耐耐网”平台在线投保产品责任保险的企业必须是依法注册，并取得工商行政部门、主管部门颁发的营业执照和业务经营（或生产）许可证，其产品须经国家产品质量检测机构检测合格，取得产品质量合格证，准予生产、销售，否则，发生事故后，保险公司不负责赔偿。<br/>
2.通过“耐耐网”交易平台交易的每一笔国内贸易，其卖方企业在本网站在线投保产品责任保险。<br/>
3.“耐耐网”产品责任保险的保险责任及相关事项按照《中国人民财产保险股份有限公司产品责任保险条款(1993版)》（2009年9月18日中国保险监督管理委员会核准备案，编号：人保（备案）[2009]N277号）执行。<br/>
4.通过本网站在线投保的产品责任保险仅承保在本网站在线交易的产品在中华人民共和国境内（港、澳、台除外）所造成的损失赔偿责任，对于非在线交易产品造成的赔偿责任以及在线交易产品在境外造成的相关赔偿责任，本保险不负责赔偿。<br/>
5.产品责任险承保被保险人的产品存在缺陷，造成使用、消费该产品的人或第三者的人身伤害、疾病、死亡或财产损失责任，不承担因产品未达到企业承诺的使用效能而造成的赔偿责任。 <br/>
6.每个企业年度累计责任限额最高不超过3000万元：即从企业首次投保的保单起保日，及后续每年的该日起12个月内”，保险公司总赔偿限额不超过3000万元。
  年度保单累计责任限额不足3000万元的，以实际累计责任限额为准。<br/>
 7.投保企业与特定买方的持续交易，应当在首次投保之后，最后一次投保的保单终止之前（以下称“上述期间”），持续向本保险人投保。如发生保险事故时，在上述期间被保险人与特定买方存在未投保交易，则保险人将按照已投保贸易额与上述期间内总交易额（包括任何形式完成的交易）的比例进行赔付，即赔偿金额=按保单及协议其他条件核定的损失*已投保交易额/被保险人与该特定买方在上述保险期间内的总销售额。<br/>
8.产品责任事故发生时间与报案时间须在保单承保期限之内,保险公司予以理赔。</p>
                                </td>                                
                            </tr>
                            <tr>
                                <td colspan="8">《 中国人民财产保险股份有限公司产品责任保险条款（1993版）》</td>                             
                            </tr>
                            
                             <tr>
                                <td colspan="8">
                                   <input class="cg_fb" type="submit" value="提交" onclick="submit"/><input class="cg_fb" type="button" value="返回" onclick="history.go(-1)"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                        
                    </div>
                </div>
            </div>
            <!--end中间内容-->  
            <script type="text/javascript">
       $(document).ready(function(){
        $('#theidentType').on('change', function(){
            if ($(this).val() != 01) {
                $('.birthday').show();
            }else{
                $('.birthday').hide();
            }
        });
       });         
            </script>