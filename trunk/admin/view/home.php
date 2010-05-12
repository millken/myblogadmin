<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>个人设置 - Hello World - Powered by Typecho</title>
        <meta name="robots" content="noindex,nofollow" />
        <link rel="stylesheet" type="text/css" href="http://localhost/typecho/admin/css/reset.source.css?v=10.3.8" /> 
<link rel="stylesheet" type="text/css" href="http://localhost/typecho/admin/css/grid.source.css?v=10.3.8" /> 
<link rel="stylesheet" type="text/css" href="http://localhost/typecho/admin/css/typecho.source.css?v=10.3.8" />    </head>
    <body>

<div class="typecho-head-guid body-950">
    <dl id="typecho:guid">
        <dt class="focus"><a href="http://localhost/typecho/admin/index.php" title="控制台">控制台</a></dt>
<dd><ul>
<li><a href="http://localhost/typecho/admin/index.php" title="概要">概要</a></li>
<li class="focus"><a href="http://localhost/typecho/admin/profile.php" title="个人设置">个人设置</a></li>
<li><a href="http://localhost/typecho/admin/plugins.php" title="插件">插件</a></li>
<li><a href="http://localhost/typecho/admin/themes.php" title="外观">外观</a></li>
</ul></dd>
<dt><a href="http://localhost/typecho/admin/write-post.php" title="创建">创建</a></dt>

<dd><ul>
<li><a href="http://localhost/typecho/admin/write-post.php" title="撰写文章">撰写文章</a></li>
<li><a href="http://localhost/typecho/admin/write-page.php" title="创建页面">创建页面</a></li>
</ul></dd>
<dt><a href="http://localhost/typecho/admin/manage-posts.php" title="管理">管理</a></dt>
<dd><ul>
<li><a href="http://localhost/typecho/admin/manage-posts.php" title="文章">文章</a></li>
<li><a href="http://localhost/typecho/admin/manage-pages.php" title="独立页面">独立页面</a></li>
<li><a href="http://localhost/typecho/admin/manage-comments.php" title="评论">评论</a></li>
<li><a href="http://localhost/typecho/admin/manage-metas.php" title="标签和分类">标签和分类</a></li>

<li><a href="http://localhost/typecho/admin/manage-medias.php" title="附件">附件</a></li>
<li><a href="http://localhost/typecho/admin/manage-users.php" title="用户">用户</a></li>
</ul></dd>
<dt><a href="http://localhost/typecho/admin/options-general.php" title="设置">设置</a></dt>
<dd><ul>
<li><a href="http://localhost/typecho/admin/options-general.php" title="基本">基本</a></li>
<li><a href="http://localhost/typecho/admin/options-discussion.php" title="评论">评论</a></li>
<li><a href="http://localhost/typecho/admin/options-reading.php" title="文章">文章</a></li>
<li><a href="http://localhost/typecho/admin/options-permalink.php" title="永久链接">永久链接</a></li>
</ul></dd>

    </dl>
    <p class="operate">欢迎, <a href="http://localhost/typecho/admin/profile.php" class="author important">admin</a>
            <a class="exit" href="http://localhost/typecho/action/logout" title="登出">登出</a></p>
</div>

<div class="main">
    <div class="body body-950">
        <div class="container typecho-page-title">
    <div class="column-24">

        <h2>个人设置</h2>
        <p><a href="http://localhost/typecho/">查看我的站点</a></p>
    </div>
</div>
        <div class="container typecho-page-main">
            <div class="column-16 suffix typecho-content-panel">
                <h4>
                <img src="http://www.gravatar.com/avatar/20a5844bc608d51cdbe28b74495f809d?s=20&r=X&d=" alt="admin" width="20" height="20" />                admin<cite>(admin)</cite>

                </h4>
                <p>目前有 <em>3</em> 篇 Blog,并有 <em>1</em> 条关于你的评论在已设定的 <em>2</em> 个分类中.</p>
                <p>最后登录: 4月22日</p>

                                <h3 id="writing-option">撰写设置</h3>
                <form action="http://localhost/typecho/action/users-profile" method="post" enctype="application/x-www-form-urlencoded">
