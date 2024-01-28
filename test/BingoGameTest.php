<?php
  use FocusriteTechTest\BingoGame;
  use PHPUnit\Framework\TestCase;

  class BingoGameTest extends TestCase
  {

    /**
     * @covers \FocusriteTechTest\BingoGame::validateCards
     */
    public function testValidateCards() {
      $game = new BingoGame('test/test_data/cards', 'test/test_data/called_numbers.txt');
      $bingos = $game->validateCards();
      $expected = [
        'testcard1.txt' => true,
        'testcard2.txt' => false,
        'testcard3.txt' => true,
      ];
      $this->assertSame($expected, $bingos);
    }

    /**
     * @covers \FocusriteTechTest\BingoGame::winningCard
     */
    public function testWinningCard() {
      $game = new BingoGame('test/test_data/cards', 'test/test_data/called_numbers.txt');
      $winner = $game->winningCard();
      $this->assertSame('testcard1.txt', $winner);
    }
  }
