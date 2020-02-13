
/*-----------------------------------/
  花費比例
/*----------------------------------*/
var chart = AmCharts.makeChart("spend-chart", {
	"hideCredits": "true",
	"type": "pie",
	"labelText": "[[percents]]%",
	"dataProvider": [{
		"litres": 40
	}, {
		"litres": 25
	}, {
		"litres": 15
	}, {
		"litres": 10
	}, {
		"litres": 5
	}, {
		"litres": 5
	}],
	"valueField": "litres",
	"titleField": "quantity",
	"balloon": {
		"fixedPosition": true,
	},
	"radius": "33%",
	"innerRadius": "58%",
	"labelsEnabled": true,
	"autoMargins": true,
	"labelRadius": 5,
	"marginTop": 0,
	"marginBottom": 0,
	"marginLeft": 0,
	"marginRight": 0,
});