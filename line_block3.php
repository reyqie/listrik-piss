<?php
	include "connection.php";
	function getBlock(){
		$query 	= "select block_id from block order by block_id desc";
		$data=mysql_query($query);
		$string="'";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string="','".$string;
			}
			$string=$row['block_id'].$string;
			$counter++;
		}
		return "'".$string;
	}
	function getTotal(){
		$query 	= "select sum(lapak_size) as total, block_id from lapak group by block_id desc";
		$data=mysql_query($query);
		$string="";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=" , ".$string;
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
			$('#block3').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: 'Luas Per Block',
					x: -20 //center
				},
				xAxis: {
					categories: [<?php echo getBlock(); ?>]
				},
				yAxis: {
					min: 0,
					tickInterval: 500,
					labels: {
						style: {
							color: 'rgba(119, 119, 119, 1)'
						}
					},
					title: {
						text: 'M2'
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
									/*//alert(this.category+' / '+ this.x +' was last selected');
									var str = this.category;
									//nres = (this.category).substring(2, 2);
									var x = str.substring(1,3);
									callDetailDay(x);
									//alert(x);*/
									
									var str = this.category;
									var day = str.substring(1,11);
									callDaySales(this.category);
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
					valueSuffix: ' M2'
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Luas',
					marker: {
						symbol: 'circle'
					},
					data: [<?php echo getTotal(); ?>]

				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<div id="block3" style="min-width: 200px; max-width: 600px; height: 200px; margin: 0 auto"></div>
	</div>
</div>