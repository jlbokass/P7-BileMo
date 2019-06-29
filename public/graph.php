<?php
$debut = microtime(true);

for ($i=0; $i < 10; $i++) {
    echo 'Hello world';
}

$fin = microtime(true);

$delai = $fin - $debut;

echo 'Temps ecloue: ' . $delai . 'millisecondes.';