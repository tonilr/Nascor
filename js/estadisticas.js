
// Create chart instance in one go
var chart = am4core.createFromConfig({
    // Create pie series
    "series": [{
      "type": "PieSeries",
      "dataFields": {
        "value": "Películas",
        "category": "País"
      },
      "labels":{
          "text":"{category}:{value.value}",
          "disabled":true
      },
      "slices": {
        "tooltipText": "{category}: {value.value}"
      },
      "ticks":{
          "disabled":true
      }
    }],
    //Añadimos los datos externos
    "dataSource":{
        // "url": "../db/data.json"
        "url": "../db/datos_pelis.php"
    },
    // And, for a good measure, let's add a legend
    "legend": {
        "valueLabels": {
            "text": "{value.value}"}
    }
  
  }, "chartpelisdiv", am4charts.PieChart);
  am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartgenerosdiv", am4charts.XYChart);

// chart.data = [{
// 	"country": "USA",
// 	"visits": 3025
// }, {
// 	"country": "China",
// 	"visits": 1882
// }, {
// 	"country": "Japan",
// 	"visits": 1809
// }, {
// 	"country": "Germany",
// 	"visits": 1322
// }, {
// 	"country": "UK",
// 	"visits": 1122
// }, {
// 	"country": "France",
// 	"visits": 1114
// }, {
// 	"country": "India",
// 	"visits": 984
// }, {
// 	"country": "Spain",
// 	"visits": 711
// }, {
// 	"country": "Netherlands",
// 	"visits": 665
// }, {
// 	"country": "Russia",
// 	"visits": 580
// }, {
// 	"country": "South Korea",
// 	"visits": 443
// }, {
// 	"country": "Canada",
// 	"visits": 441
// }];
    //Añadimos los datos externos
    // "dataSource":{
    //     // "url": "../db/data.json"
    //     "url": "../db/datos_generos.php"
    // };
chart.dataSource.url = "../db/datos_generos.php";
chart.padding(40, 40, 40, 40);

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.dataFields.category = "Género";
categoryAxis.renderer.minGridDistance = 60;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.categoryX = "Género";
series.dataFields.valueY = "Películas";
series.tooltipText = "{valueY.value}"
series.columns.template.strokeOpacity = 0;

chart.cursor = new am4charts.XYCursor();

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series.columns.template.adapter.add("fill", function (fill, target) {
	return chart.colors.getIndex(target.dataItem.index);
});