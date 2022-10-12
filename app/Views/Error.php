<div class="container pt-3">
    <div class="row align-items-start">
        <div class="col-12 col-md-5 me-md-5">
            <h1 class="bd-title">Error <?=strval($exception->getCode())?> : <?=$exception->getMessage()?></h2>
            <h2 class="mb-0" id="content">Whoops, this shouldnt have happened.</h2>
            <p class="bd-lead">Hope your experience on RIHAKA is still worthwhile and hope you ain't too disappointed :)</p>
        </div>
        <div class="signup-title col-12 col-md-6">
            <?=$this->fetch('./Base/Rihaka.php', [])?>
        </div>
    </div>
</div>