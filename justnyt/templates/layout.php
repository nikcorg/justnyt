<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
    <link rel="shortcut icon" href="/assets/img/glyphicons_054_clock.png" type="image/png">
    <title><?= isset($title) ? preg_replace("/\s+?(-|&mdash;) Just Nyt!$/i", "", $title) . " - " : "" ?>Just Nyt!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta property="og:title"
        content="<?= isset($title) ? preg_replace("/\s+?(-|&mdash;) Just Nyt!$/i", "", $title) . " - " : "" ?>Just Nyt!">

    <?php if (isset($description)): ?>
        <meta property="og:description"
            content="<?= $description ?>">
    <?php else: ?>
        <meta property="og:description"
            content="Just Nyt! on vapaaehtoisten kuraattoreiden valitseman sisällön suosittelukone">
    <?php endif; ?>

    <script src="/assets/js/global.js"></script>
</head>
<body>
    <div class="wrapper site-block">
        <?php $this->snippet("snippets/header") ?>

        <main>
            <?php if (isset($curator)): ?>
                <?php $this->snippet("snippets/curator-navigation"); ?>
            <?php endif; ?>

            <?= $content ?>
        </main>

        <div class="footer-push"></div>
    </div>

    <?php $this->snippet("snippets/footer") ?>

    <?php if (isset($scripts) && is_array($scripts)): ?>
        <?php foreach ($scripts as $src): ?>
            <script type="text/javascript" src="<?= $src ?>" async defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
<!-- http://kakspistenolla.com -->
