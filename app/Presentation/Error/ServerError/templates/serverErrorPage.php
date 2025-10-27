<?php

/**
 * @var bool $debugMode
 * @var bool $printDebugPanel
 * @var string $classShortName
 * @var string $message
 * @var bool $printLink
 * @var string $href
 * @var string $caption
 * @var string $basePath
 */

$containerClass = $debugMode ? 'error-container-debug' : 'error-container-production';
$panelClass = $debugMode ? 'message-panel-debug' : 'message-panel-production';

?>
<!DOCTYPE html><!-- "' --></textarea></script></style></pre></a></datalist></iframe></optgroup></option></select></table></video>
<html>

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="robots" content="noindex">

    <link rel="icon" type="image/png"  sizes="32x32" href="<?= $basePath ?>/site/css/images/favicons/favicon.32.png">

    <link rel="icon" type="image/png"  sizes="192x192" href="<?= $basePath ?>/site/css/images/favicons/favicon.192.png">

    <style>
        html, body { overflow: hidden; }
        body * { box-sizing: border-box;  font-family: system-ui, sans-serif; --box-margin: 26px; }
        p { font-size: 17px; line-height: 1.6; margin: 12px 0; }
        .code { color: gray; }

        #server-error-overlay { all: unset; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 1000; background-color: white; }
        
        .server-error-container { position:relative; margin: var(--box-margin) 0; }
        .error-container-production { margin-bottom: max(calc(45vh - 250px), var(--box-margin)); }
        .error-container-debug { margin-bottom: max(calc(55vh - 350px), var(--box-margin)); }

        .server-error-message-panel {  border: 10px solid #c9cdd2;  border-radius: 6px; }
        .message-panel-production { width: 440px; }
        .message-panel-debug { width: 520px; }

        h1.server-error-heading { margin-top: 0; letter-spacing: -1px; background-color: #c9cdd2; padding: 6px 45px 16px; font-size: 38px; line-height: 1.1; text-align: center; font-weight: bold; }
        h3.server-error-subheading { font-size: 21px;  font-weight: bold; margin: 12px 0; }
        .message-text { padding: 0 28px; }

        .debug-message-panel { margin-bottom: var(--box-margin); min-width: 460px; max-width: 520px; background-color: #FCE8E6; border: 1px solid #fc9c93; color: red;  border-radius: 5px; padding: 0 22px; word-break: break-word; }
        .debug-message-panel a { color: red; padding: 1px 10px 3px;  border-radius: 4px; }
        .debug-message-panel a:hover { background-color: #b4b8bb55; }
        a.file-link { color: red; padding: 1px 8px 3px; margin: 0 -8px;  border-radius: 4px; transition: background-color 0.13s ease;}
        a.file-link:hover { background-color: #b4b8bb55;}

        @media (max-width: 540px) {
            .server-error-overlay { align-items: stretch; }
            .error-file-link { display: none; }
            .server-error-message-panel { width: auto; max-width: 100%; }
            .debug-message-panel { min-width: 0; max-width: 100%;  }
            .server-error-container { padding: 0 8px; }
        }
    </style>

    <title id="server-error-title">Server Error</title>

</head>

<body>

<div id="server-error-overlay">
    <div class="server-error-container <?= $containerClass ?>">

        <?php if ($debugMode): ?>
            <div class="debug-message-panel">
                <h3 class="server-error-subheading"><?= $classShortName ?></h3>

                <p><?= $message ?></p>

                <?php if ($printLink): ?>
                    <p class="error-file-link"><a href="editor:<?= $href ?>" class="file-link"><?= $caption ?></a></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="server-error-message-panel <?= $panelClass ?>">
            <h1 class="server-error-heading">Server Error</h1>

            <p class="message-text">Omlouváme se!</p>

            <p class="message-text">Na serveru došlo k chybě a nelze obsloužit Váš požadavek. Zkuste to prosím za chvíli.</p>

            <p class="message-text code">error 500</p>
        </div>
    </div>
</div>

</body>

</html>

<script>
    document.body.insertBefore(document.getElementById('server-error-overlay'), document.body.firstChild)
</script>
