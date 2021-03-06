<p>Profiilin luominen on täysin vapaaehtoista, mutta edes nimimerkin täyttäminen suositeltavaa. Profiilin tiedot näytetään <a href="/kuraattorit">Kuraattorit-listassa</a>.</p>

<form action="/kuraattori/<?= $curator->getToken() ?>/profiili" method="post" id="profile-form">
    <div class="form-blocker hidden nomargin"></div>
    <div class="error-container hidden"></div>

    <p><label><span>Sähköpostiosoitteesi</span>
        <input type="email" name="email" maxlength="255" value="<?= $email ?>" placeholder="sinun.oma@osoitteesi.fi"></label> (<a href="/email-info" target="_blank">Mihin osoitettani käytetään?</a>)</p>

    <p><label><span>Nimimerkki tai oma nimesi</span>
        <input type="text" name="alias" maxlength="80" value="<?= $alias ?>"></label></p>

    <p><label><span>Nettiosoitteesi</span>
        <input type="url" name="homepage" maxlength="255" value="<?= $homepage ?>" placeholder="Blogisi, Twitterisi tms"></label></p>

    <p><label><span>Kuvausteksti</span>
        <textarea name="description" rows="8"><?= $description ?></textarea></label>

    <p><button type="submit">Tallenna profiili</button></p>
</form>
