<p>Suluissa oleva luku on klikkausten lukumäärä.</p>

<ol>

<?php foreach ($approved as $recommendation): ?>
    <li><a href="<?= $recommendation->getUrl() ?>"><?= $recommendation->getTitle() ?></a> (<?= $recommendation->getVisits() ?>)</li>
<?php endforeach; ?>

</ol>
