<?php
$t = [];
?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <style type="text/css">
        html, body {
            background: url('../web/uploads/maps/esteren_nouvelle_cartepg_91220092.jpeg') center no-repeat;
            background-size: cover;
            color: white;
            font-family: verdana, sans-serif;
            font-size: 12px;
            font-weight: normal;
            height: 100%;
            margin: 0;
            padding: 0;
            display: block;
        }

        .a img {
            /*position: relative;*/
            /*top: -50px;*/
            /*margin: 150px 25px 0;*/
            margin: 150px 0 0 0;
        }

        section {
            /*padding-top: 150px;*/
            height: 100%;
        }

        img {
            display: inline-block;
        }

        div {
            width: 800px;
            text-align: center;
            margin: 0 auto;
        }

    </style>
</head>
<body>
<section>
<?php

/*
COMMANDES FINALES:

convert icones_filled.png +level-colors "#473637", -gamma 0.6 -resize 16x16 pastille-red-darker.png
convert icones_filled.png +level-colors "#61494b", -gamma 0.8 -resize 16x16 pastille-red-dark.png
convert icones_filled.png +level-colors "#b3a196", -gamma 0.7 -resize 16x16 pastille-gray.png
convert icones_filled.png +level-colors "#dbd4ca", -gamma 0.8 -resize 16x16 pastille-gray-light.png
convert icones_filled.png +level-colors "#4A824A", -gamma 0.75 -resize 16x16 pastille-green-dark.png
convert icones_filled.png +level-colors "#74B274", -gamma 0.8 -resize 16x16 pastille-green.png
convert icones_filled.png +level-colors "#c4a764", -gamma 0.7 -resize 16x16 pastille-beige.png
convert icones_filled.png +level-colors "#dbc199", -gamma 0.8 -resize 16x16 pastille-beige-light.png
convert icones_filled.png -gamma 0.6 +level-colors "#b5c7da", -gamma 0.7 -resize 16x16 pastille-blue.png
convert icones_filled.png -gamma 3 +level-colors "#b5c7e3", -gamma 0.13 -resize 16x16 pastille-blue-dark.png

 */

$t['red-darker'] = '#473637';//bordeaux
$t['red-dark'] = '#61494b';//bordeaux-dark
$t['gray'] = '#b3a196';//gris
$t['gray-light'] = '#dbd4ca';//grisclair
$t['green-dark'] = '#4A724A';//vert foncé
$t['green'] = '#74B274';//vert
$t['beige'] = '#c4a764';//beige
$t['beige-light'] = '#dbc199';//brunclair
$t['blue'] = '#b5c7c3';//bleu
$t['blue-dark'] = '#2C4741';//bleu foncé

//echo '<div>Codes: '.implode(', ',$t).'</div>';

?>

<br>

<div style="" class="a">

<?php $t=[];foreach($t as$k=>$c):?><div style="width: 80px; position: relative;top: 0; height: 150px; padding-top: 65px; font-size: 9px; display: inline-block; background: <?= $c ?>;"><?=$k?><br><?=$c?></div><?php endforeach ?>

<!--<img src="../web/img/markerstypes/icones.png" class="../web/img-responsive img">-->
<!--<img src="../web/img/markerstypes/test.png" class="../web/img-responsive img">-->


<img src="../web/img/markerstypes/pastille-red-darker.png"><?php
?><img src="../web/img/markerstypes/pastille-red-dark.png"><?php
?><img src="../web/img/markerstypes/pastille-gray.png"><?php
?><img src="../web/img/markerstypes/pastille-gray-light.png"><?php
?><img src="../web/img/markerstypes/pastille-green-dark.png"><?php
?><img src="../web/img/markerstypes/pastille-green.png"><?php
?><img src="../web/img/markerstypes/pastille-beige.png"><?php
?><img src="../web/img/markerstypes/pastille-beige-light.png"><?php
?><img src="../web/img/markerstypes/pastille-blue.png"><?php
?><img src="../web/img/markerstypes/pastille-blue-dark.png">

</div>

<div style="clear: both">
    <?php
    foreach (glob('img/markerstypes/*') as $file) {
        if (true or!preg_match('~pastille-~sUu', $file)) { continue; }
        ?><img src="../web/img/markerstypes/<?= basename($file) ?>" style="margin: 0 30px;" class="../web/img-responsive img"><?php
    }
    ?>
</div>
</section>
</body>
</html>
