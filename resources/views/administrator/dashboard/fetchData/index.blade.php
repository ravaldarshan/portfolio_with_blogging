<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Project</h4>
                </div>
                <div class="card-body">
                    {{ count($Project) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Post</h4>
                </div>
                <div class="card-body">
                    {{ count($Blog) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Client</h4>
                </div>
                <div class="card-body">
                    {{ count($Client) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="fas fa-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Visits</h4>
                </div>
                <div class="card-body">
                    {{ count($Statistic) }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Statistics - {{ now()->format('Y') }}</h4>
                <div class="card-header-action">
                    <div class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-primary" id="triggerDaily">Daily</a>
                        <a href="javascript:void(0)" class="btn" id="triggerWeekly">Week</a>
                        <a href="javascript:void(0)" class="btn" id="triggerMonthly">Month</a>
                        <a href="javascript:void(0)" class="btn" id="triggerYearly">Year</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="myChart" height="182"></canvas>
                <div class="statistic-details mt-sm-4">
                    <div class="statistic-details-item">
                        <span class="text-muted">
                            @php
                                $dailyPercentageChange = 0;
                                if (isset($chartDataDaily[6], $chartDataDaily[6 - 1]) && $chartDataDaily[6 - 1] != 0) {
                                    $dailyPercentageChange = (($chartDataDaily[6] - $chartDataDaily[6 - 1]) / $chartDataDaily[6 - 1]) * 100;
                                }

                                $weeklyPercentageChange = 0;
                                if (isset($chartDataWeekly[6], $chartDataWeekly[6 - 1]) && $chartDataWeekly[6 - 1] != 0) {
                                    $weeklyPercentageChange = (($chartDataWeekly[6] - $chartDataWeekly[6 - 1]) / $chartDataWeekly[6 - 1]) * 100;
                                }

                                $monthlyPercentageChange = 0;
                                if (isset($chartDataMonthly[11], $chartDataMonthly[11 - 1]) && $chartDataMonthly[11 - 1] != 0) {
                                    $monthlyPercentageChange = (($chartDataMonthly[11] - $chartDataMonthly[11 - 1]) / $chartDataMonthly[11 - 1]) * 100;
                                }

                                $yearlyPercentageChange = 0;
                                if (isset($chartDataYearly[6], $chartDataYearly[6 - 1]) && $chartDataYearly[6 - 1] != 0) {
                                    $yearlyPercentageChange = (($chartDataYearly[6] - $chartDataYearly[6 - 1]) / $chartDataYearly[6 - 1]) * 100;
                                }
                            @endphp


                            @if ($dailyPercentageChange > 0)
                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                            @elseif($dailyPercentageChange < 0)
                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                            @else
                                ●
                            @endif
                            {{ abs($dailyPercentageChange) }}%
                        </span>
                        <div class="detail-value">{{ $chartLabelsDaily[6] }}</div>
                        <div class="detail-name">Today's Visits</div>
                    </div>

                    <div class="statistic-details-item">
                        <span class="text-muted">
                            @if ($weeklyPercentageChange > 0)
                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                            @elseif($weeklyPercentageChange < 0)
                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                            @else
                                ●
                            @endif
                            {{ $weeklyPercentageChange }}%
                        </span>
                        <div class="detail-value">{{ $chartLabelsWeekly[6] }}</div>
                        <div class="detail-name">This Week's Visits</div>
                    </div>

                    <div class="statistic-details-item">
                        <span class="text-muted">
                            @if ($monthlyPercentageChange > 0)
                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                            @elseif($monthlyPercentageChange < 0)
                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                            @else
                                ●
                            @endif
                            {{ $monthlyPercentageChange }}%
                        </span>
                        <div class="detail-value">{{ $chartLabelsMonthly[11] }}</div>
                        <div class="detail-name">This Month's Visits</div>
                    </div>

                    <div class="statistic-details-item">
                        <span class="text-muted">
                            @if ($yearlyPercentageChange > 0)
                                <span class="text-primary"><i class="fas fa-caret-up"></i></span>
                            @elseif($yearlyPercentageChange < 0)
                                <span class="text-danger"><i class="fas fa-caret-down"></i></span>
                            @else
                                ●
                            @endif
                            {{ $yearlyPercentageChange }}%
                        </span>
                        <div class="detail-value">{{ $chartLabelsYearly[6] }}</div>
                        <div class="detail-name">This Year's Visits</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Recent Activities</h4>
            </div>
            <div class="card-body">
                <ul class="list-unstyled list-unstyled-border">
                    @if (!empty($Statistic))
                        @php
                            $counter = 0;
                            $no = 1;
                        @endphp

                        @foreach ($Statistic as $row)
                            @if ($counter < 5)
                                @php
                                    $avatar = 'img/avatar/avatar-' . $no . '.png';
                                @endphp
                                <li class="media">
                                    <img class="mr-3 rounded-circle" width="50"
                                        src="{{ template_stisla($avatar) }}" alt="avatar">
                                    <div class="media-body">
                                        <div class="float-right text-primary">
                                            {{ Carbon\Carbon::parse($row->visit_time)->diffForHumans() }}</div>
                                        @php
                                            $no = ($no % 4) + 1;

                                            $getLocation = Stevebauman\Location\Facades\Location::get($row->ip_address);

                                            if ($getLocation) {
                                                $location = $getLocation->cityName . '-' . $getLocation->countryName;
                                            } else {
                                                $location = $row->ip_address;
                                            }

                                        @endphp
                                        <div class="media-title">{{ $location }}</div>
                                        <span class="text-small text-muted">Telah mengunjungi page @if ($row->url === '')
                                                home
                                            @else
                                                {{ $row->url }}
                                            @endif di browser
                                            {{ $row->browser }} menggunakan platform {{ $row->platform }}.</span>
                                    </div>
                                </li>
                                @php $counter++ @endphp
                            @endif
                        @endforeach
                    @endif


                </ul>
                {{-- <div class="text-center pt-1 pb-1">
                    <a href="#" class="btn btn-primary btn-lg btn-round">
                        View All
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Referral URL</h4>
            </div>
            <div class="card-body">
                @php
                    $groupedStatistics = $Statistic->groupBy('browser');
                    $totalStatistics = $Statistic->count();
                @endphp

                @foreach ($groupedStatistics as $browser => $statistics)
                    @php
                        $count = count($statistics);
                        $percentage = ($count / $totalStatistics) * 100;
                    @endphp
                    <div class="mb-4">
                        <div class="text-small float-right font-weight-bold text-muted">{{ $count }}</div>
                        <div class="font-weight-bold mb-1">{{ $browser }}</div>
                        <div class="progress" data-height="3" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" data-width="{{ $percentage }}%"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12">
        <div class="card">
            <div class="card-header">
                <h4>Popular Browser</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $groupedStatistics = $Statistic->groupBy('browser');
                        $totalStatistics = $Statistic->count();
                    @endphp

                    @foreach ($groupedStatistics as $browser => $statistics)
                        @php
                            $count = count($statistics);
                            $percentage = ($count / $totalStatistics) * 100;
                        @endphp
                        <div class="col text-center">
                            <div class="browser browser-{{ strtolower($browser) }}"></div>
                            <div class="mt-2 font-weight-bold">{{ $browser }}</div>
                            <div class="text-muted text-small"><span class="text-primary"><i
                                        class="fas fa-caret-up"></i></span> {{ round($percentage) }}%</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        var statistics_chart = document.getElementById("myChart").getContext('2d');

        // Initial chart data
        var initialData = {
            labels: @json($chartLabelsDaily),
            datasets: [{
                label: 'Statistics',
                data: @json($chartDataDaily),
                borderWidth: 5,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 4
            }]
        };

        const dataRange = Math.max(...@json($chartDataDaily)) - Math.min(...@json($chartDataDaily));
        const minimumStepSize = 5;
        const calculatedStepSize = Math.max(dataRange * 0.1, minimumStepSize);

        var myChart = new Chart(statistics_chart, {
            type: 'line',
            data: initialData,
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: calculatedStepSize
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fbfbfb',
                            lineWidth: 2
                        }
                    }]
                },
            }
        });

        $('#triggerDaily').on('click', function() {
            updateChartData('daily');
        });
        $('#triggerWeekly').on('click', function() {
            updateChartData('weekly');
        });
        $('#triggerMonthly').on('click', function() {
            updateChartData('monthly');
        });
        $('#triggerYearly').on('click', function() {
            updateChartData('yearly');
        });

        function updateChartData(timeRange) {
            // Remove 'btn-primary' class from all buttons
            document.getElementById('triggerDaily').classList.remove('btn-primary');
            document.getElementById('triggerWeekly').classList.remove('btn-primary');
            document.getElementById('triggerMonthly').classList.remove('btn-primary');
            document.getElementById('triggerYearly').classList.remove('btn-primary');

            // Add 'btn-primary' class to the clicked button
            if (timeRange === 'daily') {
                document.getElementById('triggerDaily').classList.add('btn-primary');
            } else if (timeRange === 'weekly') {
                document.getElementById('triggerWeekly').classList.add('btn-primary');
            } else if (timeRange === 'monthly') {
                document.getElementById('triggerMonthly').classList.add('btn-primary');
            } else if (timeRange === 'yearly') {
                document.getElementById('triggerYearly').classList.add('btn-primary');
            }

            function yearnow() {
                return new Date().getFullYear();
            }

            var newData = {};
            if (timeRange === 'daily') {
                newData.labels = @json($chartLabelsDaily);
                newData.datasets = [{
                    label: 'Statistics - ' + yearnow(),
                    data: @json($chartDataDaily),
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }];
            } else if (timeRange === 'weekly') {
                newData.labels = @json($chartLabelsWeekly);
                newData.datasets = [{
                    label: 'Statistics - ' + yearnow(),
                    data: @json($chartDataWeekly),
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }];
            } else if (timeRange === 'monthly') {
                newData.labels = @json($chartLabelsMonthly);
                newData.datasets = [{
                    label: 'Statistics - ' + yearnow(),
                    data: @json($chartDataMonthly),
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }];
            } else if (timeRange === 'yearly') {
                newData.labels = @json($chartLabelsYearly);
                newData.datasets = [{
                    label: 'Statistics',
                    data: @json($chartDataYearly),
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }];
            }

            myChart.data = newData;
            myChart.update();
        }
    });
</script>