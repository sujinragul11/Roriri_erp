
/*
 Template Name: Zoogler - Bootstrap 4 Admin Dashboard
 Author: Mannatthemes
 Website: www.mannatthemes.com
 File: Morris init js
 */





//line-chart
var ctx = document.getElementById('lineChart').getContext('2d');

gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
   gradientStroke1.addColorStop(0, '#008cff');
   gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');

gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
   gradientStroke2.addColorStop(0, '#ec536c');
   gradientStroke2.addColorStop(1, 'rgba(222, 15, 23, 0.1)');

   var myChart = new Chart(ctx, {
     type: 'line',

     data: {
       labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
       datasets: [{
         label: '1-Dataset',
         data: [3, 30, 10, 10, 22, 12, 5],
         pointBorderWidth: 0,
         pointHoverBackgroundColor: gradientStroke1,
         backgroundColor: gradientStroke1,
         borderColor: 'transparent',
         borderWidth: 1
       },
       {
           label: '2-Dataset',
           data: [5, 15, 12, 25, 5, 7, 5],
           pointBorderWidth:0,
           pointHoverBackgroundColor: gradientStroke2,
           backgroundColor: gradientStroke2,
           borderColor: 'transparent',
           borderWidth: 1
         }],
      
     },
     options: {
         legend: {
           position: 'bottom',
           display:false
         },
         tooltips: {
           displayColors:false,
           intersect: false,
         },
         elements: {
            point:{
                radius: 0
            }
        },
         scales: {
           xAxes: [{
               ticks: {
                   max: 100,
                   min: 20,
                   stepSize: 10                        
               },
               gridLines: {
                   display: false ,
                   color: "#FFFFFF"
               },
               ticks: {
                display: true,
                fontFamily: "'Rubik', sans-serif"
                },
               
           }],
           yAxes: [{                   
               gridLines: {
                 color: '#fff',
                 display: false ,
               },
               ticks: {
                   display: false,
                   fontFamily: "'Rubik', sans-serif"
               },
               
           }]
       },
      }
   });



//Doughnut
      
var ctx = document.getElementById("dash-doughnut").getContext('2d');

gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke1.addColorStop(0, '#00e795');
  gradientStroke1.addColorStop(1, '#0095e2');

gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke2.addColorStop(1, '#f6d365');
  gradientStroke2.addColorStop(0, '#ff7850');

gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
  gradientStroke3.addColorStop(0, '#f56348');
  gradientStroke3.addColorStop(1, '#f81f8b');

  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Active", "Panding", "Complete"],
      datasets: [{
        backgroundColor: [
          gradientStroke1,
          gradientStroke2,
          gradientStroke3,
        ],
        hoverBackgroundColor: [
          gradientStroke1,
          gradientStroke2,
          gradientStroke3,
        ],
        data: [22, 25, 25],
        borderWidth: [.8, .8, .8]
      }]
    },
    options: {
        cutoutPercentage: 75,
        legend: {
          position: 'bottom',
          display: false,
          labels: {
            boxWidth:12
          }
      },          
    }
  }); 

  //Bar
    
 var ctx = document.getElementById("bar-data").getContext('2d');

   
 var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
     gradientStroke1.addColorStop(0, '#5ecbf6');  
     gradientStroke1.addColorStop(1, '#8d44ad'); 
 
     var cornerRadius = 20;

     var myChart = new Chart(ctx, {
       type: 'bar',        
       data: {
         labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ,11, 12],
         datasets: [{
           label: 'Revenue',
           data: [72, 75, 72, 77, 78, 74, 71, 72, 71, 69, 72, 75],
           borderColor: gradientStroke1,
           backgroundColor: gradientStroke1,
           hoverBackgroundColor: gradientStroke1,
           pointRadius: 0,
           fill: false,
           borderWidth: 0
         },]
       },
       
       options: {
         
         legend: {
           position: 'bottom',
           display:false
         },
         tooltips: {
           displayColors:false,
           intersect: false,
         },
         scales: {
           xAxes: [{
               ticks: {
                   max: 100,
                   min: 20,
                   stepSize: 10                        
               },
               gridLines: {
                   display: false ,
                   color: "#FFFFFF"
               },
               ticks: {
                display: true,
                fontFamily: "'Rubik', sans-serif"
                },
               
           }],
           yAxes: [{                   
               gridLines: {
                 color: '#fff',
                 display: false ,
               },
               ticks: {
                   display: false,
                   fontFamily: "'Rubik', sans-serif"
               },
               
           }]
       },
      }
     });


     $(document).ready(function() {
      $(".boxscroll").niceScroll({cursorborder:"",cursorcolor:"#eff3f6",boxzoom:true});
    }); 

     
