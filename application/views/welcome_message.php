<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>Chart Pitjarus</title>
</head>
<body>

<div class="container" style="margin-top: 2%; margin-bottom: 2%;">
	<div class="card">
        <div class="card-header">
			<!-- <form action="" id="form"> -->
				<div class="row" style="display: flex; justify-content: center;">
					<div class="col-md-3">
					<?= form_open(base_url('welcome/filterdata')); ?>
						<select name="select_area" id="area" class="form-control">
							<option value="">Select Area</option>
							<?php foreach ($area as $key => $value) { ?>
          					<option><?= $value->area_name ?></option>
        					<?php } ?>
						</select>
					</div>
					<div class="col-md-3">
						<input name="start_date" class="form-control" type="text" 
							placeholder="Select dateFrom"
                            onfocus="(this.type='date')">
					</div>
					<div class="col-md-3">
						<input name="end_date" class="form-control"  type="text" 
						placeholder="Select dateTo"
                        onfocus="(this.type='date')">
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-secondary" style="padding: 5px 60px;">View</button>
					</div>
					<?= form_close(); ?>
				</div>
			<!-- </form> -->

			<div class="row d-flex justify-content-center">
				<div class="card-body">
					<canvas id="bar" height="100"></canvas>
				</div>
			</div>
			<div class="row mt-5 d-flex justify-content-center">
				<div class="card" id="table-card">
					<div class="table-responsive scrollbar-custom">
						<table id="datatable" class="table table-striped table-hover">
							<thead>
								<tr>
									<th style="width: 200px;">Brand</th>
									<?php foreach ($data as $key => $value) { ?>
									<th style="width: 200px;"><?= $value->area_name ?></th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= $value->brand_name ?></td>
									<?php foreach ($data as $key => $value) { ?>
									<td><?= $value->percent ?>%</td>
									<?php } ?>
								</tr>
								<tr>
									<td><?= $value->brand_name ?></td>
									<?php foreach ($data as $key => $value) { ?>
									<td><?= $value->percent ?>%</td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>

	const baseUrl = "<?= base_url();?>";
	var area_id = "<?= $area_id?>";
	var start_date = "<?= $start_date?>";
	var end_date = "<?= $end_date?>";
	console.log(area_id);

	const chartArea = (chartType) => {
		$.ajax({
		url: baseUrl +'index.php/welcome/chart_data',
		data: {area_id : area_id, start_date: start_date, end_date:end_date},
		dataType: 'json',
		method: 'POST',
		success: data => {
			console.log (data)
			let chartX = []
			let chartY = []
			data.map( data => {
					chartX.push(data.area_name)
					chartY.push(data.percent)
			})
			const chartData = {
				labels: chartX,
				datasets: [
					{
						label: 'Percentage',
						data: chartY,
						backgroundColor: ['skyblue'],
						borderColor: ['skyblue'],
						borderWidth: 4
					}
				]
			}
			const ctx = document.getElementById(chartType).getContext('2d')
			const config = {
				type: chartType,
				data: chartData
			}
			const chart = new Chart(ctx, config)
		}
	})
	}

	chartArea('bar')

</script>
</body>
</html>
