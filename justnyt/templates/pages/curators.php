<p>Tästä listasta näet kuraattorit, jotka eivät halua esiintyä nimettöminä.</p>

<ol desc>
<?php foreach ($curators as $curator): ?>
    <?php $profile = $curator->getProfile(); ?>
    <li>
    <?php if (! empty($profile->getHomepage())): ?>
        <a href="<?= $profile->getHomepage() ?>" rel="nofollow"><?= $profile->getAlias() ?></a></li>
    <?php else: ?>
        <?= $profile->getAlias() ?>
    <?php endif; ?>

<?php endforeach; ?>
</ol>
