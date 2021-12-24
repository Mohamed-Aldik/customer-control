var rtl = false;
var globalID = "";
buildGraphs();

function changeToRTL() {
  $("body").removeClass("english").addClass("arabic");
  $("aside").addClass("main-sidebar-ar");
  $("#content-wrapper").addClass("content-wrapper-ar");
  $("#nav").addClass("text-align-r");
  $("#ul").addClass("zero-padding");
  $("#main-header").addClass("main-header-r");
  $("#navbar-nav").addClass("navbar-nav-r");
  $(".active-ar").addClass("nav-link-ar");
  $(".card-body1").addClass("border-right");
  $(".card-body").addClass("border-right");
  $("h5").addClass("text-align-r");
  $(".user h6").addClass("text-align-r");
  $("#search").addClass("search-ar");
  $("#searchIcon").addClass("searchIcon-ar");
  $("#bellNotifi").addClass("marginLeft");
  $("#user").addClass("user-ar");
  this.rtl = true;
  setTimeout(() => {
    buildGraphs();
  }, 1000);

  setActive(null);
}

function changeToLTR() {
  $("body").removeClass("arabic").addClass("english");
  $("aside").removeClass("main-sidebar-ar");
  $("#content-wrapper").removeClass("content-wrapper-ar");
  $("#nav").removeClass("text-align-r");
  $("#ul").removeClass("zero-padding");
  $("#main-header").removeClass("main-header-r");
  $("#navbar-nav").removeClass("navbar-nav-r");
  $(".active-ar").removeClass("nav-link-ar");
  $(".card-body1").removeClass("border-right");
  $(".card-body").removeClass("border-right");
  $("h5").removeClass("text-align-r");
  $(".user h6").removeClass("text-align-r");
  $("#search").removeClass("search-ar");
  $("#searchIcon").removeClass("searchIcon-ar");
  $("#bellNotifi").removeClass("marginLeft");
  $("#user").removeClass("user-ar");
  this.rtl = false;
  setTimeout(() => {
    buildGraphs();
  }, 1000);
  setActive(null);
}
function goBack() {}

function setActive(id) {
  $(".active-ar").removeClass("setActive-ar").removeClass("setActive-en");
  if (id) {
    this.globalID = id;
    if (rtl) {
      $("#" + id).addClass("setActive-ar");
    } else {
      $("#" + id).addClass("setActive-en");
    }
  } else {
    if (rtl) {
      $("#" + this.globalID).addClass("setActive-ar");
    } else {
      $("#" + this.globalID).addClass("setActive-en");
    }
  }
}

// Build the chart
function buildGraphs() {
  Highcharts.chart("pieChart", {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: "pie",
    },
    title: {
      text: "",
    },
    tooltip: {
      pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>",
    },
    accessibility: {
      point: {
        valueSuffix: "%",
      },
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: "pointer",
        dataLabels: {
          enabled: true,
          style: {
            fontWeight: "normal",
          },
          format: "{point.percentage:.1f} %",
          connectorColor: "silver",
        },
        showInLegend: true,
      },
    },
    legend: {
      layout: "vertical",
      align: "center",
      verticalAlign: "bottom",
      rtl: this.rtl,
    },
    series: [
      {
        //   innerSize: "0%",
        //   name: "Share",
        data: [
          {
            name: "Inbound (28.4)",
            y: 28.4,
            color: "#FFC935",
            dataLabels: {
              backgroundColor: "#FFC935",
              color: "white",
            },
          },
          {
            name: "Outbound (45.04)",
            y: 45.04,
            color: "#58D0FF",
            dataLabels: {
              backgroundColor: "#58D0FF",
              color: "white",
            },
          },
          {
            name: "Q . C (19.85)",
            y: 19.85,
            color: "#8479FF",
            dataLabels: {
              backgroundColor: "#8479FF",
              color: "white",
            },
          },
          {
            name: "HR & Admin Dept (5.34) ",
            y: 5.34,
            color: "#BF5BFF",
            dataLabels: {
              backgroundColor: "#BF5BFF",
              color: "white",
            },
          },
          {
            name: "Operation (5.34)",
            y: 5.34,
            color: "#FF6161",
            dataLabels: {
              backgroundColor: "#FF6161",
              color: "white",
            },
          },
        ],
      },
    ],
  });

  // Absence Chart
  Highcharts.chart("absenceChart", {
    chart: {
      type: "column",
    },
    title: {
      style: {
        color: "#333333",
        fontSize: "0px",
      },
      //   text: "Monthly Average Rainfall",
    },
    //   subtitle: {
    //     text: "Source: WorldClimate.com",
    //   },
    legend: {
      enabled: false,
      style: {
        color: "#007CC4",
      },
    },
    xAxis: {
      labels: {
        style: {
          color: "#007CC4",
        },
      },
      categories: [
        "7/12 ",
        "8/12 ",
        "9/12 ",
        "10/12 ",
        "11/12 ",
        "12/12 ",
        "13/12 ",
        "14/12 ",
        "15/12 ",
        "16/12 ",
        "17/12 ",
        "18/12 ",
      ],
      crosshair: true,
      reversed: this.rtl,
    },
    yAxis: {
      labels: {
        style: {
          color: "#007CC4",
        },
      },
      opposite: this.rtl,
      min: 0,
      title: {
        enabled: false,
        //   text: "Rainfall (mm)",
      },
    },
    tooltip: {
      headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
      pointFormat: '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
      footerFormat: "</table>",
      shared: true,
      useHTML: true,
    },
    plotOptions: {
      column: {
        pointPadding: 0.2,
        borderWidth: 0,
      },
    },
    series: [
      {
        //   name: "Tokyo",
        color: "#007CC4",
        data: [
          49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1,
          95.6, 54.4,
        ],
      },
    ],
  });
}
