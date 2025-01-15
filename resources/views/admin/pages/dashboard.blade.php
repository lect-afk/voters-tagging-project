@extends('layouts.backend')
@section('content')

<div class="card dashboard_card">
  <div class="card-header">
    <span class="fs-5">Welcome!</span>
  </div>
  <div class="card-body dashboard_card_body">
    {{-- <h5 class="card-title">Hello,</h5>
    <p class="card-text">Thank you for your dedication and hard work. Here, you can manage all aspects of our campaign efficiently and effectively. Let's drive our mission forward!</p> --}}
    <div class="container">
        <h1>Alliance Tagging Overview</h1>
    
        <div class="form-group">
            <label for="barangay-select">Select Barangay:</label>
            <select id="barangay-select" class="form-control">
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->id }}" {{ $loop->first ? 'selected' : '' }}>{{ $barangay->name }}</option>
                @endforeach
            </select>
        </div>
    
        <canvas id="barangayChart" class="w-100" height="350px"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chart;

function fetchBarangayData(barangayId) {
  fetch(`/api/barangay-data?barangay_id=${barangayId}`)
      .then(response => response.json())
      .then(data => {
          if (data.error) {
              alert(data.error);
              return;
          }

          const canvas = document.getElementById('barangayChart');
          const ctx = canvas.getContext('2d');

          // Set canvas dimensions explicitly
          canvas.width = canvas.offsetWidth * window.devicePixelRatio;
          canvas.height = 350 * window.devicePixelRatio;
          ctx.scale(window.devicePixelRatio, window.devicePixelRatio);

          // Destroy previous chart instance if it exists
          if (chart) {
              chart.destroy();
          }

          // Calculate percentages
          const total = data.total;
          const percentages = [
              ((data.allied / total) * 100).toFixed(1),
              ((data.prospectiveally / total) * 100).toFixed(1),
              ((data.unlikelyally / total) * 100).toFixed(1),
              ((data.nonparticipant / total) * 100).toFixed(1),
              ((data.nonsupporter / total) * 100).toFixed(1),
              ((data.inc / total) * 100).toFixed(1),
              ((data.unidentified / total) * 100).toFixed(1)
          ];

          chart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: [
                      `Allied (${percentages[0]}%)`,
                      `Prospective Ally (${percentages[1]}%)`,
                      `Unlikely Ally (${percentages[2]}%)`,
                      `Nonparticipant (${percentages[3]}%)`,
                      `Non-supporter (${percentages[4]}%)`,
                      `INC (${percentages[5]}%)`,
                      `Unidentified (${percentages[6]}%)`
                  ],
                  datasets: [{
                      // label: 'Number of Voters',
                      data: [
                          data.allied, 
                          data.prospectiveally, 
                          data.unlikelyally, 
                          data.nonparticipant, 
                          data.nonsupporter, 
                          data.inc, 
                          data.unidentified
                      ],
                      backgroundColor: [
                          'rgba(4, 102, 200, 0.3)',       // Blue (Green in DB)
                          'rgba(255, 214, 10, 0.3)',      // Yellow
                          'rgba(153, 88, 42, 0.5)',       // Brown (Orange in DB)
                          'rgba(108, 117, 125, 0.8)',     // Grey
                          'rgbargba(208, 0, 0, 0.5)',     // Red
                          'rgba(224, 251, 252, 0.3)',     // White
                          'rgba(53, 53, 53, 1)'           // Black
                      ],
                      borderColor: [
                          'rgba(4, 102, 200, 1)',         // Blue (Green in DB)
                          'rgba(255, 214, 10, 1)',        // Yellow
                          'rgba(153, 88, 42, 1)',         // Brown (Orange in DB)
                          'rgba(108, 117, 125, 1)',       // Grey
                          'rgba(208, 0, 0, 1)',           // Red
                          'rgba(224, 251, 252, 1)',       // White
                          'rgba(53, 53, 53, 1)'           // Black
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                plugins: {
                        legend: {
                            display: false // Hide the legend
                        },
                        title: {
                            display: false // Hide the title
                        }
                    },
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  },
                  responsive: false, // Disable responsiveness to fix size
                  maintainAspectRatio: false // Ensure height is respected
              }
          });
      });
}

document.getElementById('barangay-select').addEventListener('change', function() {
  const barangayId = this.value;
  if (!barangayId) return;
  fetchBarangayData(barangayId);
});

// Fetch data for the first barangay on page load
document.addEventListener('DOMContentLoaded', function() {
  const initialBarangayId = document.getElementById('barangay-select').value;
  fetchBarangayData(initialBarangayId);
});
</script>
@endsection
