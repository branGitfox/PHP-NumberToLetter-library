<?php 

/**
 * Cette classe permet de convertir un nombre en lettre (Francais pour le moment)
 * @author BranGitFox 
 * @var number input 
 * @return String
 */
class NumberToLetter {
        protected $Pre = [
            0=>'zero',
            1=>'un',
            2=>'deux',
            3=>'trois',
            4=>'quatre',
            5=>'cinq',
            6=>'six',
            7=>'sept',
            8=>'huit',
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

        protected $dizaine = [
            20=>'vingt', 
            30=>'trente',
             40=>'quarante', 
             50=>'cinquante', 
             60=>'soixante',
              70=>'soixante-dix', 
              80=>'quatre-vingt',
              90=>'quatre vingt-dix',            
        ];

        protected $exceptionLettres = [
            
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

        protected $centaine = 'cent';
        protected $millaine = 'mille';
        protected $million = 'million';
        protected $milliard = 'milliard';
        protected $exception = [71,72,73,74,75,76,77,78,79,91,92,93,94,95,96,97,98,99];

  protected $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    /** 
     * Retourne le nombre passer dans le constructeur en lettre
     * @param void
     * @return String
     */


    public function numberToLetter(){
            if($this->number < 10){
                return $this->unite($this->number);
            }elseif($this->number >= 10 && $this->number < 20){
                    return $this->Pre[$this->number];
            }elseif($this->number >= 20 && $this->number < 100){
               return $this->dizaine($this->number);
            }elseif($this->number >= 100 && $this->number < 1000){
                return $this->centaine($this->number % 1000);              
           }elseif($this->number >= 1000 && $this->number < 1000000){
                if($this->number < 2000)return $this->millaine.' '.$this->diz_aine($this->number % 1000);
            return $this->centaine($this->number / 1000).' '.$this->millaine.' '.$this->diz_aine($this->number % 1000);
            }elseif($this->number >= 1000000 && $this->number < 1000000000){
                return $this->centaine($this->number / 1000000).' '.
                $this->million.' '.$this->centaine($this->number % 1000000 / 1000).' '.$this->millaine.' '.$this->centaine($this->number % 1000000 %1000);  
            }else{
                return $this->centaine($this->number / 1000000000).' '.
                $this->milliard.' '.$this->centaine($this->number % 1000000000 / 1000000).' '.$this->million.' '.$this->centaine($this->number % 1000000000 % 1000000).' '.$this->millaine;
            }
}

/**
 * function qui va gerer les nombres de zero à 99
 * @param void 
 * @return String
 */
    protected function dizaine($number):string
    {
        if($number % 10 == 0){
        
            return $this->dizaine[$number];
       }else{
           $diz =  $number - ($number % 10);
           @$idt = $this->dizaine[$diz];
           $reste = $number % 10;
           if(in_array($number, $this->exception)){
            $diz =  $number - ($this->number % 10);
            @$idt = explode('-',$this->dizaine[$diz]);
            @$end = $idt[0];     
            $reste = $number % 10;
             return $end.' et '. $this->exceptionLettres[$reste];
           }
           return $idt.' et '. $this->Pre[$reste];
       }
    }

    /**
 * function qui va gerer les nombres de 100 à 999
 * @param number 
 * @return String
 */
    protected function centaine(int $number)
    {
       if($number % 100 == 0){
            $prefix = $number / 100;
            if($prefix < 10){
                return ($prefix < 2?'': $this->Pre[$prefix]).' '.$this->centaine;
            }
       }else{
            $prefix = $number / 100;
            
                return ($prefix < 2 ? '': $this->Pre[$prefix]).' '.($prefix< 1?'':$this->centaine).' '.$this->diz_aine($number % 100);
            
       }
    }

    /**
     * Recupere l'unite du nombre passer en parametre
     * @return String
     */

    private function unite(int $number){
        return @$this->Pre[$number];
    }

    /**
     * function qui va gerer le nombre de 20 à 99
     * @return String
     */
    
     private function diz_aine(int $number){
        if(in_array($number, $this->exception)){
            $pair = $number - $number % 10;
            $first = explode('-', $this->dizaine[$pair])[0];
            $reste = $number %10;
            return $first.' '.$this->exceptionLettres[$reste];

        }else{
            if($number < 20 ){
                return ($this->Pre[$number] =='zero' ?'':$this->Pre[$number]);
            }else{
                
               $pair = $number - $number % 10;
                $reste = $number % 10;
               if($pair < 100){
                   return $this->dizaine[$pair].($this->Pre[$reste] == 'zero'?'  ':' et ').($this->Pre[$reste] == 'zero'?'':$this->Pre[$reste]);
               }else {
                return ($this->Pre[$reste] == 'zero'?'  ':' et ').($this->Pre[$reste] == 'zero'?'':$this->Pre[$reste]); 
               }
            }
        }
    }

    /**
     * @param from  le debut du test
     * @param to  la fin du test
     * @return String
     */

    public static  function makeTest(int $from, int $to){
        try{
            while($from <= $to){
              $n = new NumberToLetter($from);
                echo $n->numberToLetter().'<br>';
               
              $from++;
            }
            
        }catch(Exception $e){
            echo 'Erreur:'. $e->getMessage();
        }
    }
}
        



  



