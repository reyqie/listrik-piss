<?php
	include "connection.php";
	function getBlock(){
		$query 	= "select block_id, block_max from block order by block_id desc";
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
		$query 	= "select block_id, block_max from block order by block_id desc";
		$data=mysql_query($query);
		$string="";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string=" , ".$string;
			}
			$string=$row['block_max'].$string;
			$counter++;
		}
		return "".$string;
	}
?>
<script type="text/javascript">
	(function($){ // encapsulate jQuery
		$(function () {
			$('#containerDay2').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: 'Total Block PIOS',
					x: -20 //center
				},
				xAxis: {
					categories: [<?php echo getBlock(); ?>]
				},
				yAxis: {
					min: 0,
					tickInterval: 50,
					labels: {
						style: {
							color: 'rgba(119, 119, 119, 1)'
						}
					},
					title: {
						text: 'Unit Lapak'
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
					valueSuffix: ' Unit Lapak'
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Total Block',
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
		<div id="containerDay2" style="min-width: 200px; max-width: 600px; height: 200px; margin: 0 auto"></div>
	</div>
</div>