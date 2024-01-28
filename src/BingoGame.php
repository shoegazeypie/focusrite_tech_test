<?php
  namespace FocusriteTechTest;
  /**
   * Bingo Game class to run against multiple cards.
   */
  class BingoGame
  {
    /**
     * @var array|null Bingo cards being played.
     */
    protected $cards;
    /**
     * @var string[]|null The numbers called in the game.
     */
    protected $called_numbers;


    /**
     * The class constructor.
     * @param string $cards_directory The directory of card files.
     * @param string $called_numbers_file The file containing the called numbers.
     */
    public function __construct($cards_directory, $called_numbers_file) {
      $this->cards = self::_readCards($cards_directory);
      $this->called_numbers = self::_readNumbers($called_numbers_file);
    }

    /**
     * Read card files and create BingoCards.
     * @param string $directory The directory of card files.
     * @return array|void Array of cards in the game.
     */
    protected function _readCards($directory) {
      $cards = [];
      foreach (scandir($directory) as $filename) {
        if ($filename != '.' && $filename != '..') {
          $card_numbers = [];
          $card_file = fopen("$directory/$filename", "r") or die("Unable to open file!");
          while (!feof($card_file)) {
            $card_line = fgets($card_file);
            $card_numbers[] = explode(' ', $card_line);
          }
          fclose($card_file);
          $cards[] = new BingoCard($card_numbers, $filename);
        }
      }
      return $cards;
    }

    /**
     * Read called numbers from file.
     * @param string $file_path The file path to read.
     * @return false|string[]|void The numbers called in the game.
     */
    protected function _readNumbers($file_path) {
      $file = fopen($file_path, "r") or die("Unable to open file!");
      $line_numbers = fgets($file);
      $called_numbers = explode(',', $line_numbers);
      fclose($file);
      return $called_numbers;
    }

    /**
     * Check the cards get bingo in this game.
     * @return array Whether each named card gets bingo keyed by card name.
     */
    public function validateCards() {
      $bingos = [];
      foreach ($this->cards as $card) {
        $bingos[$card->getName()] = $card->checkBingo($this->called_numbers);
      }
      return $bingos;
    }


    /**
     * Determine which card will win the game.
     * @return string The name of the card with the first bingo in game.
     */
    public function winningCard() {
      // An array of first bingos keyed by card name.
      $first_bingos = [];
      foreach ($this->cards as $card) {
        if (($first_bingo = $card->firstBingo($this->called_numbers)) !== false) {
          $first_bingos[$card->getName()] = $first_bingo;
        }
        // Return the key of the first bingo in the list.
        return array_search(min($first_bingos), $first_bingos);
      }
    }
  }