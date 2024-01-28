<?php
  namespace FocusriteTechTest;

  require __DIR__ . '/../vendor/autoload.php';

  // Set up a game with a single card to check if it gets a bingo.
  $game1 = new BingoGame('data/part1cards', 'data/called_numbers.txt');
  foreach($game1->validateCards() as $card => $bingo){
    echo $card;
    echo ($bingo) ? " does " : " does not ";
    echo "get bingo.\n";
  }

  // Get the winning card in a game with 3 cards.
  $game2 = new BingoGame('data/part2cards', 'data/called_numbers.txt');
  echo $game2->winningCard() . " will win the game.\n";
