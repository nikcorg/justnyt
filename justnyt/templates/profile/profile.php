<?php if (null != $profile->getEmail() || null != $profile->getHomepage()): ?>
<div class="right centered mugshot">
    <?php if (null != $profile->getEmail()): ?>
        <p><img class="gravatar" src="http://www.gravatar.com/avatar/<?= md5($profile->getEmail()) ?>?s=150"></p>
    <?php endif; ?>

    <?php if (null != $profile->getHomepage()): ?>
        <p><a href="<?= $profile->getHomepage() ?>"><?= preg_replace("/^https?:\/\//", "", $profile->getHomepage()) ?></a></p>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if (null != $profile->getDescription()): ?>
    <p><?= $profile->getDescription() ?></p>
<?php endif; ?>

<h2>Suositukset</h2>

<?php if (is_null($profiles)): ?>

<p><?= $sessionBegin->format("j.n.Y H:i") ?>&ndash;<?= is_null($sessionEnd) ? "" : $sessionEnd->format("j.n.Y H:i") ?></p>

<ol>
<?php foreach ($recommendations as $recommendation): ?>
    <li><a href="/s/<?= $recommendation->getShortlink() ?>"><?= $recommendation->getTitle() ?></a></li>
<?php endforeach; ?>
</ol>

<?php else: ?>

<?php foreach ($profiles as $profile): ?>
    <?php
    $begin = $profile->getCurators()[0]->getActivatedOn();
    $end = $profile->getCurators()[0]->getDeactivatedOn();
    ?>
    <p><?= $begin->format("j.n.Y H:i") ?>&ndash;<?= is_null($end) ? "" : $end->format("j.n.Y H:i") ?></p>
    <ol>
    <?php foreach ($profile->getCurators()[0]->getRecommendations() as $recommendation): ?>
        <li><a href="/s/<?= $recommendation->getShortlink() ?>"><?= $recommendation->getTitle() ?></a></li>
    <?php endforeach; ?>
    </ol>
<?php endforeach; ?>

<?php endif; ?>
