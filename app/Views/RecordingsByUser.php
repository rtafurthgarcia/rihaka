<div class="container pt-3">
    <div class="row align-items-start">
        <?=$this->fetch('./Base/Sidebar.php', [
            "activeMenu" => $activeMenu, 
            "contributionsOnly" => $contributionsOnly,
            "user" => $user
        ]
        )?>
        <div class="row col px-4 pb-4 mt-4 mt-md-0">
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
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="<?='/user/' . $user->getUserName() . '/recordings' ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <? foreach($range as $i): ?>
                        <li class="page-item"><a class="page-link" href="<?='/user/' . $user->getUserName() . '/recordings/' . strval($i)?>"><?=strval($i)?></a></li>
                    <? endforeach; ?>
                    <li class="page-item">
                        <a class="page-link" href="<?='/user/' . $user->getUserName() . '/recordings/' . strval($farthestPage)?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>