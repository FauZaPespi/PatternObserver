<?php
$profileUser = $profileUser ?? null;
$threads = $threads ?? [];
$followerCount = $followerCount ?? 0;
$followingCount = $followingCount ?? 0;
$isOwnProfile = $isOwnProfile ?? false;
$isFollowing = $isFollowing ?? false;
$isAuthenticated = $isAuthenticated ?? false;

if (!$profileUser) {
    echo '<p>Utilisateur introuvable.</p>';
    return;
}
?>

<div class="profile-container">
    <div class="profile-card">

        <!-- Header -->
        <div class="profile-header">
            <div class="icon-wrapper">
                <img src="https://api.dicebear.com/9.x/thumbs/svg?seed=<?= urlencode($profileUser->username) ?>"
                     alt="Avatar de <?= htmlspecialchars($profileUser->username) ?>"
                     style="width: 80px; height: 80px; border-radius: 50%;">
            </div>
            <h2>@<?= htmlspecialchars($profileUser->username) ?></h2>

            <div class="profile-meta">
                <?php if ($profileUser->email): ?>
                    <span><i class="mail icon"></i> <?= htmlspecialchars($profileUser->email) ?></span>
                <?php endif; ?>
                <span><i class="calendar alternate outline icon"></i> Membre depuis <?= date('d/m/Y', strtotime($profileUser->created_at ?? 'now')) ?></span>
            </div>

            <!-- Stats -->
            <div style="display: flex; gap: 2rem; justify-content: center; margin-top: 1rem;">
                <div style="text-align: center;">
                    <strong><?= $followerCount ?></strong><br>
                    <small style="color: #888;">Abonnés</small>
                </div>
                <div style="text-align: center;">
                    <strong><?= $followingCount ?></strong><br>
                    <small style="color: #888;">Abonnements</small>
                </div>
                <div style="text-align: center;">
                    <strong><?= count($threads) ?></strong><br>
                    <small style="color: #888;">Threads</small>
                </div>
            </div>

            <!-- Follow / Edit button -->
            <div style="margin-top: 1.5rem;">
                <?php if ($isOwnProfile): ?>
                    <a href="/profile" class="ui button">
                        <i class="edit icon"></i> Modifier mon profil
                    </a>
                <?php elseif ($isAuthenticated): ?>
                    <form method="post" action="/follow/<?= urlencode($profileUser->username) ?>" style="display:inline;">
                        <?php if ($isFollowing): ?>
                            <button type="submit" class="ui button">
                                <i class="user times icon"></i> Se désabonner
                            </button>
                        <?php else: ?>
                            <button type="submit" class="ui primary button">
                                <i class="user plus icon"></i> S'abonner
                            </button>
                        <?php endif; ?>
                    </form>
                <?php else: ?>
                    <a href="/login" class="ui primary button">
                        <i class="sign in icon"></i> Connectez-vous pour vous abonner
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="profile-divider"></div>

        <!-- Threads -->
        <div class="profile-section">
            <h3 class="profile-section-title">
                <i class="comments icon"></i> Threads de @<?= htmlspecialchars($profileUser->username) ?>
            </h3>

            <?php if (empty($threads)): ?>
                <p style="color: #888; text-align: center; padding: 2rem 0;">
                    Aucun thread publié pour l'instant.
                </p>
            <?php else: ?>
                <div class="ui feed">
                    <?php foreach ($threads as $thread): ?>
                        <div class="event">
                            <div class="label">
                                <img src="https://api.dicebear.com/9.x/thumbs/svg?seed=<?= urlencode($profileUser->username) ?>"
                                     alt="Avatar">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <strong>@<?= htmlspecialchars($profileUser->username) ?></strong>
                                    <div class="date">
                                        <?= $thread->PostDate->format('d M Y H:i') ?>
                                    </div>
                                </div>
                                <div class="extra text">
                                    <?= nl2br(htmlspecialchars($thread->Content)) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
