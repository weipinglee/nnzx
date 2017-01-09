
			<!--start中间内容-->	
			<div class="user_c">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>产品管理</a>><a>产品发布</a></p>
					</div>
					<div class="chp_xx">
						<div class="success_text">
                        {if: $success == 1}
							<p><b class="b_size">您发布的信息已提交审核。</b></p>
							<p>我们将在3个工作日内完成审核，审核结束会在第一时间通知您。</p>
							<p>您还可以进行以下操作:</p>
                            {else:}
                                <p><b class="b_size">您发布的信息提交失败,失败原因如下：</b></p>
                            <p>{$msg}</p>
                            {/if}
      
							<p><a class="a_color" href="{$url['backUrl']}">查看已发布的信息</a>  <a class="a_color" href="{$url['goUrl']}">继续发布新的信息</a></p>
						</div>
						
						
					</div>
				</div>
			</div>
			<!--end中间内容-->	
	
