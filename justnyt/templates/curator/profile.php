<p>Profiilin luominen on täysin vapaaehtoista, mutta edes nimimerkin täyttäminen suositeltavaa. Profiilin tiedot näytetään <a href="/kuraattorit">Kuraattorien historiaa-listassa</a>.</p>

<form action="/kuraattori/<?= $token ?>/profiili" method="post">
    <div class="form-blocker hidden nomargin"></div>

    <p><label><span>Nimimerkki tai oma nimesi</span>
        <input type="text" name="alias" value="<?= $alias ?>"></label></p>

    <p><label><span>Nettiosoitteesi</span>
        <input type="url" name="homepage" value="<?= $homepage ?>"></label></p>

    <p><label><span>Kuvausteksti</span>
        <textarea name="description" rows="8"><?= $description ?></textarea></label>

    <p><button type="submit">Tallenna profiili</button></p>
</form>
