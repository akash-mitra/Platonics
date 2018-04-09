@extends('layouts.admin')

@section('aside')
	@include('partials.admin.menu', ["dashboard" => true])
@endsection


@section('header')
	@include('partials.admin.breadcrumb')
@endsection

@section('main')
	
<div class="row mb-5">
	<div class="col-md-12">
		<h2>Dashboard</h2>
		<p>
			Quick access to effective analytics about your blog
		</p>
		<hr>
	</div>

	<div class="col-md-12">
		<div class="carsd">
			<div class="card-body">
				<h6>How are we growing?</h6>
				<canvas id="chartCanvas"></canvas>
			</div>
		</div>
	</div>
</div>
	
@endsection

@section('page.script')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

	<script>
		const ctx = document.getElementById('chartCanvas').getContext('2d');
		const data = {
			// Labels should be Date objects
			labels: [
				@foreach($xData as $data)
					{{ 'new Date(' . $data['year'] . ',' . $data['month'] . ',' . $data['day'] . '),' }}
				@endforeach
			],
			datasets: [
				{
					fill: false,
					label: 'Pages Created',
					data: [{{ implode(',', $yDataPage) }}],
					borderColor: '#fe8b36',
					backgroundColor: '#fe8b36',
					lineTension: 0,
				},
				{
					fill: false,
					label: 'Users Joined',
					data: [{{ implode(',', $yDataUser) }}],
					borderColor: 'dodgerblue',
					backgroundColor: 'dodgerblue',
					lineTension: 0,
				}
			]
		}
		const options = {
			type: 'line',
			data: data,
			options: {
				fill: false,
				responsive: true,
				scales: {
					xAxes: [{
						type: 'time',
						display: true,
						scaleLabel: {
							display: true,
							labelString: "Date",
						}
					}],
					yAxes: [{
						ticks: {
							beginAtZero: true,
						},
						display: true,
						scaleLabel: {
							display: true,
							labelString: "Number(s) of",
						}
					}]
				}
			}
		}
		const chart = new Chart(ctx, options);
	</script>
@endsection