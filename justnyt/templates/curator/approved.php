<p>Suluissa oleva luku on klikkausten lukumäärä.</p>

<ol reversed>

<?php while ($recommendation = $approved->fetch(\PDO::FETCH_OBJ)): ?>
    <li><a href="/s/<?= $recommendation->SHORTLINK ?>?notrack=1"><?= $recommendation->TITLE ?></a>
    (<?= $recommendation->CLICKS ?> klikkausta
    <?= $recommendation->VISITORS ?> kävijältä)</li>
<?php endwhile; ?>

</ol>
