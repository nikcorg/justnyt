<p>Menneitä suosituksia.</p>

<ol reversed>
<?php foreach ($recommendations as $recommendation): ?>
    <li><a href="<?php echo $recommendation->getUrl() ?>"><?= $recommendation->getTitle() ?></a></li>
<?php endforeach; ?>
</ol>
