<?php 

    $assetsRoute = 'private-assets';

    if($access == 'public')
        $assetsRoute = 'public-assets';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?>">
    <meta name="author" content="Quetzal Framework" />
    <meta name="copyright" content="Desarrollado por Hamilton and Lovelace" />
    <meta name="keywords" content="<?= $keywords ?>">
    <meta name="theme-color" content="#317EFB"/>
    <title><?= (isset($titulo)) ? $titulo : 'Quetzal Framework' ?></title>
    <link rel="shortcut icon" href="public-assets/imagenes?path=Quetzal_Framework.png" />
    <link rel="apple-touch-icon" href="public-assets/imagenes?path=Quetzal_Framework.png">
    <!-- estilos generales -->
    <link rel="stylesheet" href="<?= $assetsRoute?>/css?path=<?= $view?>">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="manifest" href="/manifest.json">
</head>

<body>
    <?= $this->section('content');?>
    <script src="public-assets/app"></script>
    <script type='module' src='<?= $assetsRoute?>/js?path=<?= $view?>'></script>
</body>

</html>