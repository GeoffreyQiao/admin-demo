<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <title><!--{WebName}--></title>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
        <link href="styles/style.css" type="text/css" rel="stylesheet">
    </head>
<body>
    <header>
        <nav>
            <h1>@<!-- 隐藏的优化信息 --></h1>
            <div class="navbar">
                <ul id="nav-items"> <!-- 全站内容分类导航 -->
                    {foreach $cat (@k,@v)}
                    <li class="nav-item"><a href="index.php?cat={@k}">{@v}</a></li>
                    {/foreach}
                </ul>
            </div>
        </nav>
    </header>

</body>
</html>
