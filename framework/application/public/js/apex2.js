var datas21 = [
	{ x: "2000-08-03T00:00:00Z", y: 10 },
	{ x: "2000-08-04T00:00:00Z", y: 15 },
	{ x: "2000-08-05T00:00:00Z", y: 30 },
	{ x: "2000-08-05T02:00:00Z", y: 5 },
];
var datas22 = [
	{ x: "2000-08-03T00:00:00Z", y: 10 },
	{ x: "2000-08-04T00:00:00Z", y: 10 },
	{ x: "2000-08-05T00:00:00Z", y: 25 },
	{ x: "2000-08-05T05:00:00Z", y: 8 },
];
var datas23 = [
	{ x: "2000-08-03T00:00:00Z", y: 10 },
	{ x: "2000-08-03T03:00:00Z", y: 13 },
	{ x: "2000-08-03T04:00:00Z", y: 25 },
	{ x: "2000-08-03T05:00:00Z", y: 8 },
];
var options = {
	series: [
		{
			name: "sensor1",
			data: datas23,
		},
		{
			name: "sensor2",
			data: datas23,
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
			show: true,
			tools: {
				download: false,
				selection: true,
				zoom: true,
				zoomin: true,
				zoomout: true,
				pan: true,
				reset: true,
				customIcons: [],
			},
			autoSelected: "zoom",
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
		x: {
			format: "MM/dd 'HH:mm",
		},
		y: [
			{
				title: {
					formatter: function (val) {
						return val + " (units)";
					},
				},
			},
			{
				title: {
					formatter: function (val) {
						return val + " (units)";
					},
				},
			},
			{
				title: {
					formatter: function (val) {
						return val + " (units)";
					},
				},
			},
		],
	},
	grid: {
		borderColor: "#f1f1f1",
	},
};

var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
chart2.render();
