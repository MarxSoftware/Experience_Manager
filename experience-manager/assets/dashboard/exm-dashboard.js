/**
 * moment js for timestamps:
 * 
 * moment().valueOf() -> epoch millis
 * moment().subtract('months', 12) => before 12 month
 * 
 * @type type
 */

function exm_fetch_kpi(body_string, ok_function) {
	fetch(ajaxurl, {
		method: "POST",
		mode: "cors",
		cache: "no-cache",
		credentials: "same-origin",
		body: body_string,
		headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
	}).then((response) => response.json()
	).then(ok_function);
}

webtools.domReady(function () {

	fetch(ajaxurl, {
		method: "POST",
		mode: "cors",
		cache: "no-cache",
		credentials: "same-origin",
		body: "action=exm_dashboard_main",
		headers: new Headers({'Content-Type': 'application/x-www-form-urlencoded'}),
	}).then((response) => response.json()
	).then((response) => {
		console.log('Success:', response);

		var main_chart = c3.generate({
			bindto: '#webtools #chart',
			data: {
				x: 'x',
				xFormat: '%m-%Y',
				columns: response.data,
				names: response.names
			},
			axis: {
				x: {
					type: 'timeseries',
					tick: {
						format: '%m-%Y'
					}
				}
			}
		});

	});

	exm_fetch_kpi("action=exm_dashboard_kpi&kpi=order_conversion_rate", (response) => {
		document.querySelector("#webtools #exm_order_conversion_chart_loader").style.display = 'none';
		var order_conversions_chart = c3.generate({
			bindto: '#webtools #order_conversion_chart',
			data: {
				columns: [
					['data', response.value.value]
				],
				names: {
					data: 'Order conversion rate'
				},
				type: 'gauge'
			},
			color: {
				pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'], // the three color levels for the percentage values.
				threshold: {
					values: [30, 60, 90, 100]
				}
			},
			size: {
				height: 180
			}
		});
	});
	exm_fetch_kpi("action=exm_dashboard_kpi&kpi=orders_per_user", (response) => {
		document.querySelector("#webtools #exm_orders_per_user_loader").style.display = 'none';
		document.querySelector("#webtools #orders_per_user").innerHTML = response.value.value;
	});

});
