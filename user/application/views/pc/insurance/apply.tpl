<div class="user_c">
    <div class="user_zhxi">
        <div class="zhxi_tit">
            <p><a>保险管理</a>><a>保险申请</a></p>
        </div>
        <div style="float:left">
            <form method="post" action="{url:/Insurance/doApply}" auto_submit redirect_url="{url:/ucenter/baseInfo}">
                <div class="zhxi_con">
                    <span class="con_tit"><i></i>商品名称：</span>
                    <span>{$detail['name']}</span>
                </div>
                <div class="zhxi_con">
                    <span class="con_tit"><i></i>报盘类型：</span>
                   <span>{$detail['modetext']}</span>
                </div>


                <div class="zhxi_con">
                    <span class="con_tit"><i>*</i>保险产品：</span>
                    <span>
                        {if: !empty($risk_data)}
                            {foreach: items=$risk_data}
                                <input type="checkbox" name="risk[]"  value="{$item['risk_id']}">{$item['name']}{if: $item['mode'] == 1}比例： {$item['fee']} {else:}定额： {$item['fee']} {/if}
                            {/foreach}
                        {else:}
                            该分类没有设置保险，不能申请
                        {/if}
                    </span>
                    <span></span>
                </div>
                {if: !empty($risk_data)}
                <div class="zhxi_con">
                    <span class="con_tit"><i>*</i>购买数量：</span>
                    <span><input  name="quantity" type="text" datatype="float" ></span>
                    <span></span>
                </div>
                <div class="zhxi_con">
                    <span class="con_tit"><i></i>说明：</span>
                    <span>
                         <textarea name="note">

                          </textarea>
                    </span>
                </div>
                <input type="hidden" name="id" value="{$detail['id']}">
                <div class="zhxi_con">
                    <span><input class="submit" type="submit" value="提交"/></span>
                </div>
                {/if}
            </form>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>