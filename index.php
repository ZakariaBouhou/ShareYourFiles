<?php

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        //var_dump($_FILES['image']);

        // On vérifie si l'image fait moins de 3mo
        if ($_FILES['image']['size'] <= 3000000) {

            // On chope les infos de l'image
            $informationsImage = pathinfo($_FILES['image']['name']);
            //var_dump($informationsImage);
            
            // On chope l'extension de l'image à partir des infos du pathinfo de la variable précédente
            $extensionImage = $informationsImage['extension'];
            //var_dump($extensionImage);
            
            // On insère les extensions voulues dans un tableau           
            $extensionsArray = ['png', 'gif', 'jpg', 'jpeg'];
            
            //var_dump($informationsImage);
            
            // On vérifie si l'extension de l'image est bien présent dans le tableau des extensions
            if (in_array($extensionImage, $extensionsArray)) {

                // On upload l'image avec la fonction move_uploaded_file qui prend deux paramètres :
                // 1) le repertoire où se trouve l'image
                // 2) Le répertoire de destination de l'image
                // On dit en gros : On veut dépalcer le fichier qui est dans le répertoire 1 au répertoire 2

                $newImageName = time().rand().rand().'.'.$extensionImage ;

                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/'.$newImageName);

                $sent = true;
            }
        }

    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="css/default.css">
        <link rel="icon" type="image/png" href="images/favicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <title>ShareFiles - Hébergez gratuitement vos images et en illimité</title>
    </head>
    <body>

        <header>
            <a href="../ShareFiles/">
                <span>ShareFiles</span>
            </a>
        </header>

        <section>
            <h1>
                <?php 
                    /* if (isset($sent) && $sent) {

                        echo '<img src="uploads/'.$newImageName.'" alt="file shared" style="max-width: 75%">';

                    } */
                    if (isset($sent) && $sent) { ?>

                        <img src="uploads/<?= $newImageName ?>" alt="file shared" style="max-width: 75%">

                    <?php } 

                    else { ?>

                        <i class="fas fa-paper-plane"></i>

                    <?php } ?>
                
            </h1>
            
            <?php 
               if (isset($sent) && $sent) { ?>

                    <h2>L'image a bien été envoyée</h2>
                    <p>Lien vers l'image ci-dessous</p>
                    <input type="text" id="link" value="http://localhost/Sharefiles/uploads/<?= $newImageName ?>" readonly>

               <?php } else { ?>                     

                <form method="post" action="index.php" enctype="multipart/form-data">
                    <p>
                        <label for="image">Sélectionnez votre fichier</label><br>
                        <input type="file" name="image" id="image">
                    </p>
                    <p id="send">
                        <button type="submit">Envoyer <i class="fas fa-long-arrow-alt-right"></i></button>
                    </p>
                </form>

            <?php } ?>

        </section>
        
    </body>
</html>