<?php
/**
 * Layout template
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Searching for <?php echo $search?> | <?php echo $config['siteTitle']?></title>
        <link href="<?php echo $config['basePath']?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $config['basePath']?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
        body{padding-top:20px;padding-bottom:40px;}
        footer{border-top:1px solid #E5E5E5;margin-top:45px;padding:35px 0 36px;}
        .results .item{text-align:center;height:210px;overflow:hidden}
        .results .item h3{font-size:23px}
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                <div class="row">
                  <div class="span6">
                    <h1><a href="<?php echo $config['basePath']?>"><?php echo $config['siteTitle']?></a></h1>
                    <p class="lead">You can find any actor/actress role in movies</p>
                  </div>
                </div>
            </header>
<?php if($alerts):?>
            <div class="row">
                <div class="span12">
                    <div class="alert alert-block">
                        <a class="close">×</a>
                        <h4 class="alert-heading">Alert</h4>
                        <ul>
<?php foreach($alerts as $v):?>
                            <li><?php echo $v?></li>
<?php endforeach?>
                        </ul>
                    </div>
                </div>
            </div>
<?php endif?>
            <div class="row">
                <div class="span12">
                    <form class="well form-search" action="<?php echo $config['basePath']?>search" method="post">
                        <input class="input-medium search-query" type="text" name="search">
                        <button class="btn" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="span12">
                    <h2>Results for <?php echo $search?></h2>
                </div>
            </div>
            <div class="row results offset1">
<?php foreach($results as $v):?>
                <div class="span3 well item">
                    <h3><a href="<?php echo $v->link?>"><?php echo $v->name?></a></h3>
                    <a href="<?php echo $v->link?>"><img src="<?php echo $v->profile_path?>" alt="<?php echo $v->name?>" class="img-polaroid"></a>
                </div>
<?php endforeach?>
            </div>
            <footer>
                &copy; <?php echo date("Y")?>. Manuel Herrera - <a href="https://www.twitter.com/fractalsoftware">@fractalsoftware</a>
            </footer>
        </div>
<!--        <script src="<?php echo $config['basePath']?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
    </body>
</html>
