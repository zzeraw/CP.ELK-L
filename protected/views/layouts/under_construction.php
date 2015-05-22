<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">

    <meta name="robots" content="none">

    <!--[if lte IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/json2.min.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->

    <?php Yii::app()->clientScript->registerPackage('jquery'); ?>
    <?php Yii::app()->clientScript->registerPackage('bootstrap3'); ?>


    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,300italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

    <div class="container">
        <?php echo $content; ?>
    </div>


    <div class="footer">
        <div class="container">
            &copy; <?=date('Y')?>
        </div>
    </div>


</body>


</html>

