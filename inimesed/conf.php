<?php
//AB kasutaja, serverrinimi, salasõna, AB nimi -> ühendame seda andtud väärtusega, lisame tähte koodering
$kasutaja = 'tarpv22';
$serverinimi = 'localhost';
$parool = '123456';
$andmebaas = 'inimesed';
$yhendus = new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus -> set_charset('UTF8');
?>