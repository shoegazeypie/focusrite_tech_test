<?php
  use FocusriteTechTest\BingoCard;
  use PHPUnit\Framework\TestCase;

  /**
   * BingoCard tests.
   */
  class BingoCardTest extends TestCase
  {

    /**
     * Utility method to setup a dummy card.
     * @return BingoCard
     */
    protected function createCard() {
      $numbers = [
        [0, 1, 2, 3, 4,],
        [5, 6, 7, 8, 9,],
        [10, 11, 12, 13, 14,],
        [15, 16, 17, 18, 19,],
        [20, 21, 22, 23, 24,],
      ];
      return new BingoCard($numbers, 'name.txt');
    }

    /**
     * @covers \FocusriteTechTest\BingoCard::getName
     */
    public function testGetName() {
      $bingo_card = self::createCard();
      $this->assertSame('name.txt', $bingo_card->getName());
    }

    /**
     * @covers \FocusriteTechTest\BingoCard::checkBingo
     */
    public function testCheckBingo() {
      $bingo_card = self::createCard();
      $called_numbers = [5, 8, 11, 7, 9, 6, 1, 2, 3, 4, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 0];

      $this->assertTrue($bingo_card->checkBingo($called_numbers));
    }

    /**
     * @covers \FocusriteTechTest\BingoCard::firstBingo
     */
    public function testFirstBingo() {
      $bingo_card = self::createCard();
      $called_numbers = [5, 8, 11, 7, 9, 6, 1, 2, 3, 4, 10, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 0];

      $this->assertSame(5, $bingo_card->firstBingo($called_numbers));
    }

  }
