<div class="container mt-5">
        <h1>Details</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-primary" style="border-bottom: 1px solid;">Sl No</th>
                    <?php foreach ($submitted_data['columns'] as $key => $col) { ?>
                    <th class="text-primary" style="border-bottom: 1px solid;"><?php echo $col['label']; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submitted_data['data'] as $dkey => $d) { ?>
                <tr>
                    <td><?php echo ($dkey + 1); ?></td>
                    <?php foreach ($submitted_data['columns'] as $key => $col) { ?>
                    <td><?php echo $d[$col['name']]; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>