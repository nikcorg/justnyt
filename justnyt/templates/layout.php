<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
    <link rel="shortcut icon" href="/assets/img/glyphicons_054_clock.png" type="image/png">
    <title><?= isset($title) ? $title . " - " : "" ?>Just Nyt!</title>
</head>
<body>
    <?php $this->snippet("snippets/header") ?>

    <main><?= $content ?></main>

    <?php $this->snippet("snippets/footer") ?>
</body>
</html>
