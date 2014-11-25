<p>Menneitä suosituksia.</p>

<ol reversed>
<?php foreach ($recommendations as $recommendation): ?>
    <li><a href="/s/<?= $recommendation->getShortLink() ?>" rel="nofollow"><?= $recommendation->getTitle() ?></a>
    <?php if (null != $recommendation->getRecommendationHint()): ?>
        (Vinkkasi <?= $recommendation->getRecommendationHint()->getAlias() ?: "Anonyymi" ?>)
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ol>
