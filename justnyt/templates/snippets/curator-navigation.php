<nav>
<ul>
    <li><a href="/kuraattori/<?= $token ?>/tervetuloa">Tervetuloa</a></li>
    <li><a href="/kuraattori/<?= $token ?>/profiili">Muokkaa profiiliasi</a></li>
    <li><a href="/kuraattori/<?= $token ?>/seuraava">Kutsu seuraava kuraattori</a></li>
    <?php if (isset($pending)): ?>
        <li><a href="/kuraattori/<?= $token ?>/jonossa">Julkaisujono <span class="blurb"><?= $pending ?></span></a></li>
    <?php endif; ?>
</ul>
</nav>
