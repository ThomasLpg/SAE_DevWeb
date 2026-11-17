<?php

class rsa{
    //Fonction PGCD
    public function gcd($a, $b): int{
        while($b!==0){
            $reste = $a%$b;
            $a=$b;
            $b=$reste;
        }
        return $a;
    }

}
//TEST
$rsa = new rsa();
echo $rsa->gcd(12,26);