<?php
    // On Initialise la session.
    session_start();
    // On Initialise la variable erreur utilisée pour afficher un message d'erreur si l'usager valide sans choisir une des réponses attendus.
    $erreur = false;
    // Si l'usager a déja répondu à la première question.
    // ce teste suffit car si la session n'est pas difinie l'usager va être toujours redirigé
    // vers la page de la première question
    if (isset($_SESSION["reponses"])) {
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
                // On récupére dans un tableau la session déja créé qui est de type tableau associatif aussi
                $reponses = $_SESSION["reponses"];
                // On ajoute la deuxième réponse dans le tableau
                $reponses [] =["numero" => 2, "reponse" => $reponse];
                // On stocke le nouveau tableau dans la même session
                $_SESSION["reponses"] = $reponses;
                // Et on redirige l'usager vers la page du résultat
                header("Location: resultat.php");
                die();
            }
        }
    }
    else {
        // Si non (si l'usager n'a pas encore répondu à la première question.)
        // On lui redirige vers la page de la première question
        header("Location: premiere-question.php");
        die();
    }
    // Si on a pas redirigé l'usager vers la page du résultat ou la page de la première question
    // On inclut la variable $questions qui est un tableau associatif des questions
    require_once("required/tableau-questions.inc.php");
    // On initialise les variable $numQuestion et $question, car elles sont utilisées dans formulaire-questions.inc.php
    $numQuestion = 2;
    $question = array_column($questions, "question")[$numQuestion - 1];
    // On inclut le formulaire de la question
    require_once("required/formulaire-questions.inc.php");
?>