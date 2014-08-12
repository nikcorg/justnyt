<?php $this->snippet("curator/navigation") ?>

<p>Lähetä alle oleva linkki seuraajallesi, tai seuravalle jonossa olevalle vapaaehtoiselle.</p>

<form action="" method="post">
    <div class="form-blocker hidden nomargin"></div>

    <p><label><span>Aktivointiosoite</span>
        <input type="url" name="url" value="<?= $activationUrl ?>"></label></p>

    <?php if ($mailSent): ?>
        <p>Viesti lähetettiin seuraavalle vapaaehtoiselle.</p>
    <?php elseif ($volunteers): ?>
        <button type="submit" name="volunteer" value="0" class="hidden">Lähetän koodin itse</button>
        <p><button type="submit" name="volunteer" value="1">Lähetä seuraavalle jonottajalle</button></p>
    <?php else: ?>
        <p>Valitettavasti ei tällä hetkellä ole yhtään vapaaehtoista jonossa. Ellet keksi ketä kutsuisit, ota yhteyttä ylläpitoon osoitteessa <a href="mailto:justnytfi+apua@gmail.com">justnytfi+apua@gmail.com</a>.</p>
    <?php endif; ?>
</form>
