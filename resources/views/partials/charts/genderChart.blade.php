<!-- Chart's container -->
<div id="gender_chart"></div>
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
<!-- Your application script -->
<script>
    const gender_chart = new Chartisan({
        el: '#gender_chart',
        url: "@chart('gender_chart')?male={{ $male }}&female={{ $female }}&other={{ $other }}",
        hooks: new ChartisanHooks()
            .datasets('doughnut')
            .pieColors(),
    });
</script>
