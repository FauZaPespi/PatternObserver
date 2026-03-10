<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.css">
    
    <style>
        /* CSS Flexbox pour garder le footer en bas de la page */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f4f6f8; /* Fond légèrement gris typique des dashboards */
        }
        
        /* Conteneur principal qui prend tout l'espace restant */
        main {
            flex: 1;
            padding-top: 40px; 
            padding-bottom: 40px;
        }

        /* Ajustement de la marge du footer */
        .ui.footer.segment {
            margin-top: auto;
        }
    </style>
</head>

<body>
    <main class="ui container">
        <?= $content ?>
    </main>

    <footer class="ui inverted vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui horizontal inverted small divided link list">
                <span class="item">
                    Observer &copy; <?= date("Y") == "2026" ? date("Y") : "2026 - " . date("Y") ?>
                </span>
                <span class="item">Ptytsia Maksym & Calvo Oscar</span>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.3/dist/semantic.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialise automatiquement les menus déroulants et cases à cocher 
            // qui seront injectés via ton <?= $content ?>
            $('.ui.dropdown').dropdown();
            $('.ui.checkbox').checkbox();
            
            // Permet de fermer les messages d'alerte (flash messages)
            $('.message .close').on('click', function() {
                $(this).closest('.message').transition('fade');
            });
        });
    </script>
</body>

</html>