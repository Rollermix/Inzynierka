<?php require_once 'config.php'; ?>
<!-- to powinno być zrobione poprzez mod_rewrite (.htaccess itp), ale taki hack będzie ok -->
<?php header('Location: '.$CONFIG->base_url.'/views/contents/start.php'); exit; ?>