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
        <title><?php echo $config['siteTitle']?></title>
        <link href="<?php echo $config['basePath']?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $config['basePath']?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
        body{padding-top:20px;padding-bottom:40px;}
        footer{border-top:1px solid #E5E5E5;margin-top:45px;padding:35px 0 36px;}
        .form-search{text-align:center}
        .form-search input{width:70%;font-size:2em;height:2em}
        .form-search button{font-size:2em;height:1.5em}
        </style>
        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-39323096-1']);
          _gaq.push(['_trackPageview']);
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>
    </head>
    <body>
        <div class="container">
            <header>
                <div class="row">
                  <div class="span6">
                    <h1><?php echo $config['siteTitle']?></h1>
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
                    <form class="well form-search hero-unit" action="<?php echo $config['basePath']?>search" method="post">
                        <p>
                        <input class="input-medium search-query" type="text" name="search">
                        </p>
                        <p>
                        <button class="btn btn-primary" type="submit">Search</button>
                        </p>
                    </form>
                </div>
            </div>
            <footer>
                &copy; <?php echo date("Y")?>. Manuel Herrera - <a href="https://www.twitter.com/fractalsoftware">@fractalsoftware</a>
            </footer>
        </div>
<!--        <script src="<?php echo $config['basePath']?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
    </body>
</html>
