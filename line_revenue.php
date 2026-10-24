<?php
	include "connection.php";
	
	function getDay(){
		$query 	= "select sum(pay_total) as total, periode_id
		from e_pay where pay_sts = 'Lunas'
		group by periode_id order by periode_id desc limit 7";
		$data=mysql_query($query);
		$string="'";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string = "','".$string;
			}
			$pname		= executeScalar("select periode_name from e_periode where periode_id = '".$row['periode_id']."'");
			$string		= $pname.$string;
			$counter++;
		}
		return "'".$string;
	}
	function getTotal(){
		$query 	= "select sum(pay_total) as total, periode_id
		from e_pay where pay_sts = 'Lunas'
		group by periode_id order by periode_id desc limit 7";
		$data=mysql_query($query);
		$string="";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=",".$string;
			}
			$string=$row['total'].$string;
			$counter++;
		}
		return "".$string;
	}
?>
<script type="text/javascript">
	(function($){ // encapsulate jQuery
		$(function () {
			$('#revenue').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: 'Pendapatan Listrik (Terbayar)',
					x: -20 //center
				},
				xAxis: {
					categories: [<?php echo getDay(); ?>]
				},
				yAxis: {
					min: 0,
					labels: {
						formatter: function() {
							return (Math.abs(this.value) / 1000000) + ' Juta';
						},
						style: {
							color: 'rgba(119, 119, 119, 1)'
						}
					},
					title: {
						text: ' Rupiah'
						//enabled : false
					}
				},
				plotOptions: {
					line: {
						dataLabels: {
							enabled: false
						},
						enableMouseTracking: true
					},
					column: {
						dataLabels: {
							enabled: false
						},
						enableMouseTracking: true,
						pointWidth: 20
					},
					series: {
						allowPointSelect: true,
						point: {
							events: {
								click: function() {
									//alert(this.category+' / '+ this.x +' was last selected');
									callTonase(this.category);
									/*var str = this.category;
									//nres = (this.category).substring(2, 2);
									var x = str.substring(1,3);
									callDetailDay(x);
									//alert(x);*/
									
									/*var str = this.category;
									var day = str.substring(1,11);
									callDaySales(this.category);*/
								}
							}
						}
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -3,
					y: 15,
					floating: true,
					borderWidth: 1,
					backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
					shadow: true
				},
				tooltip: {
					crosshairs: true,
					shared: true,
					valueSuffix: ' Rupiah'
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Total Pendapatan',
					marker: {
						symbol: 'circle'
					},
					data: [<?php echo getTotal(); ?>]

				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-primary">
	<div class="panel-body">
		<div id="revenue" style="min-width: 400px; max-width: 600px; height: 255px; margin: 0 auto"></div>
	</div>
</div>