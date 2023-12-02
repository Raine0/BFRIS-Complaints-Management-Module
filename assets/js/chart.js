$(document).ready(function () {
  $.ajax({
    url: "../../kb-bmis/reports/data/brgy-weekly-data.php",
    method: "GET",
    success: function (data) {
      const datesInWeek = [];
      const weeklySales = [];

      for (let i in data) {
        datesInWeek.push(data[i].Date);
        weeklySales.push(data[i].brgyweeksales);
      }

      const chartdata = {
        labels: datesInWeek,
        datasets: [
          {
            label: "Barangay Clearance Last 7 Days Revenue",
            backgroundColor: "#ef6a61",
            data: weeklySales,
          },
        ],
      };

      const brgyWeeklySalesCtx = $("#brgy-week");

      new Chart(brgyWeeklySalesCtx, {
        type: "bar",
        data: chartdata,
        options: {
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  // Include a dollar sign in the ticks
                  callback: function (value, index, values) {
                    return "₱" + value.toLocaleString();
                  },
                },
              },
            ],
          },
          responsive: true,
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).ready(function () {
  $.ajax({
    url: "../../kb-bmis/reports/data/business-weekly-data.php",
    method: "GET",
    success: function (data) {
      // console.log(data);
      const businessDatesInWeek = [];
      const businessWeeklySales = [];

      for (let i in data) {
        businessDatesInWeek.push(data[i].bsDate);
        businessWeeklySales.push(data[i].bsweeksales);
      }

      const chartdata = {
        labels: businessDatesInWeek,
        datasets: [
          {
            label: "Business Clearance Revenue",
            backgroundColor: "#ef6a61",
            data: businessWeeklySales,
          },
        ],
      };

      const businessWeeklySalesCtx = $("#bs-week");

      new Chart(businessWeeklySalesCtx, {
        type: "bar",
        data: chartdata,
        options: {
          scales: {
            y: {
              ticks: {
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  return "₱" + value.toLocaleString();
                },
              },
            },
          },
          responsive: true,
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).ready(function () {
  $.ajax({
    url: "../../kb-bmis/reports/data/brgy-month-data.php",
    method: "GET",
    success: function (data) {
      // console.log(data);
      const months = [];
      const brgyMonthlySales = [];

      for (let i in data) {
        months.push(data[i].MonthName);
        brgyMonthlySales.push(data[i].brgymonthSales);
      }

      const chartdata = {
        labels: months,
        datasets: [
          {
            label: "Barangay Clearance Monthly Revenue",
            backgroundColor: "#ef6a61",
            data: brgyMonthlySales,
          },
        ],
      };

      const brgyMonthlySalesCtx = $("#brgy-month");

      new Chart(brgyMonthlySalesCtx, {
        type: "bar",
        data: chartdata,
        options: {
          scales: {
            y: {
              ticks: {
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  return "₱" + value.toLocaleString();
                },
              },
            },
          },
          responsive: true,
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).ready(function () {
  $.ajax({
    url: "../../kb-bmis/reports/data/business-month-data.php",
    method: "GET",
    success: function (data) {
      // console.log(data);
      const months = [];
      const businessMonthlySales = [];

      for (let i in data) {
        months.push(data[i].bsMonth);
        businessMonthlySales.push(data[i].bsMonthlySales);
      }

      const chartdata = {
        labels: months,
        datasets: [
          {
            label: "Business Clearance Monthly Revenue",
            backgroundColor: "#ef6a61",
            data: businessMonthlySales,
          },
        ],
      };

      const businessMonthlySalesCtx = $("#bs-month");

      new Chart(businessMonthlySalesCtx, {
        type: "bar",
        data: chartdata,
        options: {
          scales: {
            xAxes: [
              {
                ticks: {
                  callback: function (tick, index, array) {
                    return index % 3 ? "" : tick;
                  },
                  autoSkip: false,
                  maxRotation: 0,
                  minRotation: 0,
                },
              },
            ],

            yAxes: [
              {
                ticks: {
                  // Include a dollar sign in the ticks
                  callback: function (value, index, values) {
                    return "₱" + value.toLocaleString();
                  },
                },
              },
            ],
          },
          responsive: true,
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
});

// YEAR CHARTS
$(document).ready(function () {
  $.ajax({
    url: "../../kb-bmis/reports/data/brgy-year-data.php",
    method: "GET",
    success: function (data) {
      // console.log(data);
      const years = [];
      const brgyYearlySales = [];

      for (let i in data) {
        years.push(data[i].brgyyear);
        brgyYearlySales.push(data[i].brgyyearsales);
      }

      const chartdata = {
        labels: years,
        datasets: [
          {
            label: "Barangay Clearance Yearly Revenue",
            backgroundColor: "#ef6a61",
            data: brgyYearlySales,
          },
        ],
      };

      const brgyYearlySalesCtx = $("#brgy-year");

      new Chart(brgyYearlySalesCtx, {
        type: "bar",
        data: chartdata,
        options: {
          scales: {
            y: {
              ticks: {
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  return "₱" + value.toLocaleString();
                },
              },
            },
          },
          responsive: true,
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
});

$(document).ready(function () {
  $.ajax({
    url: "../../kb-bmis/reports/data/business-year-data.php",
    method: "GET",
    success: function (data) {
      // console.log(data);
      const years = [];
      const businessYearlySales = [];

      for (let i in data) {
        years.push(data[i].bsyear);
        businessYearlySales.push(data[i].bsyearsales);
      }

      const chartdata = {
        labels: years,
        datasets: [
          {
            label: "Business Clearance Monthly Revenue",
            backgroundColor: "#ef6a61",
            data: businessYearlySales,
          },
        ],
      };

      const businessYearlySalesCtx = $("#bs-year");

      new Chart(businessYearlySalesCtx, {
        type: "bar",
        data: chartdata,
        options: {
          scales: {
            y: {
              ticks: {
                // Include a dollar sign in the ticks
                callback: function (value, index, values) {
                  return "₱" + value.toLocaleString();
                },
              },
            },
          },
          responsive: true,
        },
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
});
