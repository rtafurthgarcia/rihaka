<div class="container-fluid text-center bg-dark text-light">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 pb-4">
                <h1 class="display-4 fw-normal">Kinkshame your local scriptkiddie</h1>
                <p class="lead fw-normal">Why fear them when you can laugh at them?</p>
                <a class="btn btn-outline-secondary" href="#">Plz I wanna setup my own honeypot now</a>
            </div>
            <div class="col-12 col-lg-6 container shadow p-0 m-0 pb-5">
                <div class="console-header row d-flex justify-content-end align-items-center">
                    <i class="bi bi-dash-lg col-1"></i>
                    <i class="bi bi-square col-1"></i>
                    <i class="bi bi-x-lg col-1"></i>
                </div>
                <div class="row">
                    <div class="col p-0 m-0" id="demo"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/asciinema-player.min.js"></script>
<script>
    AsciinemaPlayer.create('/videos/demo.cast', document.getElementById('demo'), {
        autoPlay: true, 
        loop: true,
        speed: 2,
        fit: "height"
    });
</script>