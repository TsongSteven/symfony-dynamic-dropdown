  const ctx = document.getElementById('myChart');
  const data = {
    labels: [
      'Rice',
      'Aata',
      'Refine Oil'
    ],
    datasets: [{
      label: 'Consumed in Sikkim',
      data: [300, 50, 100],
      backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 205, 86)'
      ],
      hoverOffset: 4
    }]
  };
  new Chart(ctx, {
    
    type: 'pie',
    data: data,
    
  });

  
  