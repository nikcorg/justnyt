<p>Julkaisuun menossa olevat suositukset</p>

<ol>
<?php foreach ($upcoming as $recommendation): ?>
    <li>
        <a href="<?= $recommendation->getUrl() ?>"><?= $recommendation->getTitle() ?></a>
        (<?= $currentTime->diff($recommendation->getApprovedOn())->format("%R%h tuntia %i minuuttia") ?>)</li>
<?php endforeach; ?>
</ol>
