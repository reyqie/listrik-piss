<?php
	include "connection.php";
	function getBlock(){
		$query 	= "select distinct(block_id) as block, count(lapak_status) as total
		from lapak where lapak_status='kosong'
		group by block_id desc";
		$data=mysql_query($query);
		$string="'";
		$counter=0;
		while($row=mysql_fetch_array($data)){
			if($counter!=0){
				$string="','".$string;
			}
			$string=$row['block'].$string;
			$counter++;
		}
		return "'".$string;
	}
	function getTotal(){
		$query 	= "select distinct(block_id), count(lapak_status) as total
		from lapak where lapak_status='kosong'
		group by block_id desc";
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
	function getTotal2(){
		$query 	= "select distinct(block_id) as block, count(lapak_status) as total
		from lapak where lapak_status='Terisi'
		group by block_id desc";
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
			$('#block4').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: 'Status Lapak Per Block',
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
						text: 'Unit'
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
					valueSuffix: ' Unit'
				},
				credits: {
					enabled: false
				},
				series: [{
					name: 'Kosong ',
					marker: {
						symbol: 'circle'
					},
					color: '#d9534f',
					data: [<?php echo getTotal(); ?>]
				}, {
					name: 'Terisi ',
					marker: {
						symbol: 'circle'
					},
					data: [<?php echo getTotal2(); ?>]
				}]
			});
		});
	})(jQuery);
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<div id="block4" style="min-width: 200px; max-width: 600px; height: 200px; margin: 0 auto"></div>
	</div>
</div>