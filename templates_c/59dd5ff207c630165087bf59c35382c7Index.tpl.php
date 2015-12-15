<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->proConfigs['WebName']; ?></title>
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
                    <?php foreach($this->values['cat'] as $k => $v){ ?>
                    <li class="nav-item"><a href="index.php?cat=<?php echo $k; ?>"><?php echo $v; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>

</body>
</html>
