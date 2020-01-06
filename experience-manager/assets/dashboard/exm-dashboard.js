webtools.domReady(function () {

	var main_chart = c3.generate({
		bindto: '#webtools #chart',
		data: {
			columns: [
				['data1', 30, 200, 100, 400, 150, 250],
				['data2', 50, 20, 10, 40, 15, 25]
			]
		}
	});

	var order_conversions_chart = c3.generate({
		bindto: '#webtools #order_conversion_chart',
		data: {
			columns: [
				['data', 91.4]
			],
			type: 'gauge',
			onclick: function (d, i) {
				console.log("onclick", d, i);
			},
			onmouseover: function (d, i) {
				console.log("onmouseover", d, i);
			},
			onmouseout: function (d, i) {
				console.log("onmouseout", d, i);
			}
		},
		gauge: {

		},
		color: {
			pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'], // the three color levels for the percentage values.
			threshold: {
//            unit: 'value', // percentage is default
//            max: 200, // 100 is default
				values: [30, 60, 90, 100]
			}
		},
		size: {
			height: 180
		}
	});

});
