<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <title><!--{WebName}--></title>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
        <link href="./styles/cates.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <header>
    		<nav>
    			<div class="nav-bar">Geo<img src="#" alt=""></div>
    			<div class="nav-item">
    				<ul>
    					<li><a href="Index.php">主	页</a></li>
                        {foreach $cat (@k,@v)}
                        <li class="nav-item"><a href="index.php?cat={@k}">{@v}</a></li>
                        {/foreach}
    				</ul>
    			</div>
    		</nav>
    	</header>
        <section>
            <ul class="item-group">
                <li class="item-view">
                    <div class="item-img">
                        <img src="#" alt="" />
                    </div>
                    <div class="item-detail">
                        <h2 class="item-name">{$item-name}尖峰时刻</h2>
                        <p class="item-eName"><title>外名</title><span>{$item-eName}Fast time</span></p>
                        <p class="item-kind"><title>类型</title><span>{$item-kind}动作</span></p>
                        <p class="item-scope"><title>评分</title><span>{$item-scope}8.9</span></p>
                    </div>
                </li>
            </ul>
        </section>
    </body>
</html>