<ul class="typecho-option" id="typecho-option-item-autoSave-0">
<li>
<label class="typecho-label">
自动保存</label>
<span>
<input name="autoSave" type="radio" value="0" id="autoSave-0" checked="true" />
<label for="autoSave-0">
关闭</label>
</span>
<span>

<input name="autoSave" type="radio" value="1" id="autoSave-1" />
<label for="autoSave-1">
打开</label>
</span>
<p class="description">
自动保存功能可以更好地保护你的文章不会丢失.</p>
</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-defaultAllow-1">
<li>
<label class="typecho-label">
默认允许</label>
<span>
<input name="defaultAllow[]" type="checkbox" value="comment" id="defaultAllow-comment" checked="true" />

<label for="defaultAllow-comment">
可以被评论</label>
</span>
<span>
<input name="defaultAllow[]" type="checkbox" value="ping" id="defaultAllow-ping" checked="true" />
<label for="defaultAllow-ping">
可以被引用</label>
</span>
<span>
<input name="defaultAllow[]" type="checkbox" value="feed" id="defaultAllow-feed" checked="true" />
<label for="defaultAllow-feed">
出现在聚合中</label>
</span>
<p class="description">

设置你经常使用的默认允许权限</p>
</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-do-2" style="display:none">
<li>
<input name="do" type="hidden" value="options" />
</li>
</ul>
<ul class="typecho-option typecho-option-submit" id="typecho-option-item-submit-3">
<li>
<button type="submit">
保存设置</button>
</li>
</ul>
</form>

                                                <h3 id="change-password">设置密码</h3>
                <form action="http://localhost/typecho/action/users-profile" method="post" enctype="application/x-www-form-urlencoded">
<ul class="typecho-option" id="typecho-option-item-password-4">
<li>
<label class="typecho-label" for="password-0-5">
用户密码</label>
<input id="password-0-5" name="password" type="password" class="password" />
<p class="description">
为此用户分配一个密码.<br />
        建议使用特殊字符与字母的混编样式,以增加系统安全性.</p>

</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-confirm-5">
<li>
<label class="typecho-label" for="confirm-0-6">
用户密码确认</label>
<input id="confirm-0-6" name="confirm" type="password" class="password" />
<p class="description">
请确认你的密码, 与上面输入的密码保持一致.</p>
</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-do-6" style="display:none">
<li>
<input name="do" type="hidden" value="password" />
</li>

</ul>
<ul class="typecho-option typecho-option-submit" id="typecho-option-item-submit-7">
<li>
<button type="submit">
更新密码</button>
</li>
</ul>
</form>
            </div>
            <div class="column-08 typecho-mini-panel typecho-radius-topleft typecho-radius-topright typecho-radius-bottomleft typecho-radius-bottomright">
                <form action="http://localhost/typecho/action/users-profile" method="post" enctype="application/x-www-form-urlencoded">
<ul class="typecho-option" id="typecho-option-item-screenName-8">
<li>

<label class="typecho-label" for="screenName-0-9">
昵称</label>
<input id="screenName-0-9" name="screenName" type="text" class="text" value="admin" />
<p class="description">
用户昵称可以与用户名不同, 用于前台显示.<br />
        如果你将此项留空,将默认使用用户名.</p>
</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-url-9">
<li>
<label class="typecho-label" for="url-0-10">
个人主页地址</label>

<input id="url-0-10" name="url" type="text" class="text" value="http://www.typecho.org" />
<p class="description">
此用户的个人主页地址, 请用<strong>http://</strong>开头.</p>
</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-mail-10">
<li>
<label class="typecho-label" for="mail-0-11">
电子邮箱地址*</label>
<input id="mail-0-11" name="mail" type="text" class="text" value="webmaster@yourdomain.com" />
<p class="description">
电子邮箱地址将作为此用户的主要联系方式.<br />

        请不要与系统中现有的电子邮箱地址重复.</p>
