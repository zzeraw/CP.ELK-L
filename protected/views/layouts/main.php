<!doctype html>

<!--[if lt IE 7]>
<html lang="ru" class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html lang="ru" class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html lang="ru" class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]>
<html lang="ru" class="no-js">
<![endif]-->


<!--[if !IE]><!--><html lang="ru" class="not-ie"><!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content='<?php echo CHtml::encode($this->pageDescription); ?>'>
    <meta name="keywords" content='<?php echo CHtml::encode($this->pageKeywords); ?>'>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link rel="apple-touch-icon" href="/touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/touch-icon-ipad-retina.png">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <script src="/js/modernizr.custom.70918.js"></script>

    <?php Yii::app()->clientScript->registerPackage('jquery'); ?>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,300italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="/css/animate.min.css"> -->

    <link rel="stylesheet" href="/css/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" href="/css/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
    <link rel="stylesheet" href="/css/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="/js/html5shiv.min.js"></script>
        <script src="/js/json2.min.js"></script>
        <script src="/js/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="/css/styles.css" rel="stylesheet">
</head>

<body data-spy="scroll" data-target="#mainNavbar">

    <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter30469597 = new Ya.Metrika({id:30469597, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/30469597" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->

    <?php echo $content; ?>


    <?php
        foreach ($this->buffer as $buffer) {
            echo $buffer;
        }
    ?>




    <iframe src="http://elekkom.ru/setCookie.php?name=elekkom-site&value=elkey&expire=<?=3600 * 24 * 2?>" style="height: 0;width: 0; overflow: hidden; display: none;"></iframe>

    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
    (function(){ var widget_id = 'lftuN93Pyi';
    var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
    <!-- {/literal} END JIVOSITE CODE -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script type="text/javascript" src="/js/jquery-1.11.2.min.js"></script> -->
    <!-- <script type="text/javascript" src="/js/jquery.stellar.min.js"></script> -->
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script type="text/javascript" src="/js/ie10-viewport-bug-workaround.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="/js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="/js/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript" src="/js/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="/js/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript" src="/js/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <script type="text/javascript" src="/js/main.js"></script>

</body>



</html>

