Hei,

Seuraava kuraattori on aktivoinut tilinsä ja kuraattorikautesi on nyt päättynyt.
Jätä nimesi jonoon, kun kaipaat kuraattorinhattua jälleen päätäsi koristamaan.

Alla vielä julkaisemasi suositukset kävijämäärineen.

<?php while ($recommendation = $approved->fetch(\PDO::FETCH_OBJ)): ?>

<?= $recommendation->TITLE . PHP_EOL ?>
<?= $recommendation->URL . PHP_EOL  ?>
<?= $recommendation->CLICKS ?> klikkausta <?= $recommendation->VISITORS ?> kävijältä <?= PHP_EOL . PHP_EOL  ?>

<?php endwhile; ?>

Kiitos ajastasi.


Terveisin

JustNyt
--
https://justnyt.fi
