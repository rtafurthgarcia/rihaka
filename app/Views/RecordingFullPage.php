<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', ["activeMenu" => $activeMenu, "contributionsOnly" => $contributionsOnly])?>
        <div class="signup-form col-12 col-xl-10 col-lg-9 col-md-8 px-4 pe-md-0 py-4 py-md-0">
            <h2><?=$recording->getTitle()?></h2>
            <div class="row">
                <?=$this->fetch('./Base/PlayerCard.php', [
                    "recording" => $recording,
                    "hideEdit" => (isset($_SESSION['id'])) && ($recording->getUserId() === $_SESSION['id']),
                    "lightVersion" => false
                ])?>
            </div> 
        </div>
    </div>
</div>