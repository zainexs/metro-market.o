<!-- MODAL "PURCHASES" -->
<div class="modal fade" id="purchases" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Мои покупки</h5>
        <button type="button" class="close" data-dismiss="modal"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table  class="table-responsive-sm table table-striped- table-bordered table-hover table-checkable">
  <thead>
    <tr>
      <th scope="col">ID покупки</th>
      <th scope="col">Название</th>
      <th scope="col">Купленный товар</th>
      
    </tr>
  </thead>
  <tbody id="purchase">
      
    <?php 
while($row = mysqli_fetch_array($all_purchases)) {
 
$id = $row['id'];
$name = $row['name'];
$tovar = $row['tovar'];
echo '<tr>
      <th scope="row">'.$id.'</th>
      <td>'.$name.'</td>
      <td>'.$tovar.'</td>
    </tr>';

  }
?>

 </tbody>
 </table>
      </div>
     
      <div class="modal-footer">
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
       
      </div>
    </div>
  </div>
</div>