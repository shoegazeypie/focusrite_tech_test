<?php
  namespace FocusriteTechTest;

  /**
   * A single bingo card.
   */
  class BingoCard {
    /**
     * @var array Multidimensional array of card numbers.
     */
    protected $card_numbers = [];
    /**
     * The max length of the card numbers (assuming a square card).
     */
    const MAX_DIMENSION = 5;

    /**
     * @var string A name to identify the card.
     */
    protected $name;

    /**
     * Return the card name.
     * @return string
     */
    public function getName() {
      return $this->name;
    }

    /**
     * The class construct.
     * @param array $card_numbers The multidimensional card array.
     * @param string $name An identifying name.
     */
    public function __construct(array $card_numbers, $name) {
      $this->card_numbers = $card_numbers;
      $this->name = $name;
    }

    /**
     * Return the position in the called numbers list of a given position on the card or false.
     * @param int $row Row position on the card.
     * @param int $col Col position on the card.
     * @param array $called_numbers The ordered numbers called by the bingo caller.
     * @return false|int The position in the called numbers or false if not called.
     */
    protected function _checkNumberCalled($row, $col, $called_numbers) {
      $target = $this->card_numbers[$row][$col];
      return array_search($target, $called_numbers);
    }

    /**
     * Create an array showing positions of all card numbers in the called numbers.
     * @param array $called_numbers The ordered numbers called by the bingo caller.
     * @return mixed An array of called number positions.
     */
    protected function _createIndexCard($called_numbers) {
      // get index of each number in called number array.
      for ($r = 0; $r < self::MAX_DIMENSION; $r++) {
        for ($c = 0; $c < self::MAX_DIMENSION; $c++) {
          $index_card[$r][$c] = self::_checkNumberCalled($r, $c, $called_numbers);
        }
      }
      return $index_card;
    }

    /**
     * Return whether a card will ever get a bingo.
     * @param array $called_numbers The ordered numbers called by the bingo caller.
     * @return bool Whether the board will get bingo with the called numbers.
     */
    public function checkBingo($called_numbers) {
      $index_card = self::_createIndexCard($called_numbers);
      // Check rows and columns assuming it's square
      for ($index = 0; $index < self::MAX_DIMENSION; $index++) {
        $row = $index_card[$index];
        $column = array_column($index_card, $index);
        if (!in_array(false, $row, true)) {
          // Bingo!
          return true;
        }
        if (!in_array(false, $column, true)) {
          // Bingo!
          return true;
        }
      }
      // If we get here we've never got bingo.
      return false;
    }

    /**
     * Return the number of called numbers before the card first gets bingo.
     * @param array $called_numbers The ordered numbers called by the bingo caller.
     * @return false|int Position of the called number that will give the earliest bingo on the card
     *  or false if no bingo.
     */
    public function firstBingo($called_numbers) {
      $index_card = self::_createIndexCard($called_numbers);
      $last_called = [];
      // Check rows and columns assuming it's square
      for ($index = 0; $index < self::MAX_DIMENSION; $index++) {
        $row = $index_card[$index];
        $column = array_column($index_card, $index);
        if (!in_array(false, $row, true)) {
          $last_called[] = max($row);
        }
        if (!in_array(false, $column, true)) {
          $last_called[] = max($column);
        }
      }

      return ($last_called) ? min($last_called) : false;
    }
  }