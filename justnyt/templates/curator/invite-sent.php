<p>Seuraava kuraattori on nyt kutsuttu palvelukseen. Voit kuitenkin rauhassa jatkaa kuraattorin tehtäviäsi siihen asti, että seuraajasi aktivoi oman tilinsä. Mikäli olet lisännyt <a href="/kuraattori/<?= $curator->getToken() ?>/profiili">profiiliisi</a> sähköpostiosoitteesi, saat ilmoituksen kun oma tilisi sulkeutuu.</p>

<form action="" method="post">
    <p>Mikäli tuntuu, että seuraajallasi kestää turhan pitkään aloittaa oma kautensa voit perua kutsun. Aikaisintaan kuitenkin <?= $graceUntil->format("j.m.Y H:i") ?>.</p>

    <?php if ($graceElapsed): ?>
        <p><button type="submit" name="action" value="redact-invite" class="cancel w100">Peru kutsu</button></p>
    <?php endif; ?>
</form>
