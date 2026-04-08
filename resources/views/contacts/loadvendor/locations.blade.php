@if($locations->count())
    @foreach($locations as $index => $location)
        @php
            $headingId = "heading".$index;
            $collapseId = "collapse".$index;
        @endphp

        <div class="accordion-item">
            <h2 class="accordion-header" id="{{ $headingId }}">
              <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" 
                        type="button" data-bs-toggle="collapse" 
                        data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                    <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div>
                    <span style="font-size: 14px;">Location Name: {{ $location->location_name ?? '' }}</span> 
                    <span class="badge badge-success ms-2">{{ $location->location_type ?? '' }} Point</span></div>
                    <div class="d-flex align-items-center me-3">
                        <a href="javascript:void(0)" class="btn btn-success me-3 share-location" data-locationid="{{ $location->id }}"><i class="uil uil-whatsapp me-2"></i>Share</a>
                        <a href="javascript:void(0)" class="text-danger delete-location" data-locationid="{{ $location->id }}"><i class="uil uil-trash-alt me-2"></i></a>
                    </div>
                    </h6>
                </button>
            </h2>
            <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="{{ $headingId }}" data-bs-parent="#locationCollapse">
              <div class="accordion-body">
                    <div class="item-rowsec">
                        <div class="row form-group mb-0">
                            <div class="col-12 col-lg-5">
                                <div class="row form-group">
                                    <div class="col-12 col-lg-5 col-md-3">
                                        <label>Company Name:</label>
                                    </div>

                                   <div class="col-12 col-lg-7 col-md-9">
                                        <p>{{ $location->company_name ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <div class="row form-group">
                                    <div class="col-12 col-lg-5 col-md-3">
                                        <label>Company Role:</label>
                                    </div>

                                    <div class="col-12 col-lg-7 col-md-9">
                                        <p class="tag">{{ $location->company_role ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row form-group mb-0">
                            <div class="col-12 col-lg-5">
                                <div class="row form-group">
                                    <div class="col-12 col-lg-5 col-md-3">
                                        <label>Route Type:</label>
                                    </div>

                                    <div class="col-12 col-lg-7 col-md-9">
                                        <p>{{ $location->route_type ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <div class="row form-group">
                                    <div class="col-12 col-lg-5 col-md-3">
                                        <label>Source:</label>
                                    </div>

                                    <div class="col-12 col-lg-7 col-md-9">
                                        <p>{{ optional($location->sourceCity)->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row form-group mb-0">
                            <div class="col-12 col-lg-5">
                                <div class="row form-group">
                                    <div class="col-12 col-lg-5 col-md-3">
                                        <label>Address:</label>
                                    </div>

                                   <div class="col-12 col-lg-7 col-md-9">
                                        <p>{{ $location->address ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
                                <div class="row form-group">
                                    <div class="col-12 col-lg-5 col-md-3">
                                        <label>Postal Code:</label>
                                    </div>

                                    <div class="col-12 col-lg-7 col-md-9">
                                        <p>{{ $location->zipcode ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                        <div class="row form-group">
                            <div class="col-12 col-md-2">
                                <label>Onsite Contact Person:</label>
                            </div>

                            <div class="col-12 col-md-2">
                                <p>{{ $location->onsite_contact_person ?? '' }}</p>
                            </div>
                            
                            <div class="col-12 col-md-2">
                                <label>Onsite Contact Number:</label>
                            </div>

                            <div class="col-12 col-md-2">
                                <p>+{{ $location->onsite_contact_person_phone_code ?? '' }} {{ $location->onsite_contact_person_phone ?? '' }}</p>
                            </div>
                            <div class="col-12 col-md-2">
                                <label>Onsite WhatsApp Number:</label>
                            </div>

                            <div class="col-12 col-md-2">
                                <p>+{{ $location->onsite_contact_person_whatsapp_code ?? '' }} {{ $location->onsite_contact_person_whatsapp ?? '' }}</p>
                            </div>
                        </div>
                            
                        <div class="row form-group">
                            <div class="col-12 col-lg-2 col-md-3">
                                <label>Brone By:</label>
                            </div>

                            <div class="col-12 col-lg-10 col-md-9">
                                <p>{{ $location->charges_paid_by ?? '' }}</p>
                            </div>
                        </div>
                    
                        <div class="row form-group">
                            <div class="col-12 col-lg-2 col-md-3">
                                <label>Additional Info:</label>
                            </div>

                            <div class="col-12 col-lg-10 col-md-9">
                                <p>{{ $location->additional_info ?? '' }}</p>
                            </div>
                        </div>
                    
                        <div class="row form-group">
                            <div class="col-12 col-lg-2 col-md-3">
                                <label>Embeded Map:</label>
                            </div>

                            <div class="col-12 col-lg-10 col-md-9">
                                <a href="javascript:void(0)" style="font-size: 12px; line-height: 20px;">
                                    {{ $location->map_location ?? '' }}
                                </a>
                            </div>
                        </div>
                </div>
              </div>
            </div>
        </div>
    @endforeach
@else
    <div class="no-data">
        <p>No Data Found</p>
    </div>
@endif