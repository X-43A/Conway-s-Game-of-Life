<!DOCTYPE html>
<html>
<head>
	<title>game of pi</title>
</head>
<body>
	<table id="board" border="1" style="border: 1px solid white; border-collapse:collapse; width: 500px; height: 500px;">
	<?php 
		$cellsY = 100;
		$cellsX = 100;

		for($y = 0 ; $y < $cellsY ; $y++){
			echo("<tr>");
			for($x = 0 ; $x < $cellsX ; $x++){
				echo("<td ".(($x==0 || $y==0 || $y==$cellsY-1 || $x==$cellsX-1) ? "" : "onclick='setCell(this.id);'")." id='".$y." ".$x."'></td>");
			}
			echo("</tr>");
		}
	?>
	</table>
	<script type="text/javascript">
		var height = 500;
		var width = 500;
		let cellsY = <?php echo($cellsY);?>;
		let cellsX = <?php echo($cellsX);?>;

		var cellsLife = new Array(cellsY);

		for (var i = 0; i < cellsY; i++) {
  			cellsLife[i] = new Array(cellsX);
  			for(var j = 0 ; j < cellsX ; j++){
  				cellsLife[i][j] = 0;
  			}
		}

		function setCell(id){
			ids = id.split(" ");

			if(cellsLife[ids[0]][ids[1]]){
				document.getElementById(id).style.backgroundColor = "";
				cellsLife[ids[0]][ids[1]] = 0;
			}else{
				document.getElementById(id).style.backgroundColor = "black";
				cellsLife[ids[0]][ids[1]] = 1;
			}
		}

		function checkNeighbours(cell){
			var neighbours = cellsLife[cell[0]+1][cell[1]] + cellsLife[cell[0]-1][cell[1]] + cellsLife[cell[0]][cell[1]-1] + cellsLife[cell[0]+1][cell[1]-1] + cellsLife[cell[0]-1][cell[1]-1] + cellsLife[cell[0]][cell[1]+1] + cellsLife[cell[0]+1][cell[1]+1] + cellsLife[cell[0]-1][cell[1]+1];

			if( ( neighbours <= 1 || neighbours >= 4 ) && cellsLife[cell[0]][cell[1]]){
				dyingCells.push([cell[0], cell[1]]);
			}else if( neighbours == 3 && !cellsLife[cell[0]][cell[1]]){
				borningCells.push([cell[0], cell[1]]);
			}
		}

		function updateCellsLife(){
			for(var i = 0 ; i < dyingCells.length ; i++){
				cellsLife[dyingCells[i][0]][dyingCells[i][1]] = 0;
			}
			for(var i = 0 ; i < borningCells.length ; i++){
				cellsLife[borningCells[i][0]][borningCells[i][1]] = 1;
			}
			borningCells = [];
			dyingCells = [];
		}

		var dyingCells = [];
		var borningCells = [];

		var animation;

		function start(){
			animation = setInterval( function(){
				for(var y = 1 ; y < cellsY-1 ; y++){
					for(var x = 1 ; x < cellsX-1 ; x++){
						if(cellsLife[y][x]){
							document.getElementById(y+" "+x).style.backgroundColor = "black";
						}else{
							document.getElementById(y+" "+x).style.backgroundColor = "";
						}
						checkNeighbours([y,x]); 
					}
				}
				updateCellsLife();
			}, 200);
		}

		var clicked = true;
		function startStopClick(id){
			if(clicked){
				start();
				document.getElementById(id).innerHTML = "STOP";
			}else{
				clearInterval(animation);
				document.getElementById(id).innerHTML = "START";
			}
			clicked = !clicked;
		}
	</script>
	
	<button id="startStop" onclick="startStopClick(this.id)">START</button>
	<button onclick="width -= 100; height -= 100; document.getElementById('board').style.width = width+'px'; document.getElementById('board').style.height = height+'px';">-</button>
	<button onclick="width += 100; height += 100; document.getElementById('board').style.width = width+'px'; document.getElementById('board').style.height = height+'px';">+</button>
</body>
</html>