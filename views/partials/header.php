    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>Document</title>
</head>
<body>
    <div class="contain_dasboard ">
    <div class="menu_dash ">
        <h2>Bienvenue v<?= $_SESSION["userConnected"]["nom"] ?? "" ?>!</h2>
        <button type="submit"><a href="<?=WEBROOT?>?page=deconnexion">Deconnexion</a></button>
    </div>