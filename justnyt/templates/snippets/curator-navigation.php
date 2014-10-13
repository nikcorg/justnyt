<nav>
<ul>
    <li><a href="/kuraattori/<?= $curator->getToken() ?>/tervetuloa">Tervetuloa</a></li>
    <li><a href="/kuraattori/<?= $curator->getToken() ?>/profiili">Muokkaa profiiliasi</a></li>
    <li><a href="/kuraattori/<?= $curator->getToken() ?>/seuraava">Kutsu seuraava kuraattori</a></li>
    <?php if (isset($hints) && $hints > 0): ?>
        <li><a href="/kuraattori/<?= $curator->getToken() ?>/vinkatut">Ilmiannot <span class="blurb"><?= $hints ?></span></a></li>
    <?php endif; ?>
    <?php if (isset($pending) && $pending > 0): ?>
        <li><a href="/kuraattori/<?= $curator->getToken() ?>/jonossa">Julkaisujono <span class="blurb"><?= $pending ?></span></a></li>
    <?php endif; ?>
    <li><a href="/kuraattori/<?= $curator->getToken() ?>/julkaistut">Julkaistut</a></li>
</ul>
</nav>
