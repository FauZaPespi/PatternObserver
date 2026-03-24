<?php

use Makosc\Observer\Models\UserManager;

$isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
$username = $_SESSION['username'] ?? null;



?>
<?php if ($isAuthenticated): ?>
    <h1>Postez votre thread</h1>
    <!-- Formulaire de création de thread -->
    <div>
        <form method="post" action="/post" class="ui input" style="width: 100%; display: flex; flex-direction: column;">
            <textarea style="width: 100%; min-height: 150px; max-height: 500px;" name="content" id="content"></textarea>
            <button class="ui button primary" style="margin-top: 25px;" type="submit">Post</button>
        </form>
    </div>

    <!-- Liste des derniers threads -->
    <div class="ui feed">
        <h2>Derniers threads</h2>

        <?php if (empty($threads)): ?>
            <p>Aucun thread trouvé.</p>
        <?php else: ?>
            <?php foreach ($threads as $thread): ?>
                <div class="event">
                    <div class="label">
                        <img src="https://api.dicebear.com/9.x/thumbs/svg?seed=<?= htmlspecialchars(UserManager::findById($thread->UserId)->username) ?>" alt="User Avatar for <?= htmlspecialchars(UserManager::findById($thread->UserId)->username) ?>">
                    </div>
                    <div class="content">
                        <div class="summary">
                            <a><?= htmlspecialchars(UserManager::findById($thread->UserId)->username) ?></a> posted a new thread
                            <div class="date">
                                <?= $thread->PostDate->format('d M Y H:i') ?>
                            </div>
                        </div>
                        <div class="extra text">
                            <?= nl2br(htmlspecialchars($thread->Content)) ?>
                        </div>
                        <div class="meta">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php else:
    header('Location: ' . "/login");
    die();
endif; ?>
</div>