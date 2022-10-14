<section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="display-5 fw-bold">Explore</h1>
        <p class="lead text-muted">Explore and discover new videos which are brand new released!</p>

      </div>
    </div>
  </section>
  
  <hr class="hr hr-blurry" />

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