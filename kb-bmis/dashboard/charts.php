<script>
    // CHART 2
    const chart2 = document.getElementById("myChart2")
    const myChart2 = new Chart(chart2, {
        type: "polarArea",
        data: {
            labels: ["Children", "Adolescents", "Adults", "Senior Citizens"],
            datasets: [{
                label: "# of Votes",
                data: [
                    <?php echo $totalChild['child']; ?>,
                    <?php echo $totalAdolescent['adolescent']; ?>,
                    <?php echo $totalAdult['adult']; ?>,
                    <?php echo $totalSenior['senior']; ?>
                ],
                backgroundColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                ],

            }, ],
        },
        options: {
            responsive: true,
            onClick: function(event, elements) {
                if (elements.length > 0) {
                    var data = elements[0]._chart.data.datasets[0].data;
                    var index = elements[0]._index;
                    var label = elements[0]._chart.data.labels[index];
                    var file = '';
                    switch (label) {
                        case 'Children':
                            file = 'total-children.php';
                            break;
                        case 'Adolescents':
                            file = 'adolescents.php';
                            break;
                        case 'Adults':
                            file = 'adults.php';
                            break;
                        case 'Senior Citizens':
                            file = 'senior_citizens.php';
                            break;
                    }
                    console.log(file);
                    window.location.href = file;
                }
            }

        },
    });



    // CHART 3
    const chart3 = document.getElementById("myChart3")
    const myChart3 = new Chart(chart3, {
        type: "bar",
        data: {
            labels: [
                "Purok 1",
                "Purok 2",
                "Purok 3",
                "Purok 4",
                "Purok 5",
                "Purok 6",
                "Purok 7",
                "Purok 8",
                "Purok 9-A",
                "Purok 9-B",
                "Purok 10-A",
                "Purok 10-B",
                "Purok 11",
                "Purok Lower 11-A",
                "Purok Purok Upper 11-A",
                "Purok 11-B",
                "Purok 11-C",
                "Purok 12",
                "Purok 12-A",
                "Purok 13",
                "Purok 13-A",
                "Purok 13-B",
                "Purok 14",
                "Purok 15",
                "Purok 16",
                "Purok Lower 16",
                "Purok Upper 16",
                "Purok 17-A",
                "Purok 17-B",
                "Purok 18",
                "Purok 19",
                "Purok 20",
                "Purok 21",
                "Purok 22",
                "Purok 23",
                "Purok 24",
                "Purok 25",
                "Purok 26",
                "Purok 27",
                "Purok 28",
                "Purok 29",
                "Purok 30",
            ],
            datasets: [{
                // label: "Population by Purok",
                data: [

                    <?php echo $purok1['Purok_1']; ?>,
                    <?php echo $purok2['Purok_2']; ?>,
                    <?php echo $purok3['Purok_3']; ?>,
                    <?php echo $purok4['Purok_4']; ?>,
                    <?php echo $purok5['Purok_5']; ?>,
                    <?php echo $purok6['Purok_6']; ?>,
                    <?php echo $purok7['Purok_7']; ?>,
                    <?php echo $purok8['Purok_8']; ?>,
                    <?php echo $purok9_A['Purok_9_A']; ?>,
                    <?php echo $purok9_B['Purok_9_B']; ?>,
                    <?php echo $purok10_A['Purok_10_A']; ?>,
                    <?php echo $purok10_B['Purok_10_B']; ?>,
                    <?php echo $purok11['Purok_11']; ?>,
                    <?php echo $puroklower11_A['Purok_Lower_11_A']; ?>,
                    <?php echo $purokupper11_A['Purok_Upper_11_A']; ?>,
                    <?php echo $purok11_B['Purok_11_B']; ?>,
                    <?php echo $purok11_C['Purok_11_C']; ?>,
                    <?php echo $purok12['Purok_12']; ?>,
                    <?php echo $purok12_A['Purok_12_A']; ?>,
                    <?php echo $purok13['Purok_13']; ?>,
                    <?php echo $purok13_A['Purok_13_A']; ?>,
                    <?php echo $purok13_B['Purok_13_B']; ?>,
                    <?php echo $purok14['Purok_14']; ?>,
                    <?php echo $purok15['Purok_15']; ?>,
                    <?php echo $purok16['Purok_16']; ?>,
                    <?php echo $puroklower16['Purok_Lower_16']; ?>,
                    <?php echo $purokupper16['Purok_Upper_16']; ?>,
                    <?php echo $purok17_A['Purok_17_A']; ?>,
                    <?php echo $purok17_B['Purok_17_B']; ?>,
                    <?php echo $purok18['Purok_18']; ?>,
                    <?php echo $purok19['Purok_19']; ?>,
                    <?php echo $purok20['Purok_20']; ?>,
                    <?php echo $purok21['Purok_21']; ?>,
                    <?php echo $purok22['Purok_22']; ?>,
                    <?php echo $purok23['Purok_23']; ?>,
                    <?php echo $purok24['Purok_24']; ?>,
                    <?php echo $purok25['Purok_25']; ?>,
                    <?php echo $purok26['Purok_26']; ?>,
                    <?php echo $purok27['Purok_27']; ?>,
                    <?php echo $purok28['Purok_28']; ?>,
                    <?php echo $purok29['Purok_29']; ?>,
                    <?php echo $purok30['Purok_30']; ?>,

                ],
                backgroundColor: [
                    "#ef6a61",
                    //
                ],
            }, ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }

        },
    });
</script>