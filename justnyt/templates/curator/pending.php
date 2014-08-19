<p>Julkaisuun menossa olevat suositukset</p>

<ol>
<?php foreach ($upcoming as $recommendation): ?>
    <li>
        <a href="/s/<?= $recommendation->getShortlink() ?>?notrack=1"><?= $recommendation->getTitle() ?></a>
        (<?= $currentTime->diff($recommendation->getApprovedOn())->format("%R%h tuntia %i minuuttia") ?>)</li>
<?php endforeach; ?>
</ol>
