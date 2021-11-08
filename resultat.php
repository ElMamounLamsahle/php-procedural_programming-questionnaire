<?php
    // On Initialise la session.
    session_start();
    // On inclut le fichier des fonctions qui contient la fonction pour détruire la session
    require_once("required/fonctions.inc.php");
    // Si l'usager a choisi de refaire le teste
    if (isset($_GET["redo"])) {
        // On détruit la session
        detruire_session ();
        // Et on lui redirige vers la page de la première question
        header("Location: premiere-question.php");
        die();
    }
    // Si non (si c'est le premier affichage de la page)
    // On inclut la variable $questions qui est un tableau associatif des questions
    require_once("required/tableau-questions.inc.php");
    // Si l'usager a déja répondu aux deux questions (toutes les questions)
    if (isset($_SESSION["reponses"]) && count($_SESSION["reponses"]) == count($questions)) {
        // On stock la valeur de la session "reponses" qui est de type tableau associatif dans un tableau indicé
        // dans la variable tableau $reponses
        $reponses = $_SESSION["reponses"];
        // On initialise un variable pour récupérer le nombre des questions
        $nbQuestions = count($questions);
        // On initialise une variable pour calculer le score de l'usager
        $score = 0;
        // Pour chaque éléments du tableau des questions
        foreach($questions as $i => $question) {
            // Pour chaque éléments du tableau des réponses
            foreach($reponses as $reponse) {
                // Si la numéro de la réponse est égale au numéro de la question
                if ($reponse["numero"] == $question["numero"]) {
                    // On ajoute une nouvelle clé => valeur au tableau des questions qui représente la réponse de l'usager
                    // Pour ne boucler que sur celui-ci plus bas en HTML pour l'affichage des résultats
                    $questions[$i]["reponseUtilisateur"] = $reponse["reponse"];
                    // Et si la réponse est bonne
                    if ($reponse["reponse"] == $question["reponse"]) {
                        // On ajoute une nouvelle clé => valeur au tableau des questions qui indique que la réponse est juste
                        $questions[$i]["resultat"] = "Juste";
                        // Et on incrémente le score
                        $score++;
                    }
                    // On ajoute une nouvelle clé => valeur au tableau des questions qui indique que la réponse est fausse
                    else $questions[$i]["resultat"] = "Faux";
                    // En fin on supprime la réponse en cours de l'usager pour minimiser le nombre d'itérations
                    // sur le tableau de réponses puisque la réponse courante est déja utilisée
                    // et on n'en aura pas besoin puisque on va détruire la session à la fin de script
                    unset($reponse);
                }
            }
        }
        // Aprés on initialise une variable $message et $niveau ici pour ne pas faire beaucoup du code dans le HTML
        // La variable $message renvoie un message selon le score obtenu par l'usager
        // Et la variable $niveau est utilisée pour difinir une class css pour l'affichage du message
        $message = "Vous avez $score bonne(s) réponse(s) / $nbQuestions :";
        if ($score == $nbQuestions) {
            $message .= " Félicitation vous avez des bonnes connaissances en programmation.";
            $niveau = "lavel-top";
        }
        else if ($score == $nbQuestions / 2) {
            $message .= " Vous avez un niveau moyen de connaissances en programmation.";
            $niveau = "lavel-medium";
        }
        else {
            $message .= " Désolé vous n'avez pas de connaissances en programmation.";
            $niveau = "lavel-null";
        }
        // Et en fin on détruit la session pour éviter que l'usager passe aux pages des questions à partir de la zone de l'url du navigateur
        // à partir de la de la page Résultat ou au clique sur le bouton précédent du navigateur
        detruire_session ();
    }
    else {
        // Si non (si l'usager n'a pas encore répendu à une des questions ou aucune question)
        // on lui redirige vers la page de la première question selon les instruction de l'exercice
        // mais on a pu tester s'il a déja répondu à la première on le redirige vers la deuxième
        header("Location: premiere-question.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Questionnaire de programmation : Résultat</title>
        <link rel="stylesheet" href="assets/css/main.css?v=2.1">
    </head>
    <body>
        <h1>Questionnaire de programmation</h1>
        <fieldset>
            <legend>Résultat</legend>
            <!-- Pour chaque question -->
            <?php foreach($questions as $question) : ?>
                <div class="correction">
                    <!-- On met la question dans un <p> -->
                    <p><?= $question["question"] ?></p>
                    <div>
                        <!-- On modifie le style de la réponse choisie par l'usager -->
                        <span <?= ($question["reponseUtilisateur"] === 'oui') ? 'class="choosen"' : '' ?>>Oui</span>
                        <span <?= ($question["reponseUtilisateur"] === 'non') ? 'class="choosen"' : '' ?>>Non</span>
                        <!-- On affiche Juste en vert si la réponse est bonne ou Faux en rouge si la réponse n'est pas bonne -->
                        <span class="result <?= ($question["resultat"] === 'Juste') ? 'ok' : 'no' ?>">
                            <?= $question["resultat"] ?>
                        </span>
                    </div>
                </div>
            <?php endforeach ?>
            <!-- On affiche un message contenant le nombre des bonnes réponses de l'usager -->
            <!-- et une félicitation ou réprimande en fonction du score / nombre de questtions -->
            <p class="msg-result <?= $niveau ?>"><?= $message ?></p>
        </fieldset>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" methode="get">
            <input type="submit" name="redo" value="Refaire le teste">
        </form>
    </body>
</html>