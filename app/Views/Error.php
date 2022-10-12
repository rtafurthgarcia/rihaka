<div class="container pt-3">
    <div class="row align-items-start">
        <div class="col-12 col-md-8 me-md-8">
            <h1 class="display-1">Error <?=strval($exception->getCode())?> : <?=$exception->getMessage()?></h2>
            <h2 class="bd-lead">Whoops, shit happens ig ? ¯\_(ツ)_/¯</h2>
        </div>
        <div class="signup-title col-12 col-md-4">
            <?=$this->fetch('./Base/Rihaka.php', [])?>
        </div>
    </div>
</div>