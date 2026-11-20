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

}