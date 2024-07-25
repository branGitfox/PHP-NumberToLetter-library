<?php 

/**
 * Cette classe permet de convertir un nonbre en lettre (Francais pour le moment)
 * @author BranGitFox 
 * @var number input 
 * @return String
 */
class NumberInLetter {
        private $Pre = [
            0=>'zero',
            1=>'un',
            2=>'deux',
            3=>'trois',
            4=>'quatre',
            5=>'cinq',
            6=>'six',
            8=>'sept',
            9=>'neuf',
            10=>'dix',
            11=>'onze',
            12=>'douze',
            13=>'treize',
            14=>'quatorze',
            15=>'quinze',
            16=>'seize',
            17=>'dix-sept',
            18=>'dix-huit',
            19=>'dix-neuf',
        ];

        private $dizaine = [
            20=>'vingt', 
            30=>'trente',
             40=>'quarante', 
             50=>'cinquante', 
             60=>'soixante',
              70=>'soixante-dix', 
              80=>'quatre-vingt',
              90=>'quatre vingt-dix',            
        ];

        private $exceptionLettres = [
            
            1=>'onze',
            2=>'douze',
            3=>'treize',
            4=>'quatorze',
            5=>'quinze',
            6=>'seize',
            7=>'dix-sept',
            8=>'dix-huit',
            9=>'dix-neuf',
        ];

        private $centaine = 'cent';
        private $millaine = 'mille';
        private $million = 'million';
        private $milliard = 'milliard';
        private $exception = [71,72,73,74,75,76,77,78,79,91,92,93,94,95,96,97,98,99];

    private $number;

    public function __construct($number)
    {
        $this->number = $number;
    }


    public function numberToLetter(){
            if($this->number < 10){
                return $this->Pre[$this->number];
            }elseif($this->number >= 10 && $this->number < 20){

                return $this->Pre[$this->number];

            }elseif($this->number >= 20 && $this->number < 100){

               if($this->number % 10 == 0){
                    return $this->dizaine[$this->number];
               }else{
                   $diz =  $this->number - ($this->number % 10);
                   $idt = $this->dizaine[$diz];
                   $reste = $this->number % 10;
                   if(in_array($this->number, $this->exception)){
                    $diz =  $this->number - ($this->number % 10);
                    $idt = explode('-',$this->dizaine[$diz]);
                    $end = $idt[0];     
                    $reste = $this->number % 10;
                     return $end.' et '. $this->exceptionLettres[$reste];
                   }
                   return $idt.' et '. $this->Pre[$reste];
               }


            }elseif($this->number >= 100 && $this->number < 1000){

                if($this->number % 100 == 0){
                    $cent = $this->number - ($this->number % 100);
                    $prefix = $this->Pre[($cent / 100)];
                    return  ($prefix=='un' ? ' ': $prefix) .' '.$this->centaine;

                }else{

                    $cent = $this->number - ($this->number % 100);
                    $prefix = $this->Pre[($cent / 100)]; 
                    return($prefix=='un' ? ' ': $prefix).' '.$this->centaine.' '.$this->Pre[($this->number % 100)];
                }
           }
    }
}