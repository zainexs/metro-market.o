<!-- MODAL "PROMOKOD" -->
<div class="modal fade" id="promokod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Активация промокодов</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form action="/action.php" method="post" class="form-group">
                    <label for="tovar_name">Введите промокод:</label>
                    <input type="text" id="code" name="code" class="form-control" style="width:100%;">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-primary" data-dismiss="modal" value="Активировать">
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>