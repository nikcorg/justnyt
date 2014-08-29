<p>Voit halutessasi valita seuraajasi itse, tai voit kutsua seuraavan vapaaehtoisen, mikäli jono ei ole tyhjä.</p>
<form action="" method="post">
    <div class="form-blocker hidden nomargin"></div>

    <p><button type="submit" name="action" value="manual-invite" class="w100">Kutsun seuraajani itse</button></p>

    <?php if ($volunteers): ?>
        <p><button type="submit" name="action" value="next-in-queue" class="w100">Lähetä kutsu seuraavalle jonottajalle</button></p>
    <?php else: ?>
        <p>Valitettavasti ei tällä hetkellä ole yhtään vapaaehtoista jonossa. Ellet keksi ketä kutsuisit, ota yhteyttä ylläpitoon osoitteessa <a href="mailto:justnytfi+apua@gmail.com">justnytfi+apua@gmail.com</a>.</p>
    <?php endif; ?>
</form>
