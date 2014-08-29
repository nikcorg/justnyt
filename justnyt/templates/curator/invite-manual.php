<p>Lähetä alla oleva linkki seuraajallesi. Voit rauhassa jatkaa kuraattorin tehtäviäsi siihen asti, että seuraajasi aktivoi oman tilinsä. Mikäli olet lisännyt profiiliisi sähköpostiosoitteesi, saat ilmoituksen kun oma tilisi sulkeutuu.</p>

<form method="post" action="">
    <p><label><span>Aktivointilinkki</span>
        <input type="text" value="<?= $activationUrl ?>"/></label></p>

    <p><button type="submit" name="action" value="redact-invite" class="cancel w100">Peru kutsu</button></p>
</form>
