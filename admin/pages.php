<?php 
session_start();
include("../config/index.php");

if($_SESSION['username'] =='')
{
	header("Location: ".$SITE_URL."/admin/login.php");
	die();
}

include("./class/Page.php");
$pageObject = new Page($dbObject);

include("./class/Cars.php");
$cars = new Cars($dbObject);

include ("./layouts/header.php");
include ("./layouts/navbar.php");
include ("./layouts/sidebar.php");

$items = $pageObject->getAllpageDetails();
	
?> 
<main>
    <div class="container-fluid px-4">
        
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Pages</h1>
			</div>
            <div class="col-md-6 text-right">
                <a class="btn btn-primary mt-4" href="<?php echo $SITE_URL; ?>/admin/page-creator.php">Add New</a>
			</div>
		</div>
		
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Pages
			</div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Show On Menu</th>
                            <th>Action</th>
						</tr>
					</thead>
                    <tbody>
                        <?php 
							foreach($items as $item) 
							{
							?>
                            <tr>
                                <td> <?php echo $item['title']; ?>
								</td>
                                <td><?php echo $item['slug']; ?></td>
								<td><?php if($item['showonmenu']) { echo 'Yes'; } else { echo 'No'; } ?></td>
                                <td>
									<a class="btn btn-primary edit-button" href="<?php echo $SITE_URL; ?>/admin/page-creator.php?id=<?php echo $item['page_id']; ?>">Edit</a>&nbsp;
									<a class="btn btn-dark edit-button"onclick="deletepage(`<?php echo $item['page_id']; ?>`)">Delete</a></td>
							</tr>
                            <?php 
							}
						?>
					</tbody> 
				</table>
			</div>
			<div id="dynamic-toast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div id="toast-body" class="toast-body"></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                <div id="global-loader" class="loader-hidden">
                    <div class="bounce">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
		</div>
	</main>
	<script>
		
		// FUNCTION FOR TOASTER.
		function showToast(message, type) {
			const toast = new bootstrap.Toast(document.getElementById('dynamic-toast'));
			const toastBody = document.getElementById('toast-body');
			const toastElement = document.getElementById('dynamic-toast');
			
			// SET MESSAGE TEXT.
			toastBody.textContent = message;
			
			// SET BACKGROUND COLOR BASED ON TYPE.
			if (type === 'success') {
				toastElement.classList.remove('bg-danger', 'bg-primary');
				toastElement.classList.add('bg-success');
				} else if (type === 'error') {
				toastElement.classList.remove('bg-success', 'bg-primary');
				toastElement.classList.add('bg-danger');
				} else {
				toastElement.classList.remove('bg-success', 'bg-danger');
				toastElement.classList.add('bg-primary');
			}
			
			// SHOW THE TOAST.
			toast.show();
		}
		
		
		// FUNCTION TO CALL AJAX TO INSERT FORM DATA.
		function deletepage(deleteId) {
			event.preventDefault();
			if(deleteId == '') {
				showToast('Delete id is required', 'error');
				return;
			}
			$.ajax({
				url: "<?php echo $SITE_URL; ?>/admin/ajax/delete_page.php",
				data: {
					page_id: deleteId,
				},
				success: function(response) {
					if (response.success == true) {
						showToast(response.message, 'success');
						setTimeout(() => {
							window.location.href = '<?php echo $SITE_URL; ?>/admin/pages.php';
						}, 500);
					} else {
						showToast(response.message, 'error');
					}
				},
				error: function(xhr, status, error) {
					showToast('Something went wrong.', 'error');
				}
			});
		}
	</script>
	<?php include("./layouts/footer.php"); ?>
