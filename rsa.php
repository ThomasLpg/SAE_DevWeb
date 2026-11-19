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

    //Fonction INVERSE MODULAIRE
    public function inversemod(int $e, int $f): int {
        $r0 = $e;
        $u0 = 1;
        $r1 = $f;
        $u1 = 0;

        while ($r1 > 0) {
            $q = intdiv($r0, $r1);

            $tempR = $r0 - $q * $r1;
            $r0 = $r1;
            $r1 = $tempR;

            $tempU = $u0 - $q * $u1;
            $u0 = $u1;
            $u1 = $tempU;
        }

        if ($r0 !== 1) {
            throw new Exception("Erreur : $e n'est pas inversible modulo $f (PGCD = $r0).");
        }

        return (($u0 % $f) + $f) % $f;
    }

}

//TEST
$rsa = new rsa();
echo $rsa->gcd(12,26);
echo "<br>";

try {
    echo $rsa->inversemod(5, 26);
} catch (Exception $e) {
    echo $e->getMessage();
}

echo "<br>";

try {
    echo $rsa->inversemod(2, 26);
} catch (Exception $e) {
    echo $e->getMessage();
}