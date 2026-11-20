<?php



class rsa {


    public function expmod(int $x, int $e, int $n) : int{
    
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

    


    public function RSAencrypt(int $x, int $e, int $n) : int{
        return $this->expmod($x, $e, $n);
    }

    public function RSAdecrypt(int $y, int $e, int $p, int $q){
        $n = $p * $q;

        $phi = ($p - 1) * ($q - 1);

        $d = $this->inversemod($e, $phi);

        return $this->expmod($y, $d, $n);
    }

    public function estTemoin(int $a, int $d, int $s, int $n) : bool{
        $x = $this->expmod($a, $d, $n);

        if ($x == 1 || $x == $n - 1){
            return false;
        }

        for ($i = 1; $i < $s ; $i++){
            $x = ($x**2) % $n;

            if ($x == $n-1){
                return false;
            }
        }

        return true;
    }

    public function millerRabin(int $n, int $k) : bool{
        $s = 0; 
        // n est censé être impair => d sera pair
        $d = $n-1;

        // Tant que le reste de la division euclidienne par 2 est 0
        while ($d % 2 == 0){
            $d = intdiv($d, 2);
            $s++;
        }

        for ($i = 0 ; $i < $k ; $i++){
            $a = random_int(2, $n-2);

            if ($this->estTemoin($a, $d, $s, $n)){return false;}

        }
        return true;
    }

 
    public function premierAleatoire(int $min, int $max) : int{
        $bornInf = intdiv($min, 2);
        $bornSup = intdiv($max - 1, 2);

        $nb = random_int($bornInf, $bornSup) * 2 + 1;

        while (!$this->millerRabin($nb, 20)){
            $nb = random_int($bornInf, $bornSup) * 2 + 1;
        }

        return $nb;
    }


    public function genererCleRSA($min, $max) : array{

        $p = $this->premierAleatoire($min, $max);
        $q = $this->premierAleatoire($min, $max);
        while ($p == $q){
            $q = $this->premierAleatoire($min, $max);
        }

        $n = $p * $q;

        $phi = ($p -1) * ($q -1);

        $e = random_int(2, $phi - 1);

        while ($this->gcd($e, $phi) != 1){
            $e = random_int(2, $phi - 1);
        }

        $d = $this->inversemod($e, $phi);

        return ["p" => $p, 
                "q" => $q, 
                "n" => $n, 
                "phi" => $phi, 
                "e" => $e, 
                "d" => $d, 
                ];
    }
}

// TESTS
$rsa = new rsa();

try {

    // Exponentiation rapide
    echo "<h3>1.1 - Exponentiation rapide</h3>";
    echo "expmod(2, 30, 9) = " . $rsa->expmod(2, 30, 9) . "<br>";


    // PGCD
    echo "<h3>1.2 - PGCD</h3>";
    echo "gcd(12, 26) = " . $rsa->gcd(12, 26) . "<br>";


    // Inverse modulaire
    echo "<h3>1.3 - Inverse modulaire</h3>";
    echo "inversemod(5, 26) = " . $rsa->inversemod(5, 26) . "<br>";


    // Chiffrement et déchiffrement RSA
    echo "<h3>1.4 - Chiffrement et déchiffrement RSA</h3>";
    echo "RSAencrypt(3, 5, 85) = " . $rsa->RSAencrypt(3, 5, 85) . "<br>";
    echo "RSAdecrypt(2, 5, 5, 17) = " . $rsa->RSAdecrypt(2, 5, 5, 17) . "<br>";


    // Test de Miller-Rabin
    echo "<h3>1.5 - Test de Miller-Rabin</h3>";

    echo "estTemoin(2, 1, 3, 9) = ";
    var_export($rsa->estTemoin(2, 1, 3, 9));
    echo "<br>";

    echo "estTemoin(2, 3, 1, 7) = ";
    var_export($rsa->estTemoin(2, 3, 1, 7));
    echo "<br>";

    echo "millerRabin(561, 20) = ";
    var_export($rsa->millerRabin(561, 20));
    echo "<br>";

    echo "millerRabin(221, 20) = ";
    var_export($rsa->millerRabin(221, 20));
    echo "<br>";

    echo "millerRabin(997, 20) = ";
    var_export($rsa->millerRabin(997, 20));
    echo "<br>";

    echo "millerRabin(7919, 20) = ";
    var_export($rsa->millerRabin(7919, 20));
    echo "<br>";


    // Génération d'un nombre premier aléatoire
    echo "<h3>Génération d'un nombre premier aléatoire</h3>";
    $premier = $rsa->premierAleatoire(100, 999);
    echo "Nombre premier généré : " . $premier . "<br>";


    // Génération d'une clé RSA
    echo "<h3>Génération d'une clé RSA</h3>";
    $cles = $rsa->genererCleRSA(100, 999);

    echo "p = " . $cles["p"] . "<br>";
    echo "q = " . $cles["q"] . "<br>";
    echo "n = " . $cles["n"] . "<br>";
    echo "phi = " . $cles["phi"] . "<br>";
    echo "e = " . $cles["e"] . "<br>";
    echo "d = " . $cles["d"] . "<br>";


    // Dernier test : inverse modulaire impossible
    echo "<h3>Test d'erreur de l'inverse modulaire</h3>";
    echo "inversemod(2, 26) = " . $rsa->inversemod(2, 26) . "<br>";


} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "<br>";
}