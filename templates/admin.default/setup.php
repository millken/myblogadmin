<?php include 'header.php'?>
<?php include 'dashboard.php'?>
<!-- Container Starts -->
<div id="container">


    <!-- Full Width Start-->
    
    
    <!-- Featured Ends -->

    
     <!-- Admin Full Width -->
    <div id="m_admin">
        <form method="post">

            <div class="wrap">
            <h2>博客设置/系统配置</h2>

            <table class="form-table">
                 <tr valign="top">
                <th scope="row">博客标题</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('title');?>"  id="title" name="title"/>
                </td>

                </tr>

                <tr valign="top">
                <th scope="row">子标题</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('subtitle');?>" style="width: 95%;" id="subtitle" name="subtitle" />
                <br/>
                关于这个博客的简单介绍</td>
                </tr>

                <tr valign="top">
                <th scope="row">公告</th>
                <td><textarea id="blognotice" style="width:95%" cols="45" rows="2" name="blognotice"><?php echo Blog::getOptions('blognotice');?></textarea>
               </td>
                 </tr>
                  <tr valign="top">
                <th scope="row">域名:</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('domain');?>"  id="domain" name="domain" />
               </td>
                </tr>
                </tr>
                  <tr valign="top">

                <th scope="row">博客网址(URL):</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('baseurl');?>"  id="baseurl" name="baseurl" />
               </td>
                </tr>

                 <tr valign="top">
                <th scope="row">RSS/Atom Feed地址:</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('feedurl');?>"  id="feedurl" name="feedurl" />

               </td>
                </tr>
                 <tr valign="top">
                <th scope="row">时间差调整(单位:小时):</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('timedelta');?>"  id="timedelta" name="timedelta" />
               </td>
                </tr>


            <tr valign="top">
                <th scope="row">应用主题:</th>
                <td>
                    <select  id="theme_name" name="theme_name" >
                    
                    <option value=".svn" >.svn</option>
                    
                    <option value="default" selected='selected'>default</option>
                    
                    <option value="xuming" >xuming</option>

                    

                    </select> 
                       <a href="http://micolog.appspot.com/themes" target="_blank">Get more themes</a>
               </td>
               </tr>
                  <tr valign="top">
                <th scope="row">每页文章数:</th>
                <td><input type="text" size="8" value="<?php echo Blog::getOptions('posts_per_page');?>"  id="posts_per_page" name="posts_per_page" />
               </td>

               </tr>
               <tr valign="top">
                <th scope="row">评论顺序</th>
                <td>
                   <input type="radio"   id="comments_order0" name="comments_order"  checked="checked"  value="0"/><label for="comments_order0">升序</label>
                   <input type="radio"   id="comments_order1" name="comments_order"  value="1"/><label for="comments_order1">降序</label>
               </td>

               </tr>

   <tr valign="top">
                <th scope="row">每页评论数:</th>
                <td><input type="text" size="8" value="<?php echo Blog::getOptions('comments_per_page');?>"  id="comments_per_page" name="comments_per_page" />
               </td>
               </tr>


                   <tr valign="top" style="display:none">
                <th scope="row">允许将评论发送到你的邮箱:</th>
                <td><input type="checkbox" size="45"  checked="checked"   id="comment_notify_mail" name="comment_notify_mail" />
               </td>
                </tr>
    <tr valign="top">
                <th scope="row">启用缓存:</th>

                <td><input type="checkbox" size="45"   id="enable_memcache" name="enable_memcache" />
               </td>
                </tr>
  <tr valign="top">
                <th scope="row">允许 Trackback</th>
                <td><input type="checkbox" size="45"   id="allow_trackback" name="allow_trackback" />
               </td>
                </tr>

  <tr valign="top">
                <th scope="row">允许 Pingback</th>
                <td><input type="checkbox" size="45"   id="allow_pingback" name="allow_pingback" />
               </td>
                </tr>
            </table>
            <h3>客户端（Xmlrpc）调用设置：</h3>

            <p>为了您可以通过客户端工具（如Windows live writer）进行写作，请在这里设置用户名和密码</p>
            <table class="form-table">
               <tr valign="top">
                <th scope="row">用户名:</th>
                <td><input type="text" size="45" value="<?php echo Blog::getOptions('rpcuser');?>"  id="rpcuser" name="rpcuser" />
               </td>
                </tr>

                <tr valign="top">
                <th scope="row">密码:</th>
                <td><input type="password" size="45" value="<?php echo Blog::getOptions('rpcpassword');?>"  id="rpcpassowrd" name="rpcpassword" />
               </td>
                </tr>
            </table>


<p class="submit"><input type="submit" value="保 存" name="Submit"/>
<input type="hidden" value="update" name="action"/>

<input type="hidden" value="title,subtitle,baseurl,feedurl,rpcuser,rpcpassword,theme_name,domain,default_link_format,blognotice,link_format" name="str_options"/>
<input type="hidden" value="enable_memcache,comment_notify_mail,allow_trackback,allow_pingback" name="bool_options"/>
<input type="hidden" value="posts_per_page,comments_order,comments_per_page,comment_check_type" name="int_options"/>
<input type="hidden" value="timedelta" name="float_options"/>

</p>

  </div>

        </form>
    </div>
    <!-- Featured Ends -->




<div class="clear"></div>
</div>
<!-- Container Ends -->
<?php include 'footer.php'?>