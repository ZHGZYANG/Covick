$(document).ready(function () {
    $.get("https://corona.lmao.ninja/v2/countries?sort=country", function(data, status){
        var tbody=document.getElementById("data_tbody");
        for(var i=data.length-1;i>-1;i--){
            tbody.innerHTML+="<tr><td>"+data[i]['country']+"</td><td>"+data[i]['cases']+"</td><td>"+data[i]['todayCases']+"</td><td>"+data[i]['deaths']+"</td><td>"+data[i]['todayDeaths']+"</td><td>"+data[i]['recovered']+"</td><td>"+data[i]['todayRecovered']+"</td></tr>";
        }
    });
});
