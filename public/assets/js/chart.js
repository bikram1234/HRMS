
var projectStatusCtx = document
.getElementById("projectStatusChart")
.getContext("2d");
var projectStatusChart = new Chart(projectStatusCtx, {
type: "doughnut", // Use the doughnut chart type
data: {
	labels: ["Balance", "Approved", "In-Progress"],
	datasets: [
		{
			data: [80, 15, 30], // Replace with your actual data values
			backgroundColor: ["#0C76B4", "#E8A24B", "#FCCF4D"],
		},
	],
},
options: {
	cutout: "60%", // Adjust the cutout to control the size of the inner circle
	legend: {
		position: "right",
	},
},
});


var projectStatusCtx = document
.getElementById("EarnedChart")
.getContext("2d");
var projectStatusChart = new Chart(projectStatusCtx, {
type: "doughnut", // Use the doughnut chart type
data: {
	labels: ["Balance", "Approved", "In-Progress"],
	datasets: [
		{
			data: [80, 20, 25], // Replace with your actual data values
			backgroundColor: ["#0C76B4", "#E8A24B", "#FCCF4D"],
		},
	],
},
options: {
	cutout: "60%", // Adjust the cutout to control the size of the inner circle
	legend: {
		position: "right",
	},
},
});




// Bar-chart

var xValues = [
  "BL",
  "CL",
  "EL",
  "EOL",
  "ML",
  "PL",
  "SL",
  "MTL",
];
var yValues = [70, 60, 70, 60, 55, 49, 44, 24];
var barColors = [
  "#0b62a4",
  "#40b8ef",
  "#406BEE",
  "#8bef40",
  "#efcc40",
  "#ef9d40",
  "#098c69",

  "#82607d",
];

new Chart("myChart", {
  type: "pie",
  data: {
	labels: xValues,
	datasets: [
	  {
		backgroundColor: barColors,
		data: yValues,
	  },
	],
  },
  options: {
	title: {
	  display: true,
	  text: "On Leave",
	},
  },
});




