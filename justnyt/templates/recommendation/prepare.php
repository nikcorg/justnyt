<?php if (count($upcoming) > 0): ?>
    <h2>Julkaisujonossa</h2>
    <ol>
    <?php foreach ($upcoming as $recommendation): ?>
        <li>
            <?= $recommendation->getTitle() ?>
            (<?= $currentTime->diff($recommendation->getApprovedOn())->format("%R%h tuntia %i minuuttia") ?>)</li>
    <?php endforeach; ?>
    </ol>
<?php endif; ?>

<?php if (is_null($dupCheck)): ?>

<h2>Tarkista tiedot</h2>

<form method="post" action="/kuraattori/<?= $curator->getToken() ?>/suosittelut/<?= $candidateId ?>" data-candidate-id="<?= $candidateId ?>" id="preview-form">
    <div class="form-blocker hidden nomargin"></div>

    <p>Tarkista tiedot ennen tallentamista.</p>

    <p><label><span>URL</span>
        <input type="url" name="url" value="<?= $url ?>" required></label> (<a href="<?= $url ?>" target="_blank">Linkki</a>)</p>

    <p><label><span>Otsikko</span>
        <input type="text" name="title" value="<?= $title ?>" required></label></p>

    <p><label><span>Lainaus</span>
        <textarea name="quote" rows="5"><?= $quote ?></textarea></label></p>

    <p><label><span>Julkaisuun</span>
        <select name="delay">
            <?php foreach ($delays as $label => $delay): ?>
                <option value="<?= intval($delay->format("%h")) * 3600 ?>"><?= $label ?></option>
            <?php endforeach; ?>
        </select></label></p>

    <p><button type="submit" name="action" value="approve">Hyvältä näyttää, tällä mennään</button> <button type="submit" name="action" value="remove" class="cancel">Nyt tuli vikatikki, saa poistaa</button></p>
</form>

<?php else: ?>

<h2>Suositus törmäyskurssilla</h2>

<p>Harmi juttu, mutta suosittelemasi juttu löytyy jo listoilta.</p>
<p>Älä kuitenkaan lannistu, olet selvästikin oikeilla linjoilla.</p>

<?php endif; ?>
