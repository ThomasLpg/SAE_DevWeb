<?php


function expmod(int $x, int $e, int $n) : int{
    
    $res = 1;

    // Tant que la puissance est positive 
    while ($e > 0) {

        // Si le reste de la division par 2 est impair (bit de valeur 1 => puissance de 2 active)
        if ($e % 2 == 1){
            // Alors on multiplie par x
            $res = ($res * $x) % $n;
        }

        // On fait une division euclidienne par deux
        $e = intdiv($e, 2);

        // On récupère x² mod n 
        $x = ($x**2) % $n;
    }

    return $res;
}

function RSAencrypt(int $x, int $e, int $n) : int{
    // Il faut vérifier si e et p(n) sont premiers entre eux
    // Calcul de 

    // On chiffre par x -> x**e mod n
    return expmod($x, $e, $n);
}

function RSAdecrypt(int $y, int $e, int $p, int $q){
    $n = $p * $q;

    $phi = ($p - 1)($q - 1);

    $d = inversemod($e, $phi);

    return expmod($y, $d, $n);

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