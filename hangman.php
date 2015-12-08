<?php

class Hangman {

	CONST MAX_ATTEMPTS = 10;
	private $word;
	private $good_letters = [];
	private $bad_letters = [];
	private $hangman = "___________
						    |/     |
						    |     (o)
						    |     \|/
						    |      |
						    |     / \
						    |
						 ___|___";

	public function __construct() {
		$this->word = strtolower(file_get_contents('http://randomword.setgetgo.com/get.php?len=8'));
		$this->letters = str_split($this->word);
	}

	public function readInput() {
		if (empty($this->good_letters) && empty($this->bad_letters)) {
			print_r("\n" . $this->showString() . " " . count($this->letters) . " letters");
		}
		print_r("\nType a letter: ");
		$input = readline();
		$this->updateState($input);
		$this->readInput();
	}

	public function updateState($input) {
		if ((in_array($input, $this->good_letters)) || (in_array($input, $this->bad_letters))) {
			array_push($this->bad_letters, $input);
			print_r("You already selected that!\n");
 		} elseif (in_array($input, $this->letters)) {
 			array_push($this->good_letters, $input);
			print_r("You got one! ");
		} else {
			array_push($this->bad_letters, $input);
			print_r("Womp womp. ");
		}

		if (count($this->bad_letters) !== 0) {
			print_r("Tried letters: (" . join(", " , $this->bad_letters) . ")\n");
		}

		$string = $this->showString();
		$this->updateAttempts($string);
		print_r($string . "\n");
	}

	public function updateAttempts($string) {
		if (count($this->bad_letters) < self::MAX_ATTEMPTS) {
			print_r("You have " . ((self::MAX_ATTEMPTS) - count($this->bad_letters)) . " guesses left\n\n");
		} else {
			print_r("You have 0 attempts left. Game over. The word was " . $this->word . ".\n");
			exit(0);
		}
	}

	public function showString() {
		$string = '';
		foreach ($this->letters as $letter) {
			if (in_array($letter, $this->good_letters)) {
				$string .= $letter;
			} else {
				$string .= "_";
			}
		}
		if (strpos($string, "_") === false) {
			print_r("You have won hangman with word. " . $this->word . ". Game over.\n");
			exit(0);
		}
		return $string;
	}
}

$hangman  = new Hangman();
$hangman->readInput();


