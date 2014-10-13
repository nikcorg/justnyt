<?php if ($hints->count() < 1): ?>

    <p>Ei vinkkejä tällä hetkellä.</p>

<?php else: ?>

    <p>Alla kävijöiltä tulleita ilmiantoja. Suluissa vinkkauspäivämäärä. Klikkaa linkin viereistä Poimi-linkkiä, viedäksesi vinkki suositukseksi.</p>

    <ul>
    <?php foreach ($hints as $hint): ?>
        <li>
            <a href="/referral-cloak?to=<?= urlencode($hint->getUrl()) ?>"><?= $hint->getUrl() ?></a> (<?= $hint->getCreatedOn()->format("j.m.Y") ?>)
            <a href="/kuraattori/<?= $curator->getToken() ?>/esikatsele?fromHint=<?= $hint->getRecommendationHintId() ?>">Poimi</a>
            <a href="/kuraattori/<?= $curator->getToken() ?>/hints/<?= $hint->getRecommendationHintId() ?>" data-action="delete">Hylkää</a>
        </li>
    <?php endforeach; ?>
    </ul>

<?php endif; ?>
