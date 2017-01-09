        <script type="text/javascript" src="{root:js/area/AreaData_min.js}" ></script>
<script type="text/javascript" src="{root:js/area/Area.js}" ></script>
        <!--            
              CONTENT 
                        -->
        <div id="content" class="white">
            <h1><img src="{views:img/icons/dashboard.png}" alt="" />找货管理
</h1>

<div class="bloc">
    <div class="title">
       找货信息
    </div>
     <div class="pd-20">

	 	 <table class="table table-border table-bordered table-bg">

	 		<tr>
	 			<th>用户名</th>
	 			<td>{$detail['username']}</td>
	 		</tr>
            <tr>
                <th>商品名称</th>
                <td>{$detail['product_name']}</td>
            </tr>
            <tr>
                <th>规格</th>
                <td>{$detail['spec']}</td>
            </tr>
            <tr>
                <th>数量</th>
                <td>{$detail['num']}</td>
            </tr>
            <tr>
                <th>产地</th>
                <td>{areatext:data=$detail['place']}</td>
            </tr>
            <tr>
                <th>联系人</th>
                <td>{$detail['user_name']}</td>
            </tr>
      	 		<tr>
                    <th>联系电话</th>
                    <td colspan="5">{$detail['phone']}</td>
      	 		</tr>
             <tr>
                <th>地区</th>
                <td colspan="5">
                {areatext:data=$detail['area'] id=place}
                </td>
            </tr>
            <tr>
                <th>商品描述</th>
                <td colspan="5">
                        {$detail['description']}
                </td>
            </tr>
            <tr>

              <th>发布时间</th>
              <td colspan="5">{$detail['create_time']}</td>

            </tr>
	 	</table>
 	</div>
</div>
</div>
