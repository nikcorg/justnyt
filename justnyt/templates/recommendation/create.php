<form method="get" action="/kuraattori/<?= $curator->getToken() ?>/esikatsele">
    <p><label><span>URL-osoite</span>
        <input type="url" name="url" value="" placeholder="suositeltavan sisällön osoite tähän" required/></label></p>
    <p><button type="submit">Suosittele</button></p>
</form>
