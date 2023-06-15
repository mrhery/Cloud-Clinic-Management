<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Users

        <a href="<?= PORTAL ?>customers/add" class="btn btn-primary btn-sm">
            <span class="fa fa-plus"></span> Add new Customer
        </a>
    </div>

    <div class="card-body">
        <table class="table dataTable table-fluid table-hover">
            <thead>
                <tr>
                    <th width="5%">No </th>
                    <th class="text-center">Name </th>
                    <th class="text-center">IC</th>
                    <th class="text-right" width="5%">:::</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach (customers::list() as $c) {
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $c->c_name ?></td>
                        <td class="text-center"><?= $c->c_ic ?></td>
                        <td class="text-right">
                            <a href="<?= PORTAL ?>customers/edit/<?= $c->c_ukey ?>" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>