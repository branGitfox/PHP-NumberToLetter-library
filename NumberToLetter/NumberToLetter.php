<?php

/**
 * Cette classe permet de convertir un nombre en lettres (Français et Anglais).
 * @author BranGitFox
 */
class NumberToLetter {
    protected $join = false;

    protected $Pre = [
        1 => 'un',
        2 => 'deux',
        3 => 'trois',
        4 => 'quatre',
        5 => 'cinq',
        6 => 'six',
        7 => 'sept',
        8 => 'huit',
        9 => 'neuf',
        10 => 'dix',
        11 => 'onze',
        12 => 'douze',
        13 => 'treize',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'seize',
        17 => 'dix-sept',
        18 => 'dix-huit',
        19 => 'dix-neuf'
    ];

    protected $dizaine = [
        20 => 'vingt',
        30 => 'trente',
        40 => 'quarante',
        50 => 'cinquante',
        60 => 'soixante',
        70 => 'soixante-dix',
        80 => 'quatre-vingts',
        90 => 'quatre-vingt-dix',
    ];

    protected $separator = ' et ';
    protected $exceptionLettres = [
        1 => 'onze',
        2 => 'douze',
        3 => 'treize',
        4 => 'quatorze',
        5 => 'quinze',
        6 => 'seize',
        7 => 'dix-sept',
        8 => 'dix-huit',
        9 => 'dix-neuf',
    ];

    protected $centaine = 'cent';
    protected $mille = 'mille';
    protected $million = 'million';
    protected $milliard = 'milliard';
    protected $exception = [71, 72, 73, 74, 75, 76, 77, 78, 79, 91, 92, 93, 94, 95, 96, 97, 98, 99];

    protected $number;

    public function __construct(int $number, string $lang = 'FR') {
        $this->number = $number;
        
        if ($lang == 'ENG') {
            $this->Pre = [
                0 => 'zero',
                1 => 'one',
                2 => 'two',
                3 => 'three',
                4 => 'four',
                5 => 'five',
                6 => 'six',
                7 => 'seven',
                8 => 'eight',
                9 => 'nine',
                10 => 'ten',
                11 => 'eleven',
                12 => 'twelve',
                13 => 'thirteen',
                14 => 'fourteen',
                15 => 'fifteen',
                16 => 'sixteen',
                17 => 'seventeen',
                18 => 'eighteen',
                19 => 'nineteen',
            ];
            $this->centaine = 'hundred';
            $this->mille = 'thousand';
            $this->million = 'million';
            $this->milliard = 'billion';

            $this->dizaine = [
                20 => 'twenty',
                30 => 'thirty',
                40 => 'forty',
                50 => 'fifty',
                60 => 'sixty',
                70 => 'seventy',
                80 => 'eighty',
                90 => 'ninety',
            ];

            $this->separator = ' and ';
        }
    }

    /**
     * Retourne le nombre passé dans le constructeur en lettres.
     * @return string
     */
    public function numberToLetter(): string {
        if ($this->number < 10) {
            return $this->unite($this->number);
        } elseif ($this->number < 20) {
            return $this->Pre[$this->number];
        } elseif ($this->number < 100) {
            return $this->dizaine($this->number);
        } elseif ($this->number < 1000) {
            return $this->centaine($this->number);
        } elseif ($this->number < 1000000) {
            return $this->milleToMillion($this->number);
        } elseif ($this->number < 1000000000) {
            return $this->millionToMilliard($this->number);
        } else {
            return $this->milliardToTrillion($this->number);
        }
    }

    /**
     * Gère les dizaines (0 à 99).
     * @param int $number
     * @return string
     */
    protected function dizaine(int $number): string {
        if ($number % 10 == 0) {
            return $this->dizaine[$number];
        } elseif (in_array($number, $this->exception)) {
            return $this->handleException($number);
        } else {
            $diz = $number - ($number % 10);
            $unit = $number % 10;
            return $this->dizaine[$diz] . ' ' . $this->Pre[$unit];
        }
    }

    /**
     * Gère les centaines (100 à 999).
     * @param int $number
     * @return string
     */
    protected function centaine(int $number): string {
        $prefix = intdiv($number, 100);
        $remainder = $number % 100;
        $prefixString = $prefix > 1 ? $this->Pre[$prefix] . ' ' . $this->centaine : $this->centaine;

        if ($remainder == 0) {
            return $prefixString;
        }

        return $prefixString . ' ' . $this->dizaine($remainder);
    }

    /**
     * Gère les nombres de mille à million (1000 à 999999).
     * @param int $number
     * @return string
     */
    protected function milleToMillion(int $number): string {
        if ($number < 2000) {
            return $this->mille . ' ' . $this->centaine($number % 1000);
        }

        return $this->centaine(intdiv($number, 1000)) . ' ' . $this->mille . ' ' . $this->centaine($number % 1000);
    }

    /**
     * Gère les nombres de million à milliard (1000000 à 999999999).
     * @param int $number
     * @return string
     */
    protected function millionToMilliard(int $number): string {
        $millions = intdiv($number, 1000000);
        $thousands = intdiv($number % 1000000, 1000);
        $remainder = $number % 1000;

        return $this->centaine($millions) . ' ' . $this->million . ' ' .
            $this->centaine($thousands) . ' ' . $this->mille . ' ' .
            $this->centaine($remainder);
    }

    /**
     * Gère les nombres de milliard à trillion (1000000000 à 999999999999).
     * @param int $number
     * @return string
     */
    protected function milliardToTrillion(int $number): string {
        $milliards = intdiv($number, 1000000000);
        $millions = intdiv($number % 1000000000, 1000000);
        $thousands = intdiv($number % 1000000, 1000);
        $remainder = $number % 1000;

        return $this->centaine($milliards) . ' ' . $this->milliard . ' ' .
            $this->centaine($millions) . ' ' . $this->million . ' ' .
            $this->centaine($thousands) . ' ' . $this->mille . ' ' .
            $this->centaine($remainder);
    }

    /**
     * Récupère l'unité du nombre passé en paramètre.
     * @param int $number
     * @return string
     */
    private function unite(int $number): string {
        return $this->Pre[$number];
    }

    /**
     * Gère les exceptions pour les dizaines spéciales.
     * @param int $number
     * @return string
     */
    private function handleException(int $number): string {
        $pair = $number - $number % 10;
        $reste = $number % 10;
        return $this->dizaine[$pair] . ' ' . $this->exceptionLettres[$reste];
    }

    /**
     * Teste la conversion de nombres en lettres sur une plage donnée.
     * @param int $from
     * @param int $to
     * @param string $lang
     */
    public static function makeTest(int $from, int $to, string $lang): void {
        try {
            while ($from <= $to) {
                $n = new NumberToLetter($from, $lang);
                echo $from . ' = ' . $n->numberToLetter() . PHP_EOL;
                $from++;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}


