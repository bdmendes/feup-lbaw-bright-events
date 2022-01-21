<!-- Chart's container -->
<div id="age_chart"></div>
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

<!-- Your application script -->
<script>
    const age_chart = new Chartisan({
        el: '#age_chart',
        url: "@chart('age_chart')?age0={{ $age0 }}&age1={{ $age1 }}&age2={{ $age2 }}&age3={{ $age3 }}",
        hooks: new ChartisanHooks()
            .beginAtZero()
            .colors(),
    });
</script>
