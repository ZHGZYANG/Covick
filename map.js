$(document).ready(function () {
    selected = [];
    option = {
        map: 'usa_en',
        backgroundColor: 'rgba(26, 25, 25, 0.7)',
        borderColor: 'rgb(26, 25, 25)',
        borderOpacity: 0.7,
        borderWidth: 1,
        // color: '#f4f3f0',
        colors: null,
        enableZoom: true,
        hoverColor: '#30b3fa',
        hoverOpacity: null,
        normalizeFunction: 'linear',
        scaleColors: ['#b6d6ff', '#005ace'],
        selectedColor: '#c9dfaf',
        multiSelectRegion: true,
        selectedRegions: null, // ['MO', 'FL', 'OR']
        showTooltip: true, // this is used to show data from server
        onRegionClick: function (event, code, region) {
            if (selected.includes(code)) {
                $("#" + code).remove();
                var index = selected.indexOf(code);
                selected.splice(index, 1);
            } else {
                selected.push(code);
                showstatedata(code);
            }
        },
        onLoad: function (event, map) {

        },
        onRegionOver: function (event, code, region) {

        },
        onRegionSelect: function (event, code, region) {
        },
    };
    map = $('#vmap').vectorMap(option);
    $.get("https://api.covidtracking.com/v1/states/current.json", function(data, status){
        window.data=data;
    });
});

/*
* normalizeFunction 'linear'
*
* This function can be used to improve results of visualizations for data
* with non-linear nature. Function gets raw value as the first parameter and
* should return value which will be used in calculations of color, with which
* particular region will be painted.
* */

function showstatedata(code) {
    label = $('<div/>').attr('id', code).addClass('jqvmap-label').appendTo($('body')).hide();
    var string = getStateData(code);
    label.html(string);
    var pos = localStorage.position.split(",");
    var left = pos[0];
    var top = pos[1];
    label.css({
        position: 'absolute',
        left: left+'px',
        top: top+'px'
    });
    label.show();
}

function getStateData(stateCode){
    for(var i=0;i<56;i++){
        if(window.data[i]['state']==stateCode.toUpperCase()){
            var positive=window.data[i]['positive'];
            var totalTestResults=window.data[i]['totalTestResults'];
            // var hospitalizedCumulative=window.data[i]['hospitalizedCumulative'];
            var death=window.data[i]['death'];
            // var hospitalized=window.data[i]['hospitalized'];
            return "State: "+stateCode.toUpperCase()+"<br>Positive Number: "+positive+"<br>Total Test Results: " +
                totalTestResults+"<br>Death: "+death;
        }
    }
}