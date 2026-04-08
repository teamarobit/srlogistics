<!-- header -->
<nav class="navbar navbar-expand-lg p-0">
  <!-- Container wrapper -->
  <div class="container-fluid srmegamenu ">
    <!-- Toggle button -->
    <span class="toggle-menu d-block d-lg-none" style="padding: 0.25rem 0.5rem;">
      <img src="{{ asset('public/images/icons/ham.svg') }}" alt="Ham Menu" width="20" height="14">
    </span>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav mx-auto">

        <li class="nav-item">
          <a class="nav-link text-white {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
              <img src="{{ asset('public/images/menu-icon/Dashboard.png') }}">Dashboard </a>
        </li>

        <li class="nav-item">

          <a href="javascript:void(0)" class="nav-link text-white"><img src="{{ asset('public/images/menu-icon/vehicles.webp') }}">Fleet</a>
          
          <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
            
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/vehicle-details.png') }}"></span>Vehicle</li>
                      
                      @if(Route::has('fleetdashboard.index'))
                      <li><a href="{{ route('fleetdashboard.index') }}">Vehicle Dashboard</a></li>
                      @endif
                      
                      <li><a href="vehicle-document-status.php">Vehicle Document Status</a></li>
                      <li><a href="{{ route('tyre.dashboard') }}">Tyre Dashboard</a></li>
                      <li><a href="fitness-status.php">Fitness Status</a></li>
                      <li><a href="#">Route Permit Tracker</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title mb-4"></li>
                      <li><a href="fuel-logs.php">Fuel Logs</a></li>
                      <li><a href="#">Odometer Tracking</a></li>
                      <li><a href="#">Performance Analytics</a></li>
                      <li><a href="#">Live GPS Tracking</a></li>
                    </ul>
                  </div>
            
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/vehicle-details.png') }}"></span>Driver</li>
                      <li><a href="driver.php">Driver Dashboard</a></li>
                      <li><a href="#">Driver Documents</a></li>
                      <li><a href="#">Driver RAG Status</a></li>
                      <li><a href="#">Driver Settlement</a></li>
                    </ul>
                  </div>
            
                  
                </div>
              </div>
            </div>
          
        </li>

        <li class="nav-item">
          <a class="nav-link text-white" href="javascript:void(0)"><img src="{{ asset('public/images/menu-icon/road-trip.webp') }}">Freight</a>
          <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/vehicle-details.png') }}"></span>Trip Planning</li>
                      <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addTrip">Create Trip</a></li>
                      <li><a href="trips.php">Trip Tracking</a></li>
                      <li><a href="#">Vehicle & Trip Approval</a></li>
                      <li><a href="#">Eways</a></li>
                      <li><a href="#">LR</a></li>
                      <li><a href="#">Toll History</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title mb-4"></li>
                      <li><a href="#">Proof of Delivery (POD Upload)</a></li>
                      <li><a href="#">Return Trips management (Empty Return / Return Load)</a></li>
                      <li><a href="#">Driver Hisab</a></li>
                      <li><a href="#">Kilometer Book</a></li>
                      <li><a href="#">Daily Report</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Exception Management</li>
                      <li><a href="driver.php">Delay Alerts</a></li>
                      <li><a href="#">Breakdown Logs</a></li>
                      <li><a href="#">Trip Reassignment</a></li>
                      <li><a href="#">Customer Notifications</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </li>

        
        <li class="nav-item">
        <a class="nav-link text-white" href="#"><img src="{{ asset('public/images/menu-icon/Production.png') }}">Service</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/vehicle-details.png') }}"></span>Service Requests</li>
                      <li><a href="#">Create New Service Request</a></li>
                      <li><a href="#">Breakdown Request</a></li>
                      <li><a href="#">Routine Maintenance Request</a></li>
                      <li><a href="#">Tyre Change Request</a></li>
                      <li><a href="#">Battery Change Request</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Workshop / Service Center Operations</li>
                      <li><a href="driver.php">Job Card Creation</a></li>
                      <li><a href="#">Job Card</a></li>
                      <li><a href="#">Spare Part Consumption</a></li>
                      <li><a href="#">Vendor Service Billing</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Maintenance Scheduling</li>
                      <li><a href="driver.php">Preventive Maintenance Calendar</a></li>
                      <li><a href="#">KM-Based Service Alerts</a></li>
                      <li><a href="#">Engine Oil Change Alerts</a></li>
                      <li><a href="#">Tyre Rotation/Change Scheduler</a></li>
                      <li><a href="#">AMC Contract Reminders</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Inventory (Service-Level Only)</li>
                      <li><a href="driver.php">Purchase Order </a></li>
                      <li><a href="#">GRN</a></li>
                      <li><a href="#">Tyre Inventory</a></li>
                      <li><a href="#">Battery Inventory</a></li>
                      <li><a href="#">Spare Parts Consumption Logs</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link text-white" href="#"><img src="{{ asset('public/images/menu-icon/Production.png') }}">Finance</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/vehicle-details.png') }}"></span>Freight Billing</li>
                      <li><a href="create-invoice.php">Create Invoice</a></li>
                      <li><a href="invoice-list.php">Invoices</a></li>
                      <li><a href="#">Customer & Broker ledger</a></li>
                      <li><a href="create-receipt.php">Create Money Receipt </a></li>
                      <li><a href="money-receipts.php">Money Receipts</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Payments</li>
                      <li><a href="#">Driver Settlement</a></li>
                      <li><a href="#">Vendor Settlement</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Trip Expense Management</li>
                      <li><a href="#">Fuel Expenses</a></li>
                      <li><a href="#">Driver Allowances</a></li>
                      <li><a href="#">Repair Charges</a></li>
                      <li><a href="#">Advance Requests</a></li>
                      <li><a href="#">Reimbursements</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/fleet-monitoring.png') }}"></span>Inventory (Service-Level Only)</li>
                      <li><a href="driver.php">Purchase Order </a></li>
                      <li><a href="#">GRN</a></li>
                      <li><a href="#">Tyre Inventory</a></li>
                      <li><a href="#">Battery Inventory</a></li>
                      <li><a href="#">Spare Parts Consumption Logs</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link text-white" href="#"><img src="{{ asset('public/images/menu-icon/Production.png') }}">Reports & Analytics</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('public/images/menu-icon/vehicle-details.png') }}"></span>Billing & Invoicing</li>
                      <li><a href="#">Fleet Utilization</a></li>
                      <li><a href="#">Driver Performance</a></li>
                      <li><a href="#">Trip Profitability</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </li>

      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->
    
    <!--mobile logo-->
      <a class="navbar-brand mt-2 mt-lg-0 d-block d-lg-none" href="index.php">
        <img src="{{ asset('public/images/logo.png') }}" width="78" height="46" alt="Logo" loading="lazy"/>
      </a>
    <!-- Right elements -->
    <div class="d-flex align-items-center mob-adjust">
      
      <!-- Notifications -->
      <div class="dropdown me-4">
        <a
          data-mdb-dropdown-init
          class="text-reset notification-wrap dropdown-toggle hidden-arrow"
          href="javascript:void(0)"
          id="notificationDropdown"
          role="button"
          aria-expanded="false">
          <!--<i class="uil uil-bell text-white" style="font-size: 22px;"></i>-->
          <img src="{{ asset('public/images/menu-icon/notification.png') }}" alt="Notification" width="22" height="22">
        </a>
        <ul
          class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
          aria-labelledby="notificationDropdown">
            <div class="dd-head">
                <h6 class="">Notifications</h6>
                <span class="float-end"><a href="javascript:void(0)">Mark as Read</a></span>
            </div>
            
            <div class="dropdown-menu-body">
                <div class="notify-list"> 
                    <a href="javascript:void(0)" class="d-flex w-100">
                        <span class="notify-circle me-3 flex-shrink-0">
                            <i class="uil uil-bell text-white"></i>
                        </span>
                        <div>
                            <h6 class="mb-0">Trip alerts</h6>
                            <span class="text-small">2 min ago</span>
                        </div>
                    </a>
                </div>
                <div class="notify-list">
                    <a href="javascript:void(0)" class="d-flex w-100">
                        <span class="notify-circle me-3 flex-shrink-0">
                            <i class="uil uil-bell text-white"></i>
                        </span>
                        <div>
                            <h6 class="mb-0">Document expiry alerts</h6>
                            <span class="text-small">2 min ago</span>
                        </div>
                    </a>
                </div>
                <div class="notify-list">
                    <a href="javascript:void(0)" class="d-flex w-100">
                        <span class="notify-circle me-3 flex-shrink-0">
                            <i class="uil uil-bell text-white"></i>
                        </span>
                        <div>
                            <h6 class="mb-0">Maintenance reminders</h6>
                            <span class="text-small">4w ago</span>
                        </div>
                    </a>
                </div>
                <div class="notify-list">
                    <a href="javascript:void(0)" class="d-flex w-100">
                        <span class="notify-circle me-3 flex-shrink-0">
                            <i class="uil uil-bell text-white"></i>
                        </span>
                        <div>
                            <h6 class="mb-0">Payment reminders</h6>
                            <span class="text-small">4w ago</span>
                        </div>
                    </a>
                </div>
                <div class="notify-list">
                    <a href="javascript:void(0)" class="d-flex w-100">
                        <span class="notify-circle me-3 flex-shrink-0">
                            <i class="uil uil-bell text-white"></i>
                        </span>
                        <div>
                            <h6 class="mb-0">Exception alerts</h6>
                            <span class="text-small">4w ago</span>
                        </div>
                    </a>
                </div>
            </div>
        </ul>
      </div>

      <div class="d-inline-block me-4">
          <button class="btn header-dd" type="button">
            {{ organisation_name() }}
          </button>
      </div>
      <!-- Avatar -->
      <div class="dropdown header-dd-wrap">
        <a
          data-mdb-dropdown-init
          class="dropdown-toggle d-flex align-items-center hidden-arrow"
          href="javascript:void(0)"
          id="avatarDropdown"
          role="button"
          aria-expanded="false"
        >
          <!--<i class="uil uil-user-circle text-white" style="font-size: 22px;"></i>-->
          <img src="{{ asset('public/images/menu-icon/profile.png') }}" alt="Profile" width="22" height="22">
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <div class="dd-right srlh-rtuser">
                <div class="text-center">

                    <span class="avatar bg-avatar-primary">{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : '' }}</span>

                    <h5 class="mb-1 mt-2 user-title">{{ auth()->check() ? auth()->user()->name : '' }}</h5>

                    <p class="mb-0 n-designa">Founder & CEO</p>
                    
                </div>

                <div class="mt-4">
                    @if (Route::has('adminconsole.index'))
                    <li><a href="{{ route('adminconsole.index') }}" class="dropdown-item" style="color: #1E1F21;"><i class="fa fa-sliders me-3" style="color: #6F7071;"></i>Admin Console</a></li>
                    @endif
                    <li><a href="javascript:void(0)" class="dropdown-item" style="color: #1E1F21;"><i class="uil uil-user-circle me-3" style="color: #6F7071;"></i>Profile</a></li>
                    <li><a href="javascript:void(0)" class="dropdown-item" style="color: #1E1F21;"><i class="uil uil-setting me-3" style="color: #6F7071;"></i>Settings</a></li>
                    <li>
                        <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="#" class="dropdown-item" style="color: #1E1F21;"><i class="uil uil-sign-out-alt me-3" style="color: #6F7071;"></i>Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        
                    </li>
                    
                </div>
            </div>
        </ul>
      </div>
    </div>
    <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- header -->

