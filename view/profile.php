<?php
$user = $user ?? null;
$profileError = $profile_error ?? null;
$passwordError = $password_error ?? null;
?>

<div class="profile-container">
    <div class="profile-card">

        <!-- Header -->
        <div class="profile-header">
            <div class="icon-wrapper">
                <i class="user circle icon"></i>
            </div>
            <h2><?= htmlspecialchars($user->username ?? '') ?></h2>
            <div class="profile-meta">
                <?php if ($user->email): ?>
                    <span><i class="mail icon"></i> <?= htmlspecialchars($user->email) ?></span>
                <?php endif; ?>
                <span><i class="calendar alternate outline icon"></i> Membre depuis <?= date('d/m/Y', strtotime($user->created_at ?? 'now')) ?></span>
            </div>
        </div>

        <div class="profile-divider"></div>

        <!-- Edit Info Section -->
        <div class="profile-section">
            <h3 class="profile-section-title">Informations du compte</h3>

            <?php if ($profileError): ?>
            <div class="ui negative message error-message">
                <p><?= htmlspecialchars($profileError) ?></p>
            </div>
            <?php endif; ?>

            <form action="/profile/update" method="POST" class="profile-form">
                <div class="field">
                    <label for="username">Nom d'utilisateur</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" id="username"
                               value="<?= htmlspecialchars($user->username ?? '') ?>"
                               required minlength="3" maxlength="50">
                    </div>
                </div>

                <div class="field">
                    <label for="email">Adresse email <span class="optional-label">(optionnel)</span></label>
                    <div class="ui left icon input">
                        <i class="mail icon"></i>
                        <input type="email" name="email" id="email"
                               value="<?= htmlspecialchars($user->email ?? '') ?>"
                               placeholder="votre@email.com">
                    </div>
                </div>

                <button type="submit" class="ui fluid submit button">
                    <i class="save icon"></i> Enregistrer les modifications
                </button>
            </form>
        </div>

        <div class="profile-divider"></div>

        <!-- Change Password Section -->
        <div class="profile-section">
            <h3 class="profile-section-title">Changer le mot de passe</h3>

            <?php if ($passwordError): ?>
            <div class="ui negative message error-message">
                <p><?= htmlspecialchars($passwordError) ?></p>
            </div>
            <?php endif; ?>

            <form action="/profile/password" method="POST" class="profile-form">
                <div class="field">
                    <label for="current_password">Mot de passe actuel</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="current_password" id="current_password" required>
                    </div>
                </div>

                <div class="field">
                    <label for="new_password">Nouveau mot de passe</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="new_password" id="new_password" required minlength="6">
                    </div>
                    <small style="color: #888;">Minimum 6 caractères</small>
                </div>

                <div class="field">
                    <label for="confirm_password">Confirmer le nouveau mot de passe</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                    </div>
                </div>

                <button type="submit" class="ui fluid submit button">
                    <i class="key icon"></i> Changer le mot de passe
                </button>
            </form>
        </div>

    </div>
</div>
