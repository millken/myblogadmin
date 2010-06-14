{include file='header.tpl'}
{include file='dashboard.tpl'}

{if $action eq 'add' || $action eq 'edit'}

<!-- Container Starts -->
<div id="container">


    <!-- Full Width Start-->
    
    
    <!-- Featured Ends -->

    
<form action="" method="post" >
   <div class="wrap">
      <h2>{if $action eq 'add'}添加目录 {else}修改目录{endif}</h2>

      <div id="poststuff">

<div>
<div class="stuffbox" id="namediv">
<h3>名称</h3>
<div class="inside">

	<input type="text" id="name" value="{$category.name}" tabindex="1" size="30" name="name"/><br/>
    目录的名字，将会显示在页面上</div>
</div>

<div class="stuffbox" id="addressdiv">
<h3>名称(slug)</h3>
<div class="inside">
	<input type="text" id="slug" value="{$category.slug}" tabindex="1" size="30" name="slug"/><br/>
    "slug"是一个URL友好的名称，将会被用在生成的url链接里面，通常只包含英文，数字和下划线</div>
</div>

<div class="stuffbox" id="addressdiv">
<h3>上级目录</h3>
<div class="inside">
    <select name="parentkey">
       <option value=''>None</option>
        
       <option value="agRtbG9ncg4LEghDYXRlZ29yeRgFDA" >sdf</option>
        
       <option value="agRtbG9ncg4LEghDYXRlZ29yeRgGDA" >asdasd</option>
        
    </select>

</div>

</div>
<div><input type="submit" tabindex="4" value="保存" name="" class="button button-highlighted"/></div>

</div>

   </div>
   </form>
 




<div class="clear"></div>
</div>
<!-- Container Ends -->


{else}

<!-- Container Starts -->
<div id="container">


    <!-- Full Width Start-->
    
    
    <!-- Featured Ends -->

    
 <form action="" method="post" >
   <div class="wrap">

      <h2>管理目录 (<a href="/admin/category/add">新建</a>)</h2>

      <div class="" style="padding:10px 5px 5px 5px"><B>所有目录</b><span style='color:gray'> (1) </span></div>

      <div class="clear"></div>

	   <div class="tablenav">
		  <div class="alignleft">
		  <input type="submit" class="button-secondary delete" name="deleteit" value="删除"/>
		  </div>

    <div class="alignright">
	        

			
            <div class="alignright" style="padding:0px 10px;">  第1页</div>
         </div>

		      <br class="clear"/>
	   </div>
	  <br class="clear"/>
	  


	   <table class="widefat">

		<thead>
			<tr>
			<th class="check-column" style="text-align:left;padding-left:12px;" scope="col"><input type="checkbox" onclick="$('input[name=checks]').attr('checked',this.checked);"/></th>
		<th style="width: 15%;">名称</th><th>名称(slug)</th><th>上一级</th>	</tr>
			</thead>
			<tbody>
			
{foreach $category as $cate}
			<tr valign="middle" id="link-{$cate.slug}">			
			                <td  colspan="2" style="text-align:left;padding-left:20px;"><input style="margin-left:0.0px;"
							type="checkbox" value="{$cate.slug}" name="checks"/>  <a class="row-title"
							title='Edit "sdf"' href="{$editurl}{$cate.slug}">{$cate.name}</a></td>
                            <td>{$cate.slug}</td> 
                             <td></td> 
                           </tr>
			  	
			{endforeach}
			<tr valign="middle" id="link-agRtbG9ncg4LEghDYXRlZ29yeRgGDA">			
			                <td  colspan="2" style="text-align:left;padding-left:20px;"><input style="margin-left:20.0px;" type="checkbox" value="agRtbG9ncg4LEghDYXRlZ29yeRgGDA" name="checks"/>  <a class="row-title" title='Edit "asdasd"' href="/admin/category?key=agRtbG9ncg4LEghDYXRlZ29yeRgGDA&amp;action=edit">asdasd</a></td>
                            <td>asdasd</td>
                             <td>sdf</td>

                           </tr>
			  	
			
			


          
			</tbody>
		</table>

   </div>
</form>
 




<div class="clear"></div>
</div>
<!-- Container Ends -->
{endif}
{include file='footer.tpl'}