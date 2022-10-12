<div class="container px-4 py-4 py-md-5">
<div class="container pt-3">
    <div class="row align-items-start">
       
        <div class="row col px-4 pb-4 mt-4 mt-md-0">
            <? if (count($recordings) > 0): ?>
                <? foreach($recordings as &$recording): ?>
                    <?=$this->fetch('./Base/PlayerListItem.php', [
                        "activeMenu" => $activeMenu, 
                        "contributionsOnly" => $contributionsOnly,
                        "recording" => $recording,
                       # "hideEdit" => !($user->getPrimaryKey() === $_SESSION['id'])
                    ]
                    )?>
                <? endforeach; ?>
            <? else: ?>
                <div class="alert alert-primary" role="alert">
                    There are not any uploaded Video
                </div>
            <? endif; ?>
        </div>
    </div>
</div>
    

</div>