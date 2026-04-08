@extends('layouts.app')

@section('css')

@section('content')

<div class="layout-wrapper">
    
    @include('includes.header')
    
    <div class="wrapper srlog-bdwrapper">

            <div class="bg-dashboard">
                <div class="container">
                    <div class="welcome-banner text-center">
                        @php
                            $now = \Carbon\Carbon::now('Asia/Kolkata'); // convert to IST
                            $hour = $now->format('H');
                        
                            if ($hour < 12) {
                                $greeting = "Good Morning";
                            } elseif ($hour < 17) {
                                $greeting = "Good Afternoon";
                            } elseif ($hour < 21) {
                                $greeting = "Good Evening";
                            } else {
                                $greeting = "Good Night";
                            }
                        @endphp
                        
                        <p>{{ $now->format('l, F j') }}</p>
                        
                        <h4>{{ $greeting }}, {{ auth()->check() ? auth()->user()->name : '' }}</h4>
                        
                        <div class="welcome-filter mt-4">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <select class="selectpicker borderless-select">
                                        <option>My Week</option>
                                        <option>My Month</option>
                                        <option>2 Months ago</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mid-sec">
                                        <span class="me-1"><i class="uil uil-check"></i></span>
                                        <span class="me-1">0</span>
                                        <span class="text">Task Completed</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mid-sec">
                                        <span class="me-1"><i class="uil uil-user"></i></span>
                                        <span class="me-1">0</span>
                                        <span class="text">Collaborators</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid" style="display:none;">
                
                <div class="row mt-4">
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Create PO</h6>
                                <p>Create Purchase Order</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Purchase Order</h6>
                                <p>Purchase Order List</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Create WIM</h6>
                                <p>Create Purchase Order</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Weigh Bridge</h6>
                                <p>Create Purchase Order</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Create SO</h6>
                                <p>Create Sales Order</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Record Production</h6>
                                <p>Create Purchase Order</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Create Order</h6>
                                <p>Create Purchase Order</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <a href="#" class="d-flex flex-shrink align-items-center dashboard-cart">
                            <span><img src="images/icons/dashboard-cart.svg" alt="Dashboard" width="24px"></span>
                            <div>
                                <h6>Create Order</h6>
                                <p>Create Purchase Order</p>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="mt-4">
                    <!--page content-->
                    <div class="row">
                        <div class="col-xxl-9 col-lg-9 col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="bg-card card1">
                                        <p class="mb-0 text-white card-ttle">Total Receivable</p>
                                        <div class="progress mt-3">
                                          <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <h5 class="mb-1 text-white">$1645.00</h5>
                                                <p class="mb-0 text-white">Current</p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <h5 class="mb-1 text-white">$2273.00</h5>
                                                <p class="mb-0 text-white">Overdue</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="bg-card card2">
                                        <p class="mb-0 text-white card-ttle">Total Payables</p>
                                        <div class="progress mt-3">
                                          <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <h5 class="mb-1 text-white">$2345.00</h5>
                                                <p class="mb-0 text-white">Current</p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <h5 class="mb-1 text-white">$1243.00</h5>
                                                <p class="mb-0 text-white">Overdue</p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card widget mt-4 d-none d-md-block">
                                <div class="card-header invoice-wrap">
                                    <h5 class="card-title mb-0 d-inline-block text-theme">Pending PO</h5>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive d-none d-md-block">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox"></th>
                                                    <th>PO Number</th>
                                                    <th>
                                                        Vendor Name
                                                    </th>
                                                    <th>Amount</th>
                                                    <th class="text-end">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        PO#1100
                                                    </td>
                                                    <td>Annapurna</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        PO#1101
                                                    </td>
                                                    <td>Annapurna</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        PO#1102
                                                    </td>
                                                    <td>Annapurna</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        PO#1103
                                                    </td>
                                                    <td>Annapurna</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!--mobile view table-->
                                    <div class="table-responsive d-block d-md-none">
                                        <table class="table table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p><strong>Wade</strong></p>
                                                        <p>vvm1</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 1,600.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Brooklyn</strong></p>
                                                        <p>vvm2</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 200.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Guy</strong></p>
                                                        <p>vvm2</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 200.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Jacob</strong></p>
                                                        <p>vvm4</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 300.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Darlene</strong></p>
                                                        <p>vvm5</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 600.00
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="card-header invoice-wrap">
                                    <h5 class="card-title mb-0 d-inline-block text-theme">Pending SO</h5>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive d-none d-md-block">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox"></th>
                                                    <th>SO Number</th>
                                                    <th>
                                                        Vendor Name
                                                    </th>
                                                    <th>Amount</th>
                                                    <th class="text-end">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1245
                                                    </td>
                                                    <td>Sagar Co.</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1011
                                                    </td>
                                                    <td>Kamal Traders</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1200
                                                    </td>
                                                    <td>Mohan Mills</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1230
                                                    </td>
                                                    <td>Tridha Sons</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="table-responsive d-block d-md-none">
                                        <table class="table table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p><strong>Wade</strong></p>
                                                        <p>vvm1</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 1,600.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Brooklyn</strong></p>
                                                        <p>vvm2</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 200.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Guy</strong></p>
                                                        <p>vvm2</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 200.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Jacob</strong></p>
                                                        <p>vvm4</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 300.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Darlene</strong></p>
                                                        <p>vvm5</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 600.00
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                
                                <div class="card-header invoice-wrap">
                                    <h5 class="card-title mb-0 d-inline-block text-theme">Last transaction</h5>
                                </div>
                                
                                <div class="card-body">
                                    <div class="table-responsive d-none d-md-block">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox"></th>
                                                    <th>Order Number</th>
                                                    <th>
                                                        Vendor Name
                                                    </th>
                                                    <th>Amount</th>
                                                    <th class="text-end">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        PO#1245
                                                    </td>
                                                    <td>Annapurna</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1245
                                                    </td>
                                                    <td>Tridha Sons</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1245
                                                    </td>
                                                    <td>Kamal Traders</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <input type="checkbox">
                                                    </td>
                                                    <td>
                                                        SO#1245
                                                    </td>
                                                    <td>Mohan Mills</td>
                                                    <td>
                                                        $1468.00
                                                    </td>
                                                    <td class="text-end">
                                                        Pending
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!--mobile view table-->
                                    <div class="table-responsive d-block d-md-none">
                                        <table class="table table-hover mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p><strong>Wade</strong></p>
                                                        <p>vvm1</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 1,600.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Brooklyn</strong></p>
                                                        <p>vvm2</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 200.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Guy</strong></p>
                                                        <p>vvm2</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 200.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Jacob</strong></p>
                                                        <p>vvm4</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 300.00
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        <p><strong>Darlene</strong></p>
                                                        <p>vvm5</p>
                                                        <p>15.02.2023</p>
                                                    </td>
                                                    <td class="text-end">
                                                        R 600.00
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!------>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xxl-3 col-lg-3 col-12">
                            <button class="dashboard-btn btn1">
                                <img src="images/icons/btn1.svg" class="me-2" width="18">
                                <span>Sales Dashboard</span>
                            </button>
                            <button class="dashboard-btn btn2">
                                <img src="images/icons/btn2.svg" class="me-2" width="18">
                                <span>Inventory Dashboard</span>
                            </button>
                            <button class="dashboard-btn btn3">
                                <img src="images/icons/btn3.svg" class="me-2" width="18">
                                <span>Production Dashboard</span>
                            </button>
                            <button class="dashboard-btn btn4">
                                <img src="images/icons/btn2.svg" class="me-2" width="18">
                                <span>Retail Dashboard</span>
                            </button>
                            <button class="dashboard-btn btn5">
                                <img src="images/icons/btn5.svg" class="me-2" width="18">
                                <span>Account Dashboard</span>
                            </button>
                            <img src="images/chart.png" alt="" width="100%">
                            
                        </div>
                    </div>
                    
                                        
                </div>
            </div>
        </div>
    
</div>

@endsection

@section('js')






