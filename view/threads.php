<?php
use Makosc\Observer\Models\UserManager;

$isAuthenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
$threads = $threads ?? [];
$followingThreads = $followingThreads ?? [];
$activeTab = $_GET['tab'] ?? 'all';
?>

<?php if ($isAuthenticated): ?>
    <h1>Postez votre thread</h1>
    <div>
        <form method="post" action="/post" class="ui input" style="width: 100%; display: flex; flex-direction: column;">
            <textarea style="width: 100%; min-height: 150px; max-height: 500px;" name="content" id="content"></textarea>
            <button class="ui button primary" style="margin-top: 25px;" type="submit">Post</button>
        </form>
    </div>

    <!-- Feed Tabs -->
    <div class="ui pointing secondary menu" style="margin-top: 2rem;">
        <a class="<?= $activeTab === 'all' ? 'active ' : '' ?>item" href="/?tab=all">
            <i class="globe icon"></i> Tous les threads
        </a>
        <a class="<?= $activeTab === 'following' ? 'active ' : '' ?>item" href="/?tab=following">
            <i class="users icon"></i> Abonnements
            <?php if (!empty($followingThreads)): ?>
                <div class="ui label"><?= count($followingThreads) ?></div>
            <?php endif; ?>
        </a>
    </div>

    <!-- All Threads Tab -->
    <?php if ($activeTab !== 'following'): ?>
        <div class="ui feed">
            <h2>Derniers threads</h2>
            <?php if (empty($threads)): ?>
                <p>Aucun thread trouvé.</p>
            <?php else: ?>
                <?php foreach ($threads as $thread): ?>
                    <?php $author = UserManager::findById($thread->UserId); ?>
                    <div class="event">
                        <div class="label">
                            <a href="/user/<?= urlencode($author->username) ?>">
                                <img src="https://api.dicebear.com/9.x/thumbs/svg?seed=<?= urlencode($author->username) ?>"
                                     alt="Avatar de <?= htmlspecialchars($author->username) ?>">
                            </a>
                        </div>
                        <div class="content">
                            <div class="summary">
                                <a href="/user/<?= urlencode($author->username) ?>">@<?= htmlspecialchars($author->username) ?></a>
                                a publié un thread
                                <div class="date"><?= $thread->PostDate->format('d M Y H:i') ?></div>
                            </div>
                            <div class="extra text">
                                <?= nl2br(htmlspecialchars($thread->Content)) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Following Tab -->
    <?php if ($activeTab === 'following'): ?>
        <div class="ui feed">
            <h2>Threads des abonnements</h2>
            <?php if (empty($followingThreads)): ?>
                <p style="color: #888;">
                    Vous ne suivez personne pour l'instant, ou vos abonnements n'ont pas encore posté.
                    <a href="/">Voir tous les threads</a> pour découvrir des utilisateurs.
                </p>
            <?php else: ?>
                <?php foreach ($followingThreads as $thread): ?>
                    <?php $author = UserManager::findById($thread->UserId); ?>
                    <div class="event">
                        <div class="label">
                            <a href="/user/<?= urlencode($author->username) ?>">
                                <img src="https://api.dicebear.com/9.x/thumbs/svg?seed=<?= urlencode($author->username) ?>"
                                     alt="Avatar de <?= htmlspecialchars($author->username) ?>">
                            </a>
                        </div>
                        <div class="content">
                            <div class="summary">
                                <a href="/user/<?= urlencode($author->username) ?>">@<?= htmlspecialchars($author->username) ?></a>
                                a publié un thread
                                <div class="date"><?= $thread->PostDate->format('d M Y H:i') ?></div>
                            </div>
                            <div class="extra text">
                                <?= nl2br(htmlspecialchars($thread->Content)) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php else: ?>
    <?php
        header('Location: /login');
        die();
    ?>
<?php endif; ?>
</div>
