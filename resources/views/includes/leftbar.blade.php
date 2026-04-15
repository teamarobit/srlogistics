<div class="sidemenu">
    <h4 class="text-theme text-center sidebar-title">Master Data</h4>
    <div class="search-wrap mt-3">
        <i class="uil uil-search search-icon"></i>
        <input type="text" class="form-control ms-auto" id="sidebarSearch" placeholder="Search" autocomplete="off" />
    </div>

    <div class="accordion mt-3" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="uil uil-user me-2"></i> Contact</button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" >
                <div class="accordion-body">
                    @if(Route::has('contact.index'))
                        @if(allcotypes()->count())
                            @foreach(allcotypes() as $menucotype)
                                @php
                                    $name = $menucotype->name;

                                    if (preg_match('/^(.+)\s\((.+)\)$/', $name, $matches)) {
                                        $plural = str($matches[1])->plural() . ' (' . str($matches[2])->plural() . ')';
                                    } else {
                                        $plural = str($name)->plural();
                                    }
                                @endphp

                                <p style="background-color: #a2ffe0;"><a href="{{ route('contact.'.$menucotype->slug . '.index') }}" style="color: #261f35; font-size: 13px;">{{ $plural }}</a></p>

                            @endforeach
                        @endif
                    @endif

                    {{-- Spare Part Vendors are already included via allcotypes() loop above --}}
                </div>
            </div>
        </div>
        
        
        @if(Route::has('contact.customer.contract.list'))
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree" >
                <a class="accordion-button no-dd" href="{{ route('contact.customer.contract.list') }}" style="background-color: #a2ffe0;">
                <i class="uil uil-file-contract me-2"></i> Contract Master</a>
            </h2>
        </div>
        @endif
        
        <!--///////////////////////////-->
        @if(Route::has('department.index'))
        <div class="accordion-item" >
            <h2 class="accordion-header" id="headingThree" >
                <a class="accordion-button no-dd" href="{{ route('department.index') }}" style="background-color: #a2ffe0;"> 
                <i class="uil uil-car me-2"></i> Department</a>
            </h2>
        </div>
        @endif
        
        @if(Route::has('designation.index'))
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <a class="accordion-button no-dd" href="{{ route('designation.index') }}" style="background-color: #a2ffe0;">
                <i class="uil uil-briefcase me-2"></i> Designation </a>
            </h2>
        </div>
        @endif
        
        
        @if(Route::has('jobrank.index'))
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <a class="accordion-button no-dd" href="{{ route('jobrank.index') }}" style="background-color: #a2ffe0;">
                <i class="uil uil-briefcase me-2"></i> Job Rank </a>
            </h2>
        </div>
        @endif
        
        
        <!--///////////////////////////-->
        
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading11">
                <!-- <a class="accordion-button no-dd" href="vehicle-list.php"><i class="uil uil-car-sideview me-2"></i> Vehicle Master</a> -->
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                <i class="uil uil-truck me-2"></i> Vehicle Master
              </button>
            </h2>
            <div id="collapse11" class="accordion-collapse collapse show" aria-labelledby="heading11" >
                <div class="accordion-body">
                
                    @if(Route::has('vehiclemanagement.index'))
                    <p style="background-color: #a2ffe0;"><a href="{{ route('vehiclemanagement.index') }}" style="color:#261F35; font-size:13px;">Vehicle Management</a></p>
                    @endif
                    
                    @if(Route::has('vehicletype.index'))
                    <p style="background-color: #a2ffe0;"><a href="{{ route('vehicletype.index') }}" style="color:#261F35; font-size:13px;">Vehicle Type</a></p>
                    @endif
                    
                    @if(Route::has('vehiclegroup.index'))
                    <p style="background-color: #a2ffe0;"><a href="{{ route('vehiclegroup.index') }}" style="color:#261F35; font-size:13px;">Vehicle Group</a></p>
                    @endif
                    
                    @if(Route::has('vehiclestatus.index')) 
                    <p style="background-color: #a2ffe0;"><a href="{{ route('vehiclestatus.index') }}" style="color: #261f35; font-size: 13px;">Vehicle Status</a></p>
                    @endif
                    
                    @if(Route::has('vehicletracking.index'))
                    <p style="background-color: #a2ffe0;"><a href="{{ route('vehicletracking.index') }}" style="color: #261f35; font-size: 13px;">Vehicle Group Tracking Master</a></p>
                    @endif
                      
                    @if(Route::has('vehicleownership.index')) 
                    <p style="background-color: #a2ffe0;"><a href="{{ route('vehicleownership.index') }}" style="color: #261f35; font-size: 13px;">Ownership Type</a></p>
                    @endif
                
                </div>
            </div>
        </div>
        
        <div class="accordion-item">
            <h2 class="accordion-header" id="location">
                <!-- <a class="accordion-button no-dd" href="vehicle-list.php"><i class="uil uil-car-sideview me-2"></i> Vehicle Master</a> -->
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#locationcol" aria-expanded="false" aria-controls="locationcol">
                <i class="uil uil-map-marker me-2"></i> Locations
              </button>
            </h2>
            <div id="locationcol" class="accordion-collapse collapse show" aria-labelledby="location" >
              <div class="accordion-body">
                <!--<p><a href="location-list.php" style="color: #261F35; font-size: 13px;">Location List</a></p>-->
                
                @if(Route::has('route.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('route.index') }}" style="color:#261F35; font-size:13px;">Routes</a></p>
                @endif
                
                @if(Route::has('branch.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('branch.index') }}" style="color:#261F35; font-size:13px;">Branch</a></p>
                @endif
                
                @if(Route::has('locationpoint.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('locationpoint.index') }}" style="color:#261F35; font-size:13px;">Location Points</a></p>
                @endif
                
                
              </div>
            </div>
        </div>
        
        <div class="accordion-item">
            <h2 class="accordion-header" id="serviceH">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#serviceM" aria-expanded="false" aria-controls="serviceM">
                    <i class="uil uil-store me-2"></i> Workshop Master
                </button>
            </h2>

            <div id="serviceM" class="accordion-collapse collapse show" aria-labelledby="serviceH" >
                <div class="accordion-body">
                    @if(Route::has('ws.master.workshops'))
                    <p style="background-color: #a2ffe0;"><a href="{{ route('ws.master.workshops') }}" style="color: #261f35; font-size: 13px;">Workshops</a></p>
                    @endif

                    @if(Route::has('skillset.index'))
                    <p style="background-color: #a2ffe0;"><a href="{{ route('skillset.index') }}" style="color: #261f35; font-size: 13px;">Skill Set</a></p>
                    @endif

                    @if(Route::has('ws.master.services'))
                    <p><a href="{{ route('ws.master.services') }}" style="color: #261f35; font-size: 13px;">Services</a></p>
                    @endif

                    @if(Route::has('ws.master.service-key-points'))
                    <p><a href="{{ route('ws.master.service-key-points') }}" style="color: #261f35; font-size: 13px;">Service Key Points</a></p>
                    @endif

                    @if(Route::has('ws.master.spare-parts'))
                    <p><a href="{{ route('ws.master.spare-parts') }}" style="color: #261f35; font-size: 13px;">Spare Parts</a></p>
                    @endif

                    @if(Route::has('ws.master.spare-part-categories'))
                    <p><a href="{{ route('ws.master.spare-part-categories') }}" style="color: #261f35; font-size: 13px;">Spare Part Categories</a></p>
                    @endif

                    @if(Route::has('ws.master.maintenance-items'))
                    <p><a href="{{ route('ws.master.maintenance-items') }}" style="color: #261f35; font-size: 13px;">Maintenance Items</a></p>
                    @endif

                    @if(Route::has('ws.master.fault-codes'))
                    <p><a href="{{ route('ws.master.fault-codes') }}" style="color: #261f35; font-size: 13px;">Fault / Complaint Codes</a></p>
                    @endif
                </div>
            </div>
        </div>
        
        <!--<div class="accordion-item">-->
        <!--    <h2 class="accordion-header" id="rolesPermission">-->
        <!--        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#rolesPermission" aria-expanded="false" aria-controls="rolesPermission">-->
        <!--            <i class="uil uil-lock-access me-2"></i> Roles and Permission-->
        <!--        </button>-->
        <!--    </h2>-->
    
        <!--    <div id="serviceM" class="accordion-collapse collapse show" aria-labelledby="rolesPermission" >-->
        <!--        <div class="accordion-body">-->
        <!--            <p><a href="tracking-master.php" style="color: #261f35; font-size: 13px;">Vehicle Group Tracking Master</a></p>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        
        {{--
        <!--<div class="accordion-item">-->
        <!--    <h2 class="accordion-header" id="headingThree">-->
        <!--        <a class="accordion-button no-dd" href="{{ route('tyre.index') }}">-->
        <!--            <i class="uil uil-lock-access me-2"></i> Tyre Management-->
        <!--        </a>-->
        <!--    </h2>-->
        <!--</div>-->
        --}}
        
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <a class="accordion-button no-dd" href="grivance.php">
                    <i class="uil uil-lock-access me-2"></i> Roles and Permission
                </a>
            </h2>
        </div>
        
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <a class="accordion-button no-dd" href="grivance.php">
                    <i class="uil uil-user-exclamation me-2"></i> Grievance Master</a>
            </h2>
        </div>

        <!--<div class="accordion-item">-->
        <!--    <h2 class="accordion-header" id="heading5">-->
        <!--        <a class="accordion-button no-dd" href="maintenance-list.php"> <i class="uil uil-wrench me-2"></i> Maintenance Items</a>-->
        <!--    </h2>-->
        <!--</div>-->
    </div>
    
    <div class="accordion-item">
        <h2 class="accordion-header" id="financeH">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#financeM" aria-expanded="false" aria-controls="financeM">
                <i class="uil uil-usd-circle me-2"></i> Finance Master
            </button>
        </h2>

        <div id="financeM" class="accordion-collapse collapse show" aria-labelledby="financeH" >
            <div class="accordion-body">
                <p><a href="#" style="color: #261f35; font-size: 13px;">Account Groups</a></p>
                <p><a href="#" style="color: #261f35; font-size: 13px;">Account Heads</a></p>
                <!--<p><a href="#" style="color: #261f35; font-size: 13px;">Operational Overheads</a></p>-->
                
                @if(Route::has('expense.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('expense.index') }}" style="color: #261f35; font-size: 13px;">Expense Type Master</a></p>
                @endif
                
                
                <p><a href="voucher-master.php" style="color: #261f35; font-size: 13px;">Voucher Master</a></p>
                <p><a href="#" style="color: #261f35; font-size: 13px;">Chart of Accounts</a></p>
                
                @if(Route::has('asset.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('asset.index') }}" style="color: #261f35; font-size: 13px;">Asset Master</a></p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading12">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                <i class="uil uil-file-check-alt me-2"></i> Miscellaneous Master
            </button>
        </h2>

        <div id="collapse12" class="accordion-collapse collapse show" aria-labelledby="heading12" >
            <div class="accordion-body">
                
                <p><a href="document.php" style="color: #261f35; font-size: 13px;">Document</a></p>
                <p><a href="fuel-card.php" style="color: #261f35; font-size: 13px;">Fuel Card</a></p>
                
                <p><a href="fuel-station-list.php" style="color: #261f35; font-size: 13px;">Fuel Station</a></p>
                
                @if(Route::has('tollstation.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('tollstation.index') }}" style="color: #261f35; font-size: 13px;">Toll Station</a></p>
                @endif
                
                @if(Route::has('rto.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('rto.index') }}" style="color: #261f35; font-size: 13px;">RTO Checkpoint</a></p>
                @endif
                
                <p><a href="#" style="color: #261f35; font-size: 13px;">POD Master</a></p>
                
                
            </div>
        </div>
        
    </div>
    
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading14">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                <i class="uil uil-apps me-2"></i> Provider Master
            </button>
        </h2>

        <div id="collapse14" class="accordion-collapse collapse show" aria-labelledby="heading14" >
            <div class="accordion-body">
                
                @if(Route::has('gpsprovider.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('gpsprovider.index') }}" style="color: #261f35; font-size: 13px;">GPS Provider</a></p>
                @endif
                
                @if(Route::has('fasttagprovider.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('fasttagprovider.index') }}" style="color: #261f35; font-size: 13px;">Fastag Provider</a></p>
                @endif
                
                @if(Route::has('digilockprovider.index'))
                <p style="background-color: #a2ffe0;"><a href="{{ route('digilockprovider.index') }}" style="color: #261f35; font-size: 13px;">Digital Lock Provider</a></p>
                @endif
                
            </div>
        </div>
        
    </div>

</div>

<script>
/* ── Sidebar search (vanilla JS — runs before jQuery loads) ── */
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('sidebarSearch');
    if (!input) return;

    input.addEventListener('input', function () {
        var q = this.value.toLowerCase().trim();
        var accordion = document.getElementById('accordionExample');
        if (!accordion) return;

        var items = accordion.querySelectorAll('.accordion-item');

        if (!q) {
            items.forEach(function (item) {
                item.style.display = '';
                item.querySelectorAll('.accordion-body p').forEach(function (p) { p.style.display = ''; });
                var panel = item.querySelector('.accordion-collapse');
                if (panel) panel.classList.add('show');
                var btn = item.querySelector('.accordion-button');
                if (btn) { btn.classList.remove('collapsed'); btn.setAttribute('aria-expanded', 'true'); }
            });
            return;
        }

        items.forEach(function (item) {
            var links      = item.querySelectorAll('.accordion-body p');
            var headerEl   = item.querySelector('.accordion-header');
            var headerText = headerEl ? headerEl.textContent.toLowerCase() : '';
            var anyMatch   = false;

            links.forEach(function (p) {
                var match = p.textContent.toLowerCase().indexOf(q) !== -1;
                p.style.display = match ? '' : 'none';
                if (match) anyMatch = true;
            });

            /* if section header matches, show all its children */
            if (headerText.indexOf(q) !== -1) {
                links.forEach(function (p) { p.style.display = ''; });
                anyMatch = true;
            }

            item.style.display = anyMatch ? '' : 'none';

            if (anyMatch) {
                var panel = item.querySelector('.accordion-collapse');
                if (panel) panel.classList.add('show');
                var btn = item.querySelector('.accordion-button');
                if (btn) { btn.classList.remove('collapsed'); btn.setAttribute('aria-expanded', 'true'); }
            }
        });
    });
});
</script>









