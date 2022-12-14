<?php
// Verifier si l'exécution se fait sur le serveur de développement (local) ou celui de la production:
if (stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168')) {
    $blnLocal = TRUE;
} else {
    $blnLocal = FALSE;
}

// Selon l'environnement d'exécution (développement ou production)
if ($blnLocal) {
    $strHost = 'localhost';
    $strBD='22_pwem2_off';
    $strUser = '22_pwem2_OFF';

    $strPassword= '22_pwem2_OFF_mdp+!2';
//    $strPassword= '22_pwem2_OFF+!2';

} else {
    $strHost = 'localhost';
    $strBD='22_pwem2_OFF';
    $strUser = 'etudiantsPWEM2';
    $strPassword = 't1M582+=$yy';
    error_reporting(E_ALL);
    //error_reporting(E_ALL & ~E_NOTICE);
}

//Data Source Name pour l'objet PDO
$strDsn = 'mysql:dbname='.$strBD.';host='.$strHost;

//Tentative de connexion
$pdoConnexion = new PDO($strDsn, $strUser, $strPassword);

//Changement d'encodage de l'ensemble des caractères pour UTF-8
$pdoConnexion->exec("SET CHARACTER SET utf8");

//Pour obtenir des rapports d'erreurs et d'exception avec errorInfo()
$pdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$pdoConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

?>