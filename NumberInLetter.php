<?php 

/**
 * Cette classe permet de convertir un nombre en lettre (Francais pour le moment)
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
               return $this->dizaine();
            }elseif($this->number >= 100 && $this->number < 1000){
                return $this->centaine();              
           }elseif($this->number >= 1000 && $this->number < 1000000){
                if($this->number % 1000 == 0){
                    $prefix =$this->Pre[$this->number / 1000];
                    return ($prefix == 'un'?'':$prefix).$this->millaine;
                }else{
                    $prefix =$this->Pre[$this->number / 1000];
                    $prefix_dizaine='';
                    $prefix_centaine='';
                    if($this->number % 100 == 0){    
                        $prefix_centaine .= $this->Pre[$this->number % 1000 / 100];
                    }else{
                        if($this->Pre[($this->number % 1000)/100] !== 'zero'){
                            $prefix_centaine .=$this->Pre[($this->number % 1000)/100];
                        }else{

                            $this->centaine = '';
                        }

                        if((($this->number %1000) % 100)%10 == 0){
                             $prefix_dizaine .= $this->dizaine[(($this->number %1000) % 100)];
                        }else{
                            if(in_array((($this->number %1000) % 100), $this->exception)){
                                $pair =$this->dizaine[($this->number%1000%100) - $this->number %1000 % 100 %10];
                                $first = explode('-', $pair)[0];
                                $end = $this->exceptionLettres[$this->number %1000 % 100 %10];
                                $prefix_dizaine .= $first.' '.$end;
                            }else{
                                if(in_array($this->number % 1000% 100, $this->Pre)){
                                    $prefix_dizaine .= $this->Pre[$this->number % 1000% 100];
                                }else{
                                if(($this->number%1000%100) - ($this->number %1000 % 100 %10)!== 0 ){
                                   if(($this->number%1000%100) - ($this->number %1000 % 100 %10) > 19){
                                    $pair =$this->dizaine[($this->number%1000%100) - ($this->number %1000 % 100 %10)];
                                    $reste = $this->number %1000 % 100 %10;
                                    $prefix_dizaine .= $pair.' et ' . $this->Pre[$reste];
                                   }else{
                                    $pair =$this->Pre[($this->number%1000%100) - ($this->number %1000 % 100 %10)];
                                    $reste = $this->number %1000 % 100 %10;
                                    $prefix_dizaine .= $pair.' et ' . $this->Pre[$reste];
                                   }
                                  
                                }else{
                                    $reste = $this->number %1000 % 100 %10;
                                    $prefix_dizaine .=$this->Pre[$reste];

                                }
                                }
                           
                                
                              
                            }
                        }
                        return ($prefix == 'un'?'':$prefix).' '.$this->millaine. ' '.($prefix_centaine ==' un'?' ':$prefix_centaine).' ' .$this->centaine.' '.$prefix_dizaine;
                    }


                }

           }
    }

/**
 * function qui va gerer les nombres de zero à 99
 * @param void 
 * @return String
 */
    private function dizaine()
    {
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
    }

    /**
 * function qui va gerer les nombres de cent à 999
 * @param void 
 * @return String
 */
    private function centaine() 
    {
        if($this->number % 100 == 0){
            $prefix = $this->Pre[($this->number / 100)];
            return  ($prefix=='un' ? ' ': $prefix) .' '.$this->centaine;
        }else{

     
            $prefix = $this->Pre[($this->number / 100)]; 
            $pair = ($this->number % 100) -(( $this->number % 100)% 10);
            $reste = ( $this->number % 100)% 10;
            // $diz = ($this->number % 100) -(($this->number % 100) % 10);

            $diz = $this->number % 100;
            if(in_array($diz, $this->exception)){
                $pair =$diz-($diz % 10);
                $reste= $diz % 10;
                $explode_pair = explode('-', $this->dizaine[$pair]);
                $first = $explode_pair[0];
                return (
                    ($prefix == 'un'?' ':$prefix).' '.$this->centaine.' '.$first.' '.$this->exceptionLettres[$reste]
                );
            }else{
                return ($prefix == 'un'?' ':$prefix).' '.$this->centaine.' '.$this->dizaine[$pair].' et '.$this->Pre[$reste];
            }
        }
    }

    /**
     * @param void
     * @return String
     */

    private function millieme()
    {

    }
}



