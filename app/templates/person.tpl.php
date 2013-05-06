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
        <title><?php echo $person->name?> | <?php echo $config['siteTitle']?></title>
        <link href="<?php echo $config['basePath']?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $config['basePath']?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
        body{padding-top:20px;padding-bottom:40px;}
        footer{border-top:1px solid #E5E5E5;margin-top:45px;padding:35px 0 36px;}
        .results .item{text-align:center;height:210px;overflow:hidden}
        .bio h2{font-size:16px}
        .bio .img-container{margin-bottom:25px;text-align:center}
        .credits h3{font-size:20px;line-height:1.2em}
        .poster{text-align:center;margin-bottom:15px}
        .item{height:310px;overflow:hidden}
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
                    <h2>Credits</h2>
                    <div class="row">
                        <div class="span8 credits">
<?php if($credits):?>
<?php foreach($credits as $v):?>
                            <div class="span2 well item">
                                <h3><a href="https://www.themoviedb.org/movie/<?php echo $v->id?>" target="_blank" title="<?php echo $v->title?>"><?php echo $v->mtitle?></a></h3>
                                <div class="poster">
                                    <a href="https://www.themoviedb.org/movie/<?php echo $v->id?>" target="_blank"><img src="<?php echo $v->poster_path?>" alt="<?php echo $v->title?>" class="img-polaroid"/></a>
                                </div>
                                <div class="info"><strong>Character:</strong> <?php echo $v->character?></div>
                                <div class="info"><strong>Date:</strong> <?php echo $v->release_date?></div>
                            </div>
<?php endforeach?>
<?php else:?>
                            <h3>No results for this person as an actor/actress.</h3>
<?php endif?>
                        </div>
                        <div class="span3 well bio">
                            <h2><?php echo $person->name?></h2>
                            <div class="img-container">
                                <img src="<?php echo $person->profile_path?>" alt="<?php echo $person->name?>" class="img-polaroid">
                            </div>
                            <p><small><?php echo nl2br(trim($person->biography))?></small></p>
                        </div>
                    </div>
                </div>
                </div>
            <footer>
                &copy; <?php echo date("Y")?>. Manuel Herrera - <a href="https://www.twitter.com/fractalsoftware">@fractalsoftware</a>
            </footer>
        </div>
<!--        <script src="<?php echo $config['basePath']?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>-->
    </body>
</html>
