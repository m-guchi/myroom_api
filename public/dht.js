$(function(){
    fetchLastDHT()
})

function fetchLastDHT(){
    $.ajax({
        url: '/myroom/api/dht/last',
        type: 'GET',
        dataType: 'json',
        timeout: 5000,
    })
    .done(function (data) {
        console.log(data)
        $("#temp").text(data.temp)
        $("#humid").text(data.humid)
        $("#thi").text(THI(data.temp,data.humid))
        $("#time").text(data.time)
    })
    .fail(function () {
        errorFetch()
    });
}

function THI(t, h) {
    return 0.81*t + 0.01*h*(0.99*t - 14.3) + 46.5
}

function errorFetch(){
    console.error("error")
}