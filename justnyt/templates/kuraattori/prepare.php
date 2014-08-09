<form method="post" action="kuraattori/<?= $token ?>/approve/<?= $candidateId ?>">
    <div class="form-blocker hidden nomargin"></div>

    <p>Tarkista tiedot ennen tallentamista. Suositus aktivoituu välittömästi tallentamisen jälkeen.</p>

    <p><label><span>URL</span>
        <input type="url" name="url" value="<?= $url ?>" required></label> (<a href="<?= $url ?>" target="_blank">Linkki</a>)</p>

    <p><label><span>Otsikko</span>
        <input type="text" name="title" value="<?= $title ?>"></label></p>

    <p><button type="submit">Tallenna</button></p>
</form>
