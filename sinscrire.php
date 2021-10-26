<?php
if (isset($_POST['btn_submit']))
{
    $msg_err="";
    	if (isset($_POST['name_user']) && trim($_POST["name_user"])!="" &&
		    isset($_POST['mail_user']) && trim($_POST["mail_user"])!="" &&
		    isset($_POST['password_user'])&& trim($_POST["password_user"])!="" &&
		    isset($_POST['pass_confirm'])&& trim($_POST["pass_confirm"])!="")
   		{
			$nom=addslashes($_POST['name_user']);
			$email=addslashes($_POST['mail_user']);
			$mdp=addslashes($_POST['password_user']);
			$repeat_password=addslashes($_POST['pass_confirm']);
		
   			include "config.php"; 

			$req=$bdd->prepare('SELECT name_user, password_user,mail_user 
			                    FROM user
								WHERE mail_user = :mail_user'
							  );
							  
			$req->execute(array('mail_user' => $email));
			$verifie=$req->fetch ();

			if (!$verifie) 
			{
				if (!(empty($email)) AND (filter_var($email,FILTER_VALIDATE_EMAIL)))//si l'email est valide
	 			{
					if (!(empty($mdp)) AND !(empty($repeat_password)) AND (strcmp($mdp, $repeat_password) == 0)) //Mot de passe = Mot de passe répété 
					{
						if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[0-9]).*$#",$_POST['password_user']))//le mot de passe doit contenir des lettre et des chiffre (8-20) 
						{
        
							$pass_hashe=password_hash($mdp,PASSWORD_DEFAULT);
              

							$req=$bdd->prepare ('INSERT INTO user(name_user,password_user,mail_user)
							                     VALUES
												 (:name_user,:password_user,:mail_user)
												');
												
							$req->execute( array ('name_user'=>$nom,
												 'password_user'=>$pass_hashe,
												 'mail_user'=>$email
		                                          )
										  );

										  $msg_succ="ok";
              
						}else
						{
							$msg_err='Le mot de passe doit etre de 8 à 20 caracterès et contenir des chiffres et des lettres';
						}
					}else
					{
						$msg_err='Il faut saisir le meme mot de passe ';
					}
				}else
				{
					$msg_err="L'adresse mail n'est pas valide";
				}
			}
			else
			{
                $msg_err="Nous n'avons pas pu vous inscrire parce qu'un compte existe déjà avec cette adresse mail";
			}
			
			
		} else
        {
            $msg_err="Il faut remplir tous les champs";
	    }
}
	?>

<!doctype html>

<html lang="Fr">

<head>
    <title>Sinscrire</title>
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
                        <h1 class="h2 text-center my-3">S'inscrire</h1>
                      
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

                        <form class="py-4" action="sinscrire.php" method="post">
                            <div class="form-group">
                                <label for="nom" class="small text-uppercase">Nom <span class="text-primary">*</span></label>
                                <input type="text" id="nom" name='name_user' class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="small text-uppercase">Email <span class="text-primary">*</span></label>
                                <input type="email" id="email" name='mail_user' class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="small text-uppercase">Password <span class="text-primary">*</span></label>
                                <small id="password-hint" class="d-block text-muted mb-2">8 à 20 caractères, avec au moins 1 chiffre</small>
                                <input type="password" id="password" name='password_user' class="form-control" aria-describedby="password-hint" required>
                            </div>
                            <div class="form-group">
                                <label for="passwordconfirm" class="small text-uppercase"> confirmer le mot de passe <span class="text-primary">*</span></label>
                                <input type="password" id="passwordconfirm" name='pass_confirm' class="form-control" aria-describedby="password-hint" required>
                            </div>
                          
                           
                            <button type="submit" name='btn_submit' class="btn btn-primary btn-block rounded-pill">sinscrire</button>
                            <div class="row ml-1 mr-1" style="margin-top: 0.5rem;">
                                <button type="reset" class="col-md-6 btn btn-secondary rounded-pill">supprimer</button>
                                 <a href="index.php" class="col-md-6 btn btn-info  rounded-pill">Se connecter</a>

                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </main>


</body>
</html>

