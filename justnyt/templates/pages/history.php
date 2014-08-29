<p>Menneitä suosituksia.</p>

<ol reversed>
<?php foreach ($recommendations as $recommendation): ?>
    <li><a href="/s/<?= $recommendation->getShortLink() ?>" rel="nofollow"><?= $recommendation->getTitle() ?></a>
    <?php if (null != $recommendation->getRecommendationHint() && "" != $recommendation->getRecommendationHint()->getAlias()): ?>
        (Vinkkasi <?= $recommendation->getRecommendationHint()->getAlias() ?>)
    <?php endif; ?>
    </li>
<?php endforeach; ?>
</ol>
