<?php
$debut = microtime(true);

for ($i=0; $i < 1000; $i++) {
    echo 'Hello world';
}
echo "<br/>";
$fin = microtime(true);

$delai = $fin - $debut;

echo 'Temps ecoule: ' . $delai . ' millisecondes.';