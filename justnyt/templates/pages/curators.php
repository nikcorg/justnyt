<p>Tästä listasta näet kuraattorit, jotka eivät halua esiintyä nimettöminä.</p>

<ol reversed class="collapsed">
<?php foreach ($curators as $curator): ?>
    <?php $profile = $curator->getProfile(); ?>
    <li><a href="/profiilit/<?= $curator->getCuratorId() ?>-<?= $profile->getProfileId() ?>/<?= \glue\utils\StringInflector::factory($profile->getAlias())->slug() ?>" rel="nofollow"><?= $profile->getAlias() ?></a></li>
<?php endforeach; ?>
</ol>
