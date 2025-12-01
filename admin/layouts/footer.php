<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <!-- <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website <?php echo date('Y'); ?></div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div> -->
    </div>
</footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script src="<?php echo $SITE_URL; ?>/admin/assets/js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#datatablesSimple').DataTable({
        "pageLength": 10,
        "lengthMenu": [[5, 10, 15, 20, 25, 50, 100], [5, 10, 15, 20, 25, 50, 100]],
        "language": 
        {
            "search": "Search all columns:",
            "lengthMenu": "Show _MENU_ entries per page",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No entries found",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": 
            {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "responsive": true,
        "order": [[ 0, "asc" ]],
        "columnDefs": 
        [
            { 
                "orderable": false, 
                "targets": -1 
            }
        ]
    });
});
</script>
<script src="<?php echo $SITE_URL; ?>/admin/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '.ckeditor',
    height: 400,
    menubar: true,
    plugins: 'image code link lists media table',
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image code',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    images_upload_url: '<?php echo $SITE_URL; ?>/admin/ajax/upload-editor-image.php', // Custom upload handler
    automatic_uploads: true,
    images_upload_credentials: false,
    images_upload_handler: function (blobInfo, success, failure) 
    {
        console.log('upload content image');
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo $SITE_URL; ?>/admin/ajax/upload-editor-image.php');
        xhr.onload = function() 
        {
            if (xhr.status != 200) 
            {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            var json = JSON.parse(xhr.responseText);
            console.log('images_upload_handler', json);
            if (!json || typeof json.location != 'string') 
            {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }
});
</script>
</body>

</html>