</li>
</ul>
<ul class="typecho-option" id="typecho-option-item-do-11" style="display:none">
<li>
<input name="do" type="hidden" value="profile" />
</li>
</ul>
<ul class="typecho-option typecho-option-submit" id="typecho-option-item-submit-12">
<li>
<button type="submit">
更新我的档案</button>
</li>
</ul>

</form>
            </div>
        </div>
    </div>
</div>

<div class="typecho-foot">
    <h4><a href="http://typecho.org" class="logo-dark">typecho</a></h4>
    <div class="copyright">基于 <em>Typecho 0.8</em> <small> | 10.3.8</small> 构建</div>

    <div class="resource">
        <ul>
            <li><a href="http://docs.typecho.org">文档</a></li>
            <li><a href="http://forum.typecho.org">支持论坛</a></li>
            <li><a href="http://code.google.com/p/typecho/issues/entry">报告错误</a></li>
            <li><a href="http://extends.typecho.org">其他资源</a></li>
        </ul>

    </div>
</div>
<script type="text/javascript" src="http://localhost/typecho/admin/javascript/mootools.js?v=10.3.8"></script> 
<script type="text/javascript" src="http://localhost/typecho/admin/javascript/typecho.js?v=10.3.8"></script>
<script type="text/javascript">
    (function () {
        window.addEvent('domready', function() {
            var _d = $(document);
            var handle = new Typecho.guid('typecho:guid', {offset: 1, type: 'mouse'});
            
            //增加高亮效果
            (function () {
                var _hlId = '';
                
                if (_hlId) {
                    var _hl = _d.getElement('#' + _hlId);
                    
                    if (_hl) {
                        _hl.set('tween', {duration: 1500});
            
                        var _bg = _hl.getStyle('background-color');
                        if (!_bg || 'transparent' == _bg) {
                            _bg = '#F7FBE9';
                        }

                        _hl.tween('background-color', '#AACB36', _bg);
                    }
                }
            })();

            //增加淡出效果
            (function () {
                var _msg = _d.getElement('.popup');
            
                if (_msg) {
                    (function () {

                        var _messageEffect = new Fx.Morph(this, {
                            duration: 'short', 
                            transition: Fx.Transitions.Sine.easeOut
                        });

                        _messageEffect.addEvent('complete', function () {
                            this.element.setStyle('display', 'none');
                        });

                        _messageEffect.start({'margin-top': [30, 0], 'height': [21, 0], 'opacity': [1, 0]});

                    }).delay(5000, _msg);
                }
            })();
            
            //增加滚动效果,滚动到上面的一条error
            (function () {
                var _firstError = _d.getElement('.typecho-option .error');
    
                if (_firstError) {
                    var _errorFx = new Fx.Scroll(window).toElement(_firstError.getParent('.typecho-option'));
                }
            })();

            //禁用重复提交
            (function () {
                _d.getElements('input[type=submit]').removeProperty('disabled');
                _d.getElements('button[type=submit]').removeProperty('disabled');
    
                var _disable = function (e) {
                    e.stopPropagation();
                    
                    this.setProperty('disabled', true);
                    this.getParent('form').submit();
                    
                    return false;
                };

                _d.getElements('input[type=submit]').addEvent('click', _disable);
                _d.getElements('button[type=submit]').addEvent('click', _disable);
            })();

            //打开链接
            (function () {
                
                _d.getElements('a').each(function (item) {
                    var _href = item.href;
                    
                    if (_href && 0 != _href.indexOf('#')) {
                        //确认框
                        item.addEvent('click', function (event) {
                            var _lang = this.get('lang');
                            var _c = _lang ? confirm(_lang) : true;
                
                            if (!_c) {
                                event.stop();
                            }
                        });
        
                        /** 如果匹配则继续 */
                        if (/^http\:\/\/localhost\/typecho\/admin\/.*$/.exec(_href) 
                            || /^http\:\/\/localhost\/typecho\/action\/[_a-zA-Z0-9\/]+.*$/.exec(_href)) {
                            return;
                        }
            
                        item.set('target', '_blank');
                    }
                });
            })();
            
            Typecho.Table.init('.typecho-list-table');
            Typecho.Table.init('.typecho-list-notable');
        });
    })();
</script>
    </body>
</html>
