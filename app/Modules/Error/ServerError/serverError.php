<?php
    $debugMode ??= false;
    $exceptionClass ??= '';
    $exceptionMessage ??= '';
    $file ??= '';
    $href ??= '';
?>
<!DOCTYPE html>

</textarea></script></style></pre></a></datalist></iframe></optgroup></option></select></table></video>

<!-- ip:  <?=$_SERVER['REMOTE_ADDR']?> -->

<meta charset="utf-8">

<meta name="robots" content="noindex">

<title>Server Error</title>

<style>
    #error-500-container { all: initial; position: absolute; top: 0; left: 0; right: 0; height: 98vh; min-height: 400px; display: flex; flex-flow: column nowrap; align-items: center; justify-content: center; z-index: 1000;  background-color: white; }
    .error-box { margin: 0 auto; width: fit-content; max-width: 400px; border: 10px solid #c9cdd2;  border-radius: 6px;   }
    .error-heading { margin-top: 0; letter-spacing: -1px; background-color: #c9cdd2; padding: 0 45px 10px; font-size: 38px; text-align: center;}
    .error-box p { padding: 0 28px; line-height: 25px;  font-size: 16px;}
    .error-box .code { color: #888;}
    .exception-message-box { padding: 0 22px; background-color: #FCE8E6; border: 1px solid #fc9c93; color: red;  border-radius: 5px; }
    .exception-message-box a { color: red; padding: 1px 10px 3px;  border-radius: 4px; transition: background-color 0.13s ease;}
    .exception-message-box a:hover { background-color: #d8dce099;}
    h3 { font-weight: 600;  font-size: 21px;}

    .error-wrapper { margin: 40px auto;  display: flex;  flex-flow: column nowrap; gap: 18px;  font-family: system-ui, sans-serif; }

    @media (max-width: 500px) {
        .error-box { margin: 28px 12px;  border-radius: 0; min-width: auto; }
    }
</style>



<div id="error-500-container">
    <div class="error-wrapper">

        <?php if($debugMode): ?>

            <div class="exception-message-box">
                <h3><?= $exceptionClass ?></h3>
                <p><?= $exceptionMessage ?></p>
                <p><a href="editor:<?= $href ?>" class="file-link"><?= $file ?></a></p>
            </div>

        <?php endif; ?>

        <div class="error-box">
            <h1 class="error-heading">Server Error</h1>

            <p>Omlouváme se!</p>

            <p>Na serveru došlo k chybě a nelze obsloužit Váš požadavek. Zkuste to za chvíli.</p>

            <p class="code">error 500</p>
        </div>

    </div>
</div>

<script>
    document.body.insertBefore(document.getElementById('error-500-container'), document.body.firstChild);
</script>
