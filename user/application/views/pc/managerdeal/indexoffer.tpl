<script type="text/javascript" src="{root:js/jquery/jquery-1.8.0.min.js}" ></script>
			<!--end左侧导航-->	
			<!--start中间内容-->	
			<div class="user_c public">
				<div class="user_zhxi">
					<div class="zhxi_tit">
						<p><a>产品管理</a>><a>产品发布</a></p>
					</div>
					<div class="chp_xx">
						<div class="offer public" onclick="window.open('{url:/ManagerDeal/depositOffer}')">
							<div class="offer_left">
								<img src="{views:/images/center/publish1.png}">
							</div>
							<p class="of_title1">
								<span class="title1_a public">保证金报盘</span>
							</p>
							<p class="of_title2 public">履约有保障，货物交收更及时</p>
							<!-- <p class="of_title1">保证金报盘优点</p> -->
						</div>
							<div class="offer public" onclick="if({$certStatus['status']}==4){alert('请完善您的资质认证');window.open('{url:/ucenter/dealcert}');return false;}window.open('{url:/ManagerDeal/freeOffer}')">
							<div class="offer_center">
								<img src="{views:/images/center/publish2.png}">
							</div>
							<p class="of_title1">
								<span class="title1_a public">自由报盘</span>
							</p>
							<p class="of_title2 public">交易不受限制，交收方式更灵活</p>
							<!-- <p class="of_title1">自由报盘有什么吗</p> -->
						</div>
						<div class="offer public" onclick="if({$certStatus['status']}==4){alert('请完善您的资质认证');window.open('{url:/ucenter/dealcert}');return false;}window.open('{url:/ManagerDeal/storeOffer}')">
							<div class="offer_right">
								<img src="{views:/images/center/publish3.png}">
							</div>
							<p class="of_title1">
								<span class="title1_a public">仓单报盘</span>
							</p>
							<p class="of_title2 public">降低交易成本，货物质量有保证</p>
							<!-- <p class="of_title1">仓单报盘有什么吗</p> -->
						</div>
						<div class="offer public" onclick="if({$certStatus['status']}==4){alert('请完善您的资质认证');window.open('{url:/ucenter/dealcert}');return false;}window.open('{url:/ManagerDeal/deputeOffer}')">
							<div class="offer_right">
								<img src="{views:/images/center/publish4.png}">
							</div>
							<p class="of_title1">
								<span class="title1_a public">委托报盘</span>
							</p>
							<p class="of_title2 public">即将上线，敬请期待</p>
							<!-- <p class="of_title1">委托报盘有什么吗</p> -->
						</div>
					</div>
				</div>
			</div>

	<script>
		$(function(){
         
          $(".offer.public").hover(function(){
		    $(this).addClass("hover");
		    },function(){
		    $(this).removeClass("hover");
		  });
           
		});

	</script>