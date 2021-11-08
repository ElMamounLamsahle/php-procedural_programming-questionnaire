<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Questionnaire de programmation : Question <?= $numQuestion ?></title>
        <link rel="stylesheet" href="assets/css/main.css?v=2.1">
    </head>
    <body>
        <h1>Questionnaire de programmation</h1>
        <form action="<?= $_SERVER["PHP_SELF"] ?>" methode="get">
            <fieldset>
                <legend>Question <?= $numQuestion ?></legend>
                <p><?= $question ?></p>
                <div class="radio">
                    <input type="radio" id="reponseOui" name="reponse" value="oui">
                    <label for="reponseOui">Oui</label>
                </div>
                <div class="radio">
                    <input type="radio" id="reponseNon" name="reponse" value="non">
                    <label for="reponseNon">Non</label>
                </div>
                <?php if ($erreur) echo '<p class="error">Veuillez selectionnez une réponse.</p>' ?>
            </fieldset>
            <input type="submit" name="valider" value="Valider">
        </form>
    </body>
</html>