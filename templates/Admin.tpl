<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><!--{UserName}--></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
    <link href="styles/admin.css" type="text/css" rel="stylesheet">
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
	<div id="left">

	</div>
	<div id="right">
		<h2 style=>This is Admin Page</h2>
	</div>

</html>
