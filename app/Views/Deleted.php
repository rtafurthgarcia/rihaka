<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', ["activeMenu" => $activeMenu, "contributionsOnly" => $contributionsOnly])?>
        <div class="col-12 col-md-5 me-md-5">
            <? if($successful): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    Recording <?=$recording->getSecondaryId() ?> has been successfully deleted. 
                </div>
            <? else: ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    Something happened while deleting <?=$recording->getSecondaryId() ?>.
                    <?=$errors["delete"]?> 
                </div>
            <? endif; ?>
        </div>
    </div>
</div>