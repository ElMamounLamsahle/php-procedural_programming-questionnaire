<?php
    // On Initialise la session.
    session_start();
    // On Initialise la variable erreur utilisée pour afficher un message d'erreur si l'usager valide sans choisir une des réponses attendus.
    $erreur = false;
    // Si ce n'est pas le premier affichage du formulaire.
    if (count($_GET) > 0) {
        // On initialise la variable réponse par la value du radio input ou la chaine vide si l'usager a validé sans choisir une réponse.
        $reponse = $_GET["reponse"] ?? "";
        // Si l'utilsateur n'a pas choisi une réponse ou il a changé la valeur dans la zone de l'url du navigateur avec une valeur invalide
        if ($reponse !== "oui" && $reponse !== "non") {
            // On retourne une erreur
            $erreur = true;
        }
        else {
            // Si non (si une des valeurs attendus est retournée)
            // On crée un tableau associatif et on stock dedans la numéro de la question et la réponse de l'usager
            $reponses [] = ["numero" => 1, "reponse" => $reponse];
            // On stock le tableau créé dans la session reponses
            $_SESSION["reponses"] = $reponses;
            // Et on redirige l'usager vers la page de la deuxième question
            header("Location: deuxieme-question.php");
            die();
        }
    }
    // Si on a pas redirigé l'usager vers la page de la deuxième question
    // On inclut la variable $questions qui est un tableau associatif des questions
    require_once("required/tableau-questions.inc.php");
    // On initialise les variable $numQuestion et $question, car elles sont utilisées dans formulaire-questions.inc.php
    $numQuestion = 1;
    $question = array_column($questions, "question")[$numQuestion - 1];
    // On inclut le formulaire de la question
    require_once("required/formulaire-questions.inc.php");
?>