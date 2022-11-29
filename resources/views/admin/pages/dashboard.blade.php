@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('mainContent')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><i class="fa fa-home" aria-hidden="true"></i> Dashboard</h2>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-promocode_count bg-darken-2">
                            <i class="fa fa-money fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-promocode_count white media-body">
                            <h3>Currency</h3>
                            <h5 class="text-bold-400 mb-0">{{$totalCurrency}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.currency.index') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-todayBooking_count bg-darken-2">
                            <i class="fa fa-building-o fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-todayBooking_count white media-body">
                            <h3>Companies</h3>
                            <h5 class="text-bold-400 mb-0">{{$TotalCompanies}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.companies.index') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-review_count bg-darken-2">
                            <i class="fa fa-list-alt fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-review_count white media-body">
                            <h3>Category</h3>
                            <h5 class="text-bold-400 mb-0">{{$totalCategory}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.category.index') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-user_count bg-darken-2">
                            <i class="fa fa-users fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-user_count white media-body">
                            <h3>Clients</h3>
                            <h5 class="text-bold-400 mb-0">{{$TotalClient}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.clients.index_clients') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12 mt-5">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-driver_count bg-darken-2">
                            <i class="fa fa-arrow-down fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-driver_count white media-body">
                            <h3>InWards</h3>
                            <h5 class="text-bold-400 mb-0"> {{$totalTransactionInward}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.type.inwardtype') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12 mt-5">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-company_count bg-darken-2">
                            <i class="fa fa-arrow-up fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-company_count white media-body"><h3>OutWards</h3>
                            <h5 class="text-bold-400 mb-0"> {{$totalTransactionOutward}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.type.outwardtype') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-12 mt-5">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-vehicles_count bg-darken-2">
                            <i class="fa fa-arrows-alt fa-3x icon_admin"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-vehicles_count white media-body">
                            <h3>Others</h3>
                            <h5 class="text-bold-400 mb-0">{{$totalTransactionOther}}</h5>
                            <div class="media-left media-middle mt-1">
                                <a class="white" href="{{ route('admin.type.othertype') }}">View more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(sizeof($CompaniesBalance) > 0)
    <div class="container p-5">
        <div id="piechart" style="width: 900px; height: 500px;"></div>
    </div>
    @endif
</div>
@endsection
@section('styles')
<style type="text/css">
.ibox-content{background-color:#fff; border: none; border-style:none !important;}
.wrapper-content{padding: 20px 10px 40px;}
.white{color:#FFF;}
.white:hover{color:#FFF;}
.bg-user_count {background-color: #00A5A8 !important;}
.bg-gradient-x-user_count {background-image: linear-gradient(to right, #00A5A8 0%, #4DCBCD 100%); background-repeat: repeat-x;}
.bg-driver_count {background-color: #FF6275 !important;}
.bg-gradient-x-driver_count {background-image: linear-gradient(to right, #FF6275 0%, #FF9EAC 100%); background-repeat: repeat-x;}
.bg-company_count {background-color: #fc7703 !important;}
.bg-gradient-x-company_count {background-image: linear-gradient(to right, #fc7703 0%, #FF976A 100%); background-repeat:repeat-x;}
.bg-todayBooking_count {background-color: #10C888 !important;}
.bg-gradient-x-todayBooking_count {background-image: linear-gradient(to right, #10C888 0%, #5CE0B8 100%); background-repeat: repeat-x;}
.bg-todayProfit_count {background-color: #d8db21!important;}
.bg-gradient-x-todayProfit_count {background-image: linear-gradient(to right, #d8db21 0%, #edeb6b 100%); background-repeat: repeat-x;}
.bg-vehicles_count {background-color: #4b5ff1!important;}
.bg-gradient-x-vehicles_count {background-image: linear-gradient(to right, #4b5ff1 0%, #6CDDEB 100%); background-repeat: repeat-x;}
.bg-adminProfit_count {background-color: #FF5733!important;}
.bg-gradient-x-adminProfit_count {background-image: linear-gradient(to right, #FF5733 0%, #ed836b 100%);
background-repeat: repeat-x;}
.bg-review_count {background-color: #fcbe03!important;}
.bg-gradient-x-review_count {background-image: linear-gradient(to right, #fcbe03 0%, #fdd868 100%);
background-repeat: repeat-x;}
.bg-promocode_count{background-color: #8803fc !important;}
.bg-gradient-x-promocode_count{background-image: linear-gradient(to right, #8803fc 0%, #cf9afe 100%);
background-repeat: repeat-x;}
.bg-emergency_count {background-color: #33FFBD!important;}
.bg-gradient-x-emergency_count {background-image: linear-gradient(to right, #33FFBD 0%, #b3ffe7 100%);
background-repeat: repeat-x;}
.card{color:#FFF!important; font-weight: 600!important; font-size: 1.14rem!important;}
.p-2 {padding: 1rem!important;}
#dynamic_data {margin: 2em auto;}
#container_chart{margin: 0 auto;}
.nprofit-bg {background-color: #7a8e8a !important; color: #ffffff;}
.emergency-bg {background-color: #eadddd;}
.rating-bg {background-color: #627d7d !important; color: #ffffff;}
.to_profit-bg{background-color: #ab6e2b !important; color: #ffffff;}
.gm-style-iw-d{overflow: hidden !important;}
.fa-3x {font-size: 3em;}
</style>
@endsection
@section('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Companies Name', 'Registered Companies Count'],
        @php
        foreach($CompaniesBalance as $d) {
            echo "['".$d->company_uid."', ".$d->balance."],";
        }
        @endphp
        ]);
    var options = {
        title: 'Companies Detail',
        is3D: false,
    };
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
</script>
@endsection