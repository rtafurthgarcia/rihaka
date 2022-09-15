<div class="container-fluid text-center bg-dark text-light">
    <div class="container">
        <div class="d-flex pb-4">
            <div>
                <h1 class="display-4 fw-normal">Kinkshame your local scriptkiddie</h1>
                <p class="lead fw-normal">Why fear them when you can laugh at them?</p>
                <a class="btn btn-outline-secondary" href="#">Plz I wanna setup my own honeypot now</a>
            </div>
            <div class="img-fluid w-50 shadow rounded-3" id="demo"></div>
        </div>
    </div>
</div>

<script src="/js/asciinema-player.min.js"></script>
<script>
    AsciinemaPlayer.create('/videos/demo.cast', document.getElementById('demo'), {
        autoPlay: true, 
        loop: true,
        preload: true,
        terminalFontSize: "12px",
        fit: "none"
    });
</script>