<div class="modal fade" id="addTrip" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        
      <div class="modal-header">
        <h5 class="modal-title">Create Trip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
      </div>
      
      <div class="modal-body">
        <form>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Trip ID</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" class="form-control bg-light" readonly placeholder="Will be auto generated"/>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Trip Date</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" id="daterange" class="form-control" placeholder="DD/MM/YYYY">
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Trip Type</label>
                </div>
                <div class="col-12 col-md-9">
                    <select class="form-select">
                        <option>Choose..</option>
                        <option>Own Booking</option>
                        <option>Outside Booking</option>
                    </select>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Load Vendor</label>
                </div>
                <div class="col-12 col-md-9">
                    <select class="form-select">
                        <option>Choose..</option>
                        <option>DHL</option>
                        <option>Blue Dart</option>
                        <option>Fed Ex</option>
                    </select>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Customer</label>
                </div>
                <div class="col-12 col-md-9">
                    <select class="form-select">
                        <option>Choose..</option>
                        <option>Nestle</option>
                        <option>Britania</option>
                        <option>Samsung</option>
                    </select>
                </div>
            </div>
            
            <div class="text-end mb-4">
                <a href="add-customer.php" style="font-size: 13px;"><i class="uil uil-plus me-2"></i> Add Customer</a>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Vehicle Requirement</label>
                </div>
                <div class="col-12 col-md-9">
                    <select class="form-select">
                        <option>Choose..</option>
                        <option>32FT</option>
                        <option>24FT</option>
                    </select>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Internal Trip ID</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" class="form-control"/>
                </div>
            </div>
           
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Route</label>
                </div>
                <div class="col-12 col-md-9">
                    <select class="form-select select2-modal">
                        <option>Choose..</option>
                        <option>Chennai - Kolkata</option>
                        <option>Chennai - Hydrabad</option>
                    </select>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Source</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" class="form-control bg-light" value="Chennai" />
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12">
                    <div class="add-stop">
                        <div class="row form-group">
                            <div class="col-12 col-md-3">
                                <label>Stop 1</label>
                            </div>
                            <div class="col-10 col-md-8">
                                <input type="text" class="form-control"/>
                            </div>
                            <div class="col-2 col-md-1">
                                <i class="uil uil-trash-alt text-danger removeStop"></i>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-secondary add-stop-btn"><i class="uil uil-plus me-1"></i>Stop</a>
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Destination</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" class="form-control bg-light" readonly value="Kolkata" />
                </div>
            </div>
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Distance</label>
                </div>
                <div class="col-12 col-md-9">
                    <input type="text" class="form-control bg-light" readonly value="10 KM" />
                </div>
            </div>
            
            <!--<div class="row form-group">-->
            <!--    <div class="col-12 col-md-3">-->
            <!--        <label>Consigner</label>-->
            <!--    </div>-->
            <!--    <div class="col-12 col-md-9">-->
            <!--        <select class="form-select select2-modal">-->
            <!--            <option>Choose..</option>-->
            <!--            <option>Samsung India Hydrabad</option>-->
            <!--            <option>Britania Kolkata</option>-->
            <!--        </select>-->
            <!--    </div>-->
            <!--</div>-->
            <!--<div class="row form-group">-->
            <!--    <div class="col-12 col-md-3">-->
            <!--        <label>Consignee</label>-->
            <!--    </div>-->
            <!--    <div class="col-12 col-md-9">-->
            <!--        <select class="form-select select2-modal">-->
            <!--            <option>Choose..</option>-->
            <!--            <option>Samsung India Hydrabad</option>-->
            <!--            <option>Britania Kolkata</option>-->
            <!--        </select>-->
            <!--    </div>-->
            <!--</div>-->
            
            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Priority</label>
                </div>
                <div class="col-12 col-md-9">
            
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priority" id="priority_normal" value="Normal">
                        <label class="form-check-label" for="priority_normal">Normal</label>
                    </div>
            
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="priority" id="priority_urgent" value="Urgent">
                        <label class="form-check-label" for="priority_urgent">Urgent</label>
                    </div>
            
                </div>
            </div>

            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Tarpaulin</label>
                </div>
                <div class="col-12 col-md-9">
            
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tirpal" id="tirpal_yes" value="Yes">
                        <label class="form-check-label" for="tirpal_yes">Yes</label>
                    </div>
            
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tirpal" id="tirpal_no" value="No">
                        <label class="form-check-label" for="tirpal_no">No</label>
                    </div>
            
                </div>
            </div>

            
            <div class="row form-group">
                <div class="col-12 col-md-3">
                    <label>Comment</label>
                </div>
                <div class="col-12 col-md-9">
                    <textarea class="form-control" rows="4"></textarea>
                </div>
            </div>

            <div class="text-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    //$(document).ready(function(){
        // $('.add-stop-btn').click(function(){
        //     $('.add-stop').show();
        // });
        
        // $('.removeStop').click(function(){
        //     $('.add-stop').hide();
        // });
    //})
</script>