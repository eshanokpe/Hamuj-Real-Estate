
/*
    Chart activation
*/
   /** Users comment chart */
   const statisticsLabels = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];

  const statisticsDataset = {
    labels: statisticsLabels,
    datasets: [
      {
        label: false,
        backgroundColor: "#16a34a",
        borderColor: "#16a34a",
        color: "#707070",
        data: [50, 150, 300, 100, 400, 300, 250, 300, 400, 900, 600, 800],
      },
    ],
  };
  
  const statisticsConfig = {
    type: "line",
    data: statisticsDataset,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    },
  };
  const statisticsChart = new Chart(document.getElementById("myChart"), statisticsConfig);



  // ChartDoughnut JS
    const data = {
        labels: [
            'Vila',
            'Hotel',
            'Guest',
            'Room'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [100, 50, 50, 80],
            backgroundColor: [
            'orange',
            '#16A34A',
            '#9B51E0',
            '#16BFD6'
            ],
            hoverOffset: 2,
            borderWidth: 3,
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            cutout: 50
        }
    };
    const ChartDoughnut = new Chart(document.getElementById("ChartDoughnut"), config);