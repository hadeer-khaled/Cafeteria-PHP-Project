<?php
    if($session->hasSession('success'))
    {
        foreach($session->get('success')as $success){?>

        <div class="alert alert-success"><?= $success?></div>


    <?php
    }
    }
    ?>