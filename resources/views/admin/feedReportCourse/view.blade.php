@extends('layouts.admin')
@section('content')
    <style>
        .select2 {
            width: 100% !important;
        }

        .details {
            margin: 10px 0;
        }

        .details span {
            padding: 10px;
            /* background-color: #007bff;
                                                                color: white; */
            border-radius: 3px;
        }

        .details .row {
            margin-bottom: 10px;
        }
    </style>
    <div class="card">
        <div class="card-header">
            Bar Chart Report
        </div>
        <div class="card-body">
            <div style="width: 80%;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            Student Course Feedback Report
        </div>
        <div class="card-body">
            <div class="details">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <span><strong>Class : </strong>{{ $get_feed[0]->enroll ?? '' }}</span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <span><strong>Participant : </strong>{{ $get_feed[0]->feedback_participant }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">

                        <span><strong>Type : </strong>{{ $get_feed[0]->feedback_type }}</span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <span><strong>Feedback Name : </strong>{{ $get_feed[0]->feedback->name }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <span><strong>Staff Name : </strong>{{ $get_feed[0]->teaching->name }}</span>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <span><strong>Subject :
                            </strong>{{ $get_feed[0]->subject_name }}({{ $get_feed[0]->subject_code }})</span>
                    </div>
                </div>
            </div>
            <table
                class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-feedbackReport text-center">
                <thead>
                    @php
                        $rate = ['Poor', 'Fair', 'Good', 'Best', 'Excelent'];
                    @endphp
                    <tr>
                        <th>S.No</th>
                        <th>Question</th>
                        @for ($i = 0; $i < $get_feed[0]->rating_scale; $i++)
                            <th>{{ $rate[$i] }}</th>
                        @endfor
                        <th>Percentage (%)</th>
                        <th>5 Scale</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach ($get_feed as $id => $item)
                        <tr>
                            <td>{{ $id + 1 }}</td>
                            <td style="text-transform: uppercase;">{{ $item->question_name }}</td>
                            <td>{{ $item->one_star }}</td>
                            <td>{{ $item->two_star }}</td>
                            <td>{{ $item->three_star }}</td>
                            <td>{{ $item->four_star }}</td>
                            <td>{{ $item->five_star }}</td>
                            <td>{{ $item->star_percent }} %</td>
                            <td>{{ $item->five_scale }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="secondLoader"></div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function convertPercentagesToNumbers(data) {
            return data;
        }

        var ctx = document.getElementById('barChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Data',
                    data: convertPercentagesToNumbers(@json($data['data'])),
                    backgroundColor: function(context) {
                        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(75, 192, 192, 0.5)');
                        gradient.addColorStop(1, 'rgba(75, 192, 192, 0.2)');
                        return gradient;
                    },
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    barThickness: 30,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                family: 'Arial',
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `Value: ${tooltipItem.raw}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12,
                                family: 'Arial',
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: .5,
                            font: {
                                size: 12,
                                family: 'Arial'
                            }
                        },
                        grid: {
                            color: 'rgba(200, 200, 200, 0.5)'
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            }
        });
    </script>
@endsection
