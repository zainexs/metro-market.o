<!-- MODAL "DEPOSIT" -->
<div class="modal fade" id="deposit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Пополнение счета</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <div class="form-group">
          <label for="tovar_name">Сумма пополнения</label>
          <input type="text" class="form-control col-12" id="deposit_size" style="width:100%;" placeholder="Сумма">
          </div>


        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          <button type="button" class="btn btn-primary" onclick="deposit()">Пополнить</button>
        </div>
      </div>
    </div>
  </div>