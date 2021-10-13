$(document).ready(function(){
	$.ajax({
		url: "http://phpcourse.com/Personal_projects/datajan.php",
		type: "GET",
		success : function(datajan){
			console.log(datajan);
	  
			var item = {
			 realized_cost: []
			};
	  
			var len = datajan.length;
	  
			for (var i = 0; i < len; i++) {
			  if (datajan[i].display == "realized_cost") {
				realized_cost.item.push(datajan[i].realized_cost);
			  }
		
	  
			//get canvas
			var ctx = $("#line-chartcanvas");
	  
			var datajan = {
			  labels : ["Água", "match2", "match3", "match4", "match5",
			  "Água", "match2", "match3", "match4", "match5", "test" ],
			  datasets : [
			
				{
					label : "Custo realizado",
					data : realized_cost.item,
					backgroundColor : "green",
					borderColor : "lightgreen",
					fill : false,
					lineTension : 0,
					pointRadius : 5
				  }
			  ]
			};
	  
			var options = {
			  title : {
				display : true,
				position : "top",
				text : "Previsão dos custos",
				fontSize : 28,
				fontColor : "#111"
			  },
			  legend : {
				display : true,
				position : "bottom"
			  }
			};
	  
			var chart = new Chart( ctx, {
			  type : "line",
			  data : datajan,
			  options : options
			} );
	  
		  }
		  }
		});
	  
	  });