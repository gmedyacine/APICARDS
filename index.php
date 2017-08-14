<?php

echo "step 1: creation d'appel <br>";
$apiCards=new TriCards();

echo "step2: recuperer les cards <br>";
$apicards->getCards();

echo "step3: trier les cartes <br>";
$apicards->excuteSortCards();

echo "step4: envoyer les cartes triées <br>";
$apicards->postSortedCards();




