
Supplier
<div class="card">
    <div class="card-header">
      
    <a href="<?= PORTAL ?>billing/supplier/list" class="btn btn-sm btn-primary">
      <span class="fa fa-arrow-left"></span> Back
    </a>
    </div>
    
    <div class="card-body">
    <?php
      $i = clients::getBy(["c_key" => url::get(3)]);
      
      if(count($i)){
        $i = $i[0];
    ?>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">
            <h3>Are you sure?</h3>
            <p>
              Click the button to delete <strong><?= $i->c_name ?></strong> permanently.
            </p>
          </div>
          
          <div class="col-md-12 text-center">
          <?php
            Controller::Form("clients", [
              "action"  => "delete"
            ]);
          ?>
            <button class="btn btn-danger btn-sm" >
              <span class="fa fa-trash"></span> Delete
            </button>
          </div>
        </div>
      </form>
    <?php
      }else{
        
      }
    ?>
    </div>
    
  </div>