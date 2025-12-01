<?php 
session_start();
include("../config/index.php");

if($_SESSION['username'] =='')
{
	header("Location: ".$SITE_URL."/admin/login.php");
	die();
}

include ("./class/Dashboard.php");

$dashboardObj = new Dashboard($dbObject);

include ("./layouts/header.php");
include ("./layouts/navbar.php");
include ("./layouts/sidebar.php");

if(isset($_SESSION['username'])) {
	$availablecars = $dashboardObj->getCarsAvailable();
	$soldcars = $dashboardObj->getCarsSold();
	$totalsale = $dashboardObj->getTotalSale();
	$totalprofit = $dashboardObj->getTotalProfit();
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<main>
    <div class="container-fluid px-4">
		
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Dashboard</h1>
			</div>
            <div class="col-md-6 text-right">
			</div>
		</div>
		
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-bar-chart me-1"></i> Business Overview
			</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="box box1">
                            <h4>Cars Available</h4>
                            <div><?php echo $availablecars;?></div>
						</div>
					</div>
                    <div class="col-md-3 text-center">
                        <div class="box box2">
                            <h4>Cars Sold</h4>
                            <div><?php echo $soldcars;?></div>
						</div>
					</div>
                    <div class="col-md-3 text-center">
                        <div class="box box3">
                            <h4>Total Sale</h4>
                            <div><?php echo $_SESSION['currency'];?><?php echo number_format($totalsale);?></div>
						</div>
					</div>
                    <div class="col-md-3 text-center">
                        <div class="box box4">
                            <h4>Total Profit</h4>
                            <div><?php echo $_SESSION['currency'];?><?php echo number_format($totalprofit);?></div>
						</div>
					</div>
				</div>
                <div class="row mt30">
                    <div class="col-md-6">
                        <canvas id="saleschart"></canvas>
					</div>
                    <div class="col-md-6">
                        <canvas id="revenuechart"></canvas>
					</div>
				</div>
                <div class="row mt30">
                    <div class="col-md-6">
                        <canvas id="makeSaleschart"></canvas>
					</div>
                    <div class="col-md-6">
                        <canvas id="makeInventorychart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script>
		// LOAD SALES LINE CHART
		function loadSalesChart(response) {
			
			const ctx = document.getElementById('saleschart').getContext('2d');
			const myLineChart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: response.months, // X-axis labels
					datasets: [{
						label: 'Cars',
						data: response.carsCount, // Y-axis data
						fill: false,
						borderColor: 'rgb(75, 192, 192)',
						tension: 0.1
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							display: true
						},
						title: {
							display: true,
							text: 'Sales'
						}
					},
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		}
		
		// LOAD REVENUE BAR CHART
		function loadRevenueChart(response) {
			const ctx = document.getElementById('revenuechart').getContext('2d');
			const myBarChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: response.months, // X-axis labels
					datasets: [{
						label: 'Sale',
						data: response.carSaleTotal, // Y-axis values
						backgroundColor: 'rgba(54, 162, 235, 0.6)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					},
					{
						label: 'Profit',
						data: response.carProfitTotal, // Y-axis values
						backgroundColor: 'rgba(54, 162, 235, 1)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					}
					]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							display: true
						},
						title: {
							display: true,
							text: 'Quarterly Revenue'
						}
					},
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		}
		
		// LOAD SALES PIE CHART
		function loadSalesPieChart(response) {
			// Generate 30 colors
			const backgroundColors = Array.from({ length: 8 }, () =>
			`hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`
			);
			
			const ctx = document.getElementById('makeSaleschart').getContext('2d');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: response.carsMakes,
					datasets: [{
						data: response.sales,
						backgroundColor: backgroundColors
					}]
				},
				options: {
					indexAxis: 'y', // 👈 This makes it horizontal
					responsive: true,
					plugins: {
						legend: {
							display: false // 👈 This hides the legend
						},
						title: {
							display: true,
							text: 'Sales by Make'
						}
					},
					scales: {
						x: {
							beginAtZero: true
						}
					}
				}
			});
		}
		
		
		// LOAD INVENTORY PIE CHART
		function loadInventoryPieChart(response) {
			// Generate 30 colors
			const backgroundColors = Array.from({ length: 6 }, () =>
			`hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`
			);
			const ctx = document.getElementById('makeInventorychart').getContext('2d');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: response.carsMakes,
					datasets: [{
						data: response.inventory,
						backgroundColor: backgroundColors,
						borderWidth: 1
					}]
				},
				options: {
					indexAxis: 'y', // 👈 This makes it horizontal
					responsive: true,
					plugins: {
						legend: {
							display: false // 👈 This hides the legend
						},
						title: {
							display: true,
							text: 'Inventory by Make'
						}
					},
					scales: {
						x: {
							beginAtZero: true
						}
					}
				}
			});
		}
		
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
		
		//loadSalesChart();
		//loadRevenueChart();
		//loadSalesPieChart();
		//loadInventoryPieChart();
	</script>
	<script>
        $(document).ready(function() {
            $.ajax({
                url: "<?php echo $SITE_URL; ?>/admin/ajax/get_saleschart_data.php",
                type: 'GET',
                success: function(response) {
                    try {
                        loadSalesChart(response);
					} catch (e) {
                        showToast('Invalid response from server.', 'error');
                        return;
					}
                    
				},
                error: function(xhr, status, error) {
                    showToast('Failed to load chart car count.', 'error');
				}
			});
			
			$.ajax({
                url: "<?php echo $SITE_URL; ?>/admin/ajax/get_saleschartprofit_data.php",
                type: 'GET',
                success: function(response) {
                    try {
                        loadRevenueChart(response);
					} catch (e) {
                        showToast('Invalid response from server.', 'error');
                        return;
					}
                    
				},
                error: function(xhr, status, error) {
                    showToast('Failed to load chart sale.', 'error');
				}
			});
			$.ajax({
                url: "<?php echo $SITE_URL; ?>/admin/ajax/makeSaleschart.php",
                type: 'GET',
                success: function(response) {
                    try {
                        loadSalesPieChart(response);
					} catch (e) {
                        showToast('Invalid response from server.', 'error');
                        return;
					}
                    
				},
                error: function(xhr, status, error) {
                    showToast('Failed to load chart sale.', 'error');
				}
			});
			$.ajax({
                url: "<?php echo $SITE_URL; ?>/admin/ajax/makeInventorychart.php",
                type: 'GET',
                success: function(response) {
                    try {
                        loadInventoryPieChart(response);
					} catch (e) {
                        showToast('Invalid response from server.', 'error');
                        return;
					}
                    
				},
                error: function(xhr, status, error) {
                    showToast('Failed to load chart sale.', 'error');
				}
			});
		});
	</script>	
	
<?php include("./layouts/footer.php"); ?>