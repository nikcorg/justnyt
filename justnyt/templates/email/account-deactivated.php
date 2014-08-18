Hei,

Seuraava kuraattori on aktivoinut tilinsä ja kuraattorikautesi on nyt päättynyt.
Jätä nimesi jonoon, kun kaipaat kuraattorinhattua jälleen päätäsi koristamaan.

Alla vielä julkaisemasi suositukset kävijämäärineen.

<?php while ($recommendation = $approved->fetch(\PDO::FETCH_OBJ)): ?>
    <?= $recommendation->TITLE ?>
    <?= $recommendation->URL ?>
    <?= $recommendation->CLICKS ?> klikkausta <?= $recommendation->VISITORS ?> kävijältä
<?php endwhile; ?>

Kiitos ajastasi.


Terveisin

JustNyt
--
http://justnyt.fi
