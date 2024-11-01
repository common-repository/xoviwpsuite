
var getDefaultChart = function(chartData) {
    
    return {
        title: {
            text: chartData.title,          
            fontFamily: 'Georgia',
            fontSize: '16pt'
          
        },
        
        axes:{
            xaxis:{
                renderer:jQuery.jqplot.DateAxisRenderer,
                tickOptions:{
                    formatString:'%b&nbsp;%#d'
                } 
            },
            yaxis:{
                tickOptions:{
                    formatString:'%.2f'
                }
            }
        },
        axesDefaults: {
            tickOptions: {
                fontFamily: 'Calibri',
                fontSize: '10pt'
            }
        },
        series: chartData.series,
        legend: {
            fontFamily: 'Calibri',
            fontSize: '10pt',
            show: true,
            placement: 'outsideGrid'
        },
        highlighter: {
            show: true,
            sizeAdjust: 7.5
        },
        cursor: {
            show: false
        }
    }
}

function createChart(chartData) {

    var thisChart = new getDefaultChart(chartData);
    
    console.log(thisChart);
    
    if(chartData.isPositionchart == true) {
        console.warn("isPositionChart");
        
        jQuery.extend(thisChart.axes.yaxis, {
            min:120, 
            max:1
        });
    }
    
    console.log(thisChart);
    
    var ref = jQuery.jqplot(chartData.container, chartData.data, thisChart);
  
  
  console.log(ref);
  
}
