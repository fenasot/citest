var datas11 = [
	{ x: "2000-08-01T00:50:00Z", y: 10 },
	{ x: "2000-08-01T03:20:00Z", y: 15 },
	{ x: "2000-08-01T08:10:00Z", y: 30 },
	{ x: "2000-08-01T10:00:00Z", y: 5 },
];
var datas12 = [
	{ x: "2000-08-01T00:00:00Z", y: 18 },
	{ x: "2000-08-04T00:00:00Z", y: 2 },
	{ x: "2000-08-05T00:00:00Z", y: 32 },
	{ x: "2000-08-05T00:00:00Z", y: 5 },
];
var datas13 = [
	{ x: "2000-08-01T00:00:00Z", y: 7 },
	{ x: "2000-08-04T00:00:00Z", y: 15 },
	{ x: "2000-08-05T00:00:00Z", y: 16 },
	{ x: "2000-09-05T00:00:00Z", y: 29 },
];
var options = {
	series: [
		{
			name: "O2",
			data: datas11,
		},
		{
			name: "PM2.5",
			data: datas11,
		},
		{
			name: "CO2",
			data: datas11,
		},
	],
	chart: {
		height: 450,
		width: 545,
		type: "line",
		zoom: {
			enabled: false,
		},
		toolbar: {
			show: false,
		},
		events: {
			dataPointSelection: (event, chartContext, config) => {
				var selecteddate = pad(config.dataPointIndex + 1, 2);
				console.log(selecteddate);
			},
		},
	},
	dataLabels: {
		enabled: false,
	},
	stroke: {
		width: [5, 7, 5],
		curve: "straight",
		dashArray: [0, 8, 5],
	},
	title: {
		text: "Page Statistics",
		align: "left",
	},
	legend: {
		tooltipHoverFormatter: function (val, opts) {
			return (
				val +
				" - " +
				opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
				""
			);
		},
	},
	markers: {
		size: 0,
		hover: {
			sizeOffset: 6,
		},
	},
	xaxis: {
		labels: {
			datetimeFormatter: {
				year: "yyyy/MM",
				month: "MM/dd ",
				day: "MM/dd ",
				hour: "dd 'HH:mm",
			},
		},
		type: "datetime",
	},
	tooltip: {
		followCursor: false,
		fixed: {
			enabled: true,
			position: "topRight",
		},
		x: {
			format: "MM/dd 'HH:mm",
		},
		y: [
			{
				title: {
					formatter: function (val) {
						return val + " (score)";
					},
				},
			},
			{
				title: {
					formatter: function (val) {
						return val + " (score)";
					},
				},
			},
			{
				title: {
					formatter: function (val) {
						return val + " (score)";
					},
				},
			},
		],
	},
	grid: {
		borderColor: "#f1f1f1",
	},
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

//測試


componentDidMount = () => {
	const labels = document.querySelectorAll(
		".apexcharts-text.apexcharts-yaxis-label"
	);

	labels.forEach((item) => {
		item.addEventListener("click", (event) => {
			// do whatever onClick
			console.log(event.target);
		});
	});
};
