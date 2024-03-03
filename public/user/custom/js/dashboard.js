(function( $ ){
    ("use strict");
    $(document).on('change', '#monthlySubscriber', function(){
        commonAjax('GET', $('#monthly-subscriber-route').val(), monthlySubscriber, monthlySubscriber, {'year': $(this).val()});
    });
    function monthlySubscriber(response){
        if( response.status == 200){
            $("#monthlySubscriberTable > tbody").html(response.responseText);
        }
    }
    $(document).on('change', '#monthlyRevenue', function(){
        commonAjax('GET', $('#monthly-revenue-route').val(), monthlyRevenue, monthlyRevenue, {'year': $(this).val()});
    });

    function monthlyRevenue(response){
        if( response.status == 200){
            $("#monthlyRevenueTable > tbody").html(response.responseText);
        }
    }

    //chart start
    $( document ).ready(function() {
        commonAjax('GET', $('#product-sold-out-chart-data-route').val(), soldOutChartDataRes, soldOutChartDataRes);
        commonAjax('GET', $('#daily-subscriber-chart-data-route').val(), dailySubscriberChartDataRes, dailySubscriberChartDataRes);
    });

    $(document).on('change', '#soldOutChart', function(){
        commonAjax('GET', $('#product-sold-out-chart-data-route').val(), soldOutChartDataRes, soldOutChartDataRes, {'year': $(this).val()});
    });

    function soldOutChartDataRes(response){
        if(response.status == true){
            var monthList = [];
            var productCountList = [];
            $.each(response.data,function (index,item) {
                monthList.push(index);
                productCountList.push(item);
            });

            var options = {
                series: [
                    {
                        name: "",
                        data: productCountList,
                    },
                ],
                chart: {
                    type: "bar",
                    height: 350,
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        borderRadius: 7,
                        horizontal: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                },
                states: {
                    hover: {
                        filter: {
                            type: "none",
                            value: 0.1,
                        },
                    },
                },
                xaxis: {
                    categories: monthList,
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    tickAmount: 4,
                    // min: 0,
                    // max: 3000,
                    crosshairs: {
                        show: true,
                        position: "back",
                        stroke: {
                            color: "#000000",
                        },
                    },
                },
                fill: {
                    opacity: 1,
                },
                colors: ["#7F56D9", "#ff0000"],
                legend: {
                    show: false,
                },
            };

            var zActivityChart = new ApexCharts(document.querySelector("#activityChart"), options);
            zActivityChart.render();
        }
    }

    function dailySubscriberChartDataRes(response){
        if(response.status == true){
            var dayList = [];
            var userCount = [];
            $.each(response.data.chart_data,function (index,item) {
                dayList.push(index);
                userCount.push(item);
            });

            $(".active-user-count").text(response.data.active_user_count);

            console.log(response.data.ratio);

            if(response.data.ratio > 0){
                $(".ratio-icon-bg").addClass('bg-green');
                $(".ratio-icon").addClass('fa-arrow-right');
                $(".ratio-icon-bg").removeClass('bg-red');
                $(".ratio-icon").removeClass('fa-arrow-left');
            }else if(response.data.ratio < 0){
                $(".ratio-icon-bg").addClass('bg-gray');
                $(".ratio-icon").addClass('fa-arrow-left');
                $(".ratio-icon-bg").removeClass('bg-green');
                $(".ratio-icon").removeClass('fa-arrow-right');
            }else{
                $(".ratio-icon-bg").addClass('bg-gray');
                $(".ratio-icon").addClass('fa-equals');
                $(".ratio-icon-bg").removeClass('bg-green');
                $(".ratio-icon").removeClass('fa-arrow-right');
                $(".ratio-icon-bg").removeClass('bg-red');
                $(".ratio-icon").removeClass('fa-arrow-left');
            }
            $(".ratio-text").text(response.data.ratio+'%');

            var options = {
                chart: {
                    height: 350,
                    type: "area",
                    toolbar: {
                        show: false,
                    },
                },
                colors: ["#7F56D9"],
                dataLabels: {
                    enabled: false,
                },
                series: [
                    {
                        name: "",
                        data: userCount,
                    },
                ],
                fill: {
                    type: "gradient",
                    gradient: {
                        gradientToColors: ["#7F56D9"],
                        shadeIntensity: 1,
                        type: "vertical",
                        opacityFrom: 1,
                        opacityTo: 0.5,
                        stops: [0, 100],
                    },
                },
                xaxis: {
                    categories: dayList,
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        style: {
                            cssClass: "apexcharts-yaxis-label",
                        },
                    },
                },
                yaxis: {
                    tickAmount: 4,
                    min: 0,
                    max: userCount,
                },
            };

            var z_activeUserChart = new ApexCharts(document.querySelector("#activeUserChart"), options);
            z_activeUserChart.render();


        }
    }

})(jQuery);
