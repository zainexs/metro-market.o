<!-- Modal "ADD"-->
<div class="modal fade" id="open_it" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Покупка товара</h5>
        <button type="button" class="close" data-dismiss="modal" id="close_add" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="thumbnail">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" id="prev-1" src="" alt="">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" id="prev-2" src="" alt="">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" id="prev-3" src="" alt="">
    </div>
  </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="caption">
<p class="game-name" id="sel_name"></p>
<p class="game-type" id="sel_desc"><img src="/img/icon.png" class="game-activate-icon"></p>
<p><span class="game-name" id="sel_cost"></span></p>
</div>
</div>
</div>
     
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary" id="confirm" onclick="buy()" >Купить</button>
      </div>
    </div>
  </div>
</div>
