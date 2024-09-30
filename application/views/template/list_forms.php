<style>

td {
    word-wrap: break-word;  /* Allows long text to wrap */
    word-break: break-word; /* Prevents text overflow */
    max-width: 200px;       /* Set a max width for the column to enforce wrapping */
    white-space: normal !important;    /* Ensure normal line breaks */
}
    </style>
<div class="container mt-5">
        <h1>List of Forms</h1>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>S.no</th>
                    <th>Form Title</th>
                    <th>Form Subject</th>
                    <th>Added By</th>
                    <th>Added Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($forms)): ?>
                    <?php foreach ($forms as $index => $form): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $form['title']; ?></td>
                            <td><?php echo $form['subject']; ?></td>
                            <td><?php echo $form['first_name']; ?> <?php echo $form['last_name']; ?></td>
                            <td><?php echo $form['datetime']; ?></td>
                            <td>
                                <a href="<?php echo site_url('FormController/render_form/' . $form['id']); ?>" class="btn btn-info btn-sm">View form</a>
                                <a href="<?php echo site_url('FormController/view_form_data/' . $form['id']); ?>" class="btn btn-secondary btn-sm">View data</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No forms available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>