<?php
   // connexion à la base de données
          include "config.php"; 
if (isset($_POST['btn_submit']))
{	  
    $msg_err="";
 if(
		 isset($_POST["mail_user"]) && trim($_POST["mail_user"])!="" &&
		 isset($_POST["password_user"]) && trim($_POST["password_user"])!="" 
   )
	{
        
          $email=addslashes($_POST["mail_user"]);
	      $mdp=addslashes($_POST["password_user"]);
		  
         
          //  Récupération de l'utilisateur et de son pass hashé
					$req=$bdd->prepare('SELECT password_user,mail_user
                    					FROM user 
										WHERE mail_user = :mail_user'
									   );
									   
					$req->execute(array('mail_user' => $email));
					$verifie=$req->fetch();
				
          // Comparaison du pass envoyé via le formulaire avec la base
					$isPasswordCorrect = password_verify($_POST['password_user'], $verifie['password_user']);
					
		            if (!$verifie)
					  {
                        $msg_err='Identifiant ou mot de passe incorrecte !';	
                    }
					  else
					  {
						   if ($isPasswordCorrect) 
						   {
									   
								$msg_succ="Ok, vous etes bien connecté";	   
						    }else
						    {
							  $msg_err='Identifiant ou mot de passe incorrecte !';
							}
				      }
	}
}

?>

<!doctype html>

<html lang="Fr">

<head>
    <title>Se connecter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Goole fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,700%7CMerriweather+Sans:300,400,700" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
</head>

<body>
    <header class="site-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light " aria-label="Main navigation">
                <a class="navbar-brand text-dark" href="index.php">
                    <img src="logo-boost.svg" alt="logo">
                </a>
            </nav>
        </div>
    </header>

    <main id="main">
        <div class="bg-skew bg-skew-light pb-3 min-vh-80">

            <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-6">
                        <h1 class="h2 text-center my-3">Se connecter</h1>
                        <?php
					     if (isset($_POST['btn_submit']))
						  { 
                              if($msg_err!="")
                              {
                                  
                    ?>
									<div class="alert alert-danger alert-success" style="background:white;" role="alert">
											<strong>Erreur! </strong><?php echo $msg_err; ?> 
									</div>
				   <?php 
                              }else
                              {
                                 ?>
                                <div class="alert alert-success" style="background:white;" role="alert">
                                <strong>Success! </strong><?php echo $msg_succ; ?> 
                        </div>
                        <?php
                              }
						  }  
				   ?>
                        <form class="py-4" method="post" action="">
                            <div class="form-group">
                                <label for="email" class="small text-uppercase">Identifiant <span class="text-primary">*</span></label>
                                <input type="email" id="email" name="mail_user" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="small text-uppercase">Mot de passe <span class="text-primary">*</span></label>
                                <input type="password" id="password"  name="password_user" class="form-control" aria-describedby="password-hint" required>
                            </div>
                          
                           
                            <button type="submit" name="btn_submit" class="btn btn-primary btn-block rounded-pill">OK</button>
                            <div class="row ml-1 mr-1" style="margin-top: 0.5rem;">
                                <button type="reset" class="col-md-6 btn btn-secondary rounded-pill">Reset</button>
                                 <a href="sinscrire.php" class="col-md-6 btn btn-info  rounded-pill">Ajouter un compte</a>

                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </main>


</body>
</html>

