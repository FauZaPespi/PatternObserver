<?php
// Ta logique PHP (si nécessaire) va ici
?>

<div class="ui middle aligned center aligned grid" style="max-width: 450px; margin: 0 auto; padding-top: 5vh;">
    <div class="column">
        
        <h2 class="ui primary header text-center">
            <i class="user circle icon"></i>
            <div class="content">
                Créer un compte
                <div class="sub header">Rejoignez Observer dès aujourd'hui</div>
            </div>
        </h2>
        
        <form action="/api/register" method="POST" class="ui large form">
            
            <div class="ui stacked segment">
                
                <div class="field">
                    <label for="username" style="text-align: left;">Username</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" id="username" placeholder="Entrez votre nom d'utilisateur" required>
                    </div>
                </div>

                <div class="field">
                    <label for="password" style="text-align: left;">Password</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" id="password" placeholder="Choisissez un mot de passe" required>
                    </div>
                </div>

                <button type="submit" value="register" class="ui fluid large primary submit button">
                    Register
                </button>
                
            </div>
        </form>

        <div class="ui message">
            Déjà inscrit ? <a href="/login">Connectez-vous ici</a>.
        </div>
        
    </div>
</div>