<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
    <link rel="shortcut icon" href="/assets/img/glyphicons_054_clock.png" type="image/png">
    <link rel="alternate" href="/feed/rss" type="application/rss+xml">
    <title><?= isset($title) ? preg_replace("/\s+?(-|&mdash;) Just Nyt!$/i", "", $title) . " - " : "" ?>Just Nyt!</title>
    <meta name="google-site-verification" content="EpMiQogg3lp02uS0ozMODwsMHemGQgE7F10LZm0wDUc" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta property="og:url" content="https://justnyt.fi"/>
    <meta property="og:type" content="website"/>
    <meta property="og:locale" content="fi_FI"/>
    <meta property="og:site_name" content="Just Nyt!"/>
    <meta property="og:image" content="https://justnyt.fi/assets/img/justnytfi.jpg"/>
    <meta property="og:title"
        content="<?= isset($title) ? preg_replace("/\s+?(-|&mdash;) Just Nyt!$/i", "", $title) . " - " : "" ?>Just Nyt!">

    <?php if (isset($head)): ?>
        <?= implode("\n", $head) ?>
    <?php endif; ?>

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
