<?php
namespace APICARDS;

require 'TriCards.php';

echo "step 1: creation d'appel <br>";
$apiCards=new TriCards();

echo "step 2: recuperer les cards  non triées <br>";
$cards=$apiCards->getCards();
var_dump($cards); echo "<br>";

echo "step 3: trier les cartes cartes <br>";
$oderCards=$apiCards->excuteSortCards($cards);
var_dump($oderCards); echo "<br>";

echo "step 4: envoyer les cartes triées <br>";
$apiCards->postSortedCards($oderCards);






