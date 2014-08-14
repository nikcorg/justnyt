<p>Menneitä suosituksia.</p>

<ol reversed>
<?php foreach ($recommendations as $recommendation): ?>
    <li><a href="/s/<?= $recommendation->getShortLink() ?>"><?= $recommendation->getTitle() ?></a></li>
<?php endforeach; ?>
</ol>
