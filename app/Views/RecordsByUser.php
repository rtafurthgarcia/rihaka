<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', [
            "activeMenu" => $activeMenu, 
            "contributionsOnly" => $contributionsOnly,
            "user" => $user
        ]
        )?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 col gx-3 ps-4 pe-0 py-4 py-md-0">
            <? if (count($recordings) > 0): ?>
                <? foreach($recordings as &$recording): ?>
                    <?=$this->fetch('./Base/PlayerListItem.php', [
                        "activeMenu" => $activeMenu, 
                        "contributionsOnly" => $contributionsOnly,
                        "recording" => $recording,
                        "hideEdit" => !($user->getPrimaryKey() === $_SESSION['id'])
                    ]
                    )?>
                <? endforeach; ?>
            <? else: ?>
                <div class="alert alert-primary" role="alert">
                    It seems this one user hasnt shared anything yet.
                </div>
            <? endif; ?>
        </div>
    </div>
</div>