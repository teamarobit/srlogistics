<!-- header -->
<nav class="navbar navbar-expand-lg p-0">
  <!-- Container wrapper -->
  <div class="container-fluid srmegamenu ">
    <!-- Toggle button -->
    <span class="toggle-menu d-block d-lg-none" style="padding: 0.25rem 0.5rem;">
      <img src="{{ asset('images/icons/ham.svg') }}" alt="Ham Menu" width="20" height="14">
    </span>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav mx-auto">

        <li class="nav-item">
          <a class="nav-link text-white {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
              <img src="{{ asset('images/menu-icon/Dashboard.png') }}">Dashboard </a>
        </li>

        <li class="nav-item">

          <a href="javascript:void(0)" class="nav-link text-white {{ request()->routeIs('fleet.*', 'fleetdashboard.*', 'tyre.*', 'battery.*') ? 'active' : '' }}"><img src="{{ asset('images/menu-icon/vehicles.webp') }}">Fleet</a>
          
          <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
            
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Vehicle</li>
                      
                      @if(Route::has('fleetdashboard.index'))
                      <li><a href="{{ route('fleetdashboard.index') }}">Vehicle Dashboard</a></li>
                      @endif
                      
                      @if(Route::has('fleet.compliance.document-expiry'))
                      <li class="{{ request()->routeIs('fleet.compliance.document-expiry') ? 'active' : '' }}"><a href="{{ route('fleet.compliance.document-expiry') }}">Vehicle Document Status</a></li>
                      @endif
                      <li><a href="{{ route('tyre.dashboard') }}">Tyre Dashboard</a></li>
                      <li><a href="{{ route('tyre.owner-dashboard') }}">Tyre Owner Dashboard</a></li>
                      <li><a href="{{ route('battery.owner-dashboard') }}">Battery Owner Dashboard</a></li>
                      @if(Route::has('fleet.compliance.permit-fitness'))
                      <li><a href="{{ route('fleet.compliance.permit-fitness') }}">Fitness Status</a></li>
                      <li><a href="{{ route('fleet.compliance.permit-fitness') }}">Route Permit Tracker</a></li>
                      @endif
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title mb-4"></li>
                      <li><a href="#">Fuel Logs</a></li>
                      <li><a href="#">Odometer Tracking</a></li>
                      <li><a href="#">Performance Analytics</a></li>
                      <li><a href="#">Live GPS Tracking</a></li>
                    </ul>
                  </div>
            
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Driver</li>
                      <li><a href="{{ route('fleetdashboard.drivers') }}">Driver Dashboard</a></li>
                      <li><a href="{{ route('fleetdashboard.drivers') }}">Driver Documents</a></li>
                      <li><a href="#">Driver RAG Status</a></li>
                      <li><a href="#">Driver Settlement</a></li>
                    </ul>
                  </div>

                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Compliance & Insurance</li>
                      @if(Route::has('fleet.vehicle-insurance.index'))
                      <li><a href="{{ route('fleet.vehicle-insurance.index') }}">Vehicle Insurance Policies</a></li>
                      @endif
                      @if(Route::has('fleet.insurance.index'))
                      <li><a href="{{ route('fleet.insurance.index') }}">Insurance Claims</a></li>
                      @endif
                      @if(Route::has('fleet.compliance.policy-renewal'))
                      <li><a href="{{ route('fleet.compliance.policy-renewal') }}">Policy Renewal Tracker</a></li>
                      @endif
                      @if(Route::has('fleet.compliance.document-expiry'))
                      <li class="{{ request()->routeIs('fleet.compliance.document-expiry') ? 'active' : '' }}"><a href="{{ route('fleet.compliance.document-expiry') }}">Vehicle Document Expiry</a></li>
                      @endif
                      @if(Route::has('fleet.compliance.permit-fitness'))
                      <li><a href="{{ route('fleet.compliance.permit-fitness') }}">Permit & Fitness Tracker</a></li>
                      @endif
                    </ul>
                  </div>

                </div>
              </div>
            </div>

        </li>

        <li class="nav-item">
          <a class="nav-link text-white" href="javascript:void(0)"><img src="{{ asset('images/menu-icon/road-trip.webp') }}">Freight</a>
          <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Trip Planning</li>
                      <li><a href="{{ route('trip.create') }}">Create Trip</a></li>
                      <li><a href="{{ route('trip.index') }}">Trip Tracking</a></li>
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
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Exception Management</li>
                      <li><a href="#">Delay Alerts</a></li>
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
        <a class="nav-link text-white {{ request()->routeIs('ws.*') ? 'active' : '' }}" href="{{ route('ws.dashboard') }}"><img src="{{ asset('images/menu-icon/Production.png') }}">Workshop</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">

                  {{-- Service Requests --}}
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Service Requests</li>
                      <li><a href="{{ route('ws.dashboard') }}">Workshop Dashboard</a></li>
                      <li><a href="{{ route('ws.service-request.index') }}">New Service Request</a></li>
                      <li><a href="{{ route('ws.appointment.index') }}">Appointments</a></li>
                      <li><a href="{{ route('ws.in-token.index') }}">Gate Entry (In-Token)</a></li>
                      <li><a href="{{ route('ws.workshop.onroad') }}">On-Road Service</a></li>
                    </ul>
                  </div>

                  {{-- Workshop (In-House) --}}
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Workshop</li>
                      <li><a href="{{ route('ws.workshop.job-list') }}">Job Cards</a></li>
                      {{-- Technician Dashboard: hidden until ready -- <li><a href="#">Technician Dashboard</a></li> --}}
                      <li><a href="{{ route('ws.workshop.billing') }}">Billing</a></li>
                      <li><a href="{{ route('ws.workshop.delivery') }}">Vehicle Delivery</a></li>
                      <li class="title" style="margin-top:8px;"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>External Workshops</li>
                      <li><a href="{{ route('ws.external.dispatch') }}">Dispatch to Workshop</a></li>
                      <li><a href="{{ route('ws.external.tracker') }}">Workshop Tracker</a></li>
                      <li><a href="{{ route('ws.external.billing') }}">Bill Reconciliation</a></li>
                      <li><a href="{{ route('ws.external.return') }}">Vehicle Return</a></li>
                    </ul>
                  </div>

                  {{-- Maintenance --}}
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Maintenance</li>
                      <li><a href="{{ route('ws.maintenance.pm-calendar') }}">PM Calendar</a></li>
                      <li><a href="{{ route('ws.alerts') }}">Service Alerts</a></li>
                      <li><a href="{{ route('ws.reports') }}">Workshop Reports</a></li>
                    </ul>
                  </div>

                </div>
              </div>
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link text-white {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.dashboard') }}"><img src="{{ asset('images/menu-icon/Production.png') }}">Inventory</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">

                  {{-- Stock --}}
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Stock Management</li>
                      <li><a href="{{ route('inventory.dashboard') }}">Inventory Dashboard</a></li>
                      <li><a href="{{ route('inventory.spare-parts') }}">Spare Parts</a></li>
                      <li><a href="{{ route('inventory.tyres') }}">Tyre Inventory</a></li>
                    </ul>
                    <ul style="margin-top:10px;">
                      <li class="title" style="font-size:11px;color:#7fb3f5;padding-bottom:4px;"><span class="icon" style="margin-right:4px;">🔋</span>Battery</li>
                      <li><a href="{{ route('inventory.battery-dashboard') }}">Battery Dashboard</a></li>
                      <li><a href="{{ route('inventory.batteries') }}">Battery Inventory</a></li>
                      <li><a href="{{ route('inventory.battery.add') }}">Add Battery</a></li>
                      @if(Route::has('contact.batteryvendor.index'))
                      <li><a href="{{ route('contact.batteryvendor.index') }}">Battery Vendors</a></li>
                      @endif
                    </ul>
                  </div>

                  {{-- Procurement --}}
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Procurement</li>
                      <li><a href="{{ route('inventory.purchase-orders') }}">Purchase Orders</a></li>
                      <li><a href="{{ route('inventory.goods-receipt') }}">Goods Receipt (GRN)</a></li>
                      <li><a href="{{ route('inventory.stock-transfer') }}">Stock Transfers</a></li>
                    </ul>
                  </div>

                  {{-- Billing (placeholder) --}}
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Billing & Payments</li>
                      <li><a href="#">Vendor Invoices</a></li>
                      <li><a href="#">Payment Records</a></li>
                      <li><a href="#">Consumption Logs</a></li>
                    </ul>
                  </div>

                </div>
              </div>
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link text-white" href="#"><img src="{{ asset('images/menu-icon/Production.png') }}">Finance</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Freight Billing</li>
                      <li><a href="#">Create Invoice</a></li>
                      <li><a href="#">Invoices</a></li>
                      <li><a href="#">Customer & Broker ledger</a></li>
                      <li><a href="#">Create Money Receipt </a></li>
                      <li><a href="#">Money Receipts</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Payments</li>
                      <li><a href="#">Driver Settlement</a></li>
                      <li><a href="#">Vendor Settlement</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Trip Expense Management</li>
                      <li><a href="#">Fuel Expenses</a></li>
                      <li><a href="#">Driver Allowances</a></li>
                      <li><a href="#">Repair Charges</a></li>
                      <li><a href="#">Advance Requests</a></li>
                      <li><a href="#">Reimbursements</a></li>
                    </ul>
                  </div>
                  
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/fleet-monitoring.png') }}"></span>Vendor &amp; Supplier</li>
                      <li><a href="{{ route('inventory.purchase-orders') }}">PO Approvals</a></li>
                      <li><a href="#">Vendor Invoices</a></li>
                      <li><a href="#">Vendor Payments</a></li>
                      <li><a href="#">Vendor Ledger</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </li>

        <li class="nav-item">
        <a class="nav-link text-white" href="#"><img src="{{ asset('images/menu-icon/Production.png') }}">Reports & Analytics</a>
        <div class="fleetmegamenu-wrapper">
              <div class="megamenu-bd">
                <div class="row">
                  <div class="col-lg-3 col-md-3 col-xs-12 link-list">
                    <ul>
                      <li class="title"><span class="icon"><img src="{{ asset('images/menu-icon/vehicle-details.png') }}"></span>Billing & Invoicing</li>
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
      <a class="navbar-brand mt-2 mt-lg-0 d-block d-lg-none" href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" width="78" height="46" alt="Logo" loading="lazy"/>
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
          <img src="{{ asset('images/menu-icon/notification.png') }}" alt="Notification" width="22" height="22">
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
          <img src="{{ asset('images/menu-icon/profile.png') }}" alt="Profile" width="22" height="22">
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