@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/employee-management.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />

<style>
    p { margin: 0; font-size: 13px;  word-break: break-word; }
    
    .w-90 { width:90%; }
    
    /**/
    .btn.btn-primary.me-2 { background: #010649; }
    .btn.btn-theme.me-2 {    background: #ea0027;    color: #fff;
    border-radius: 4px; border: 0; }
    
    /**/   
    .item_016btn {  display: flex; align-items: center; justify-content: end; }
    
    /*.item_blacklisted {    margin: 0 10px 0 0;    padding: 11px 12px 5px 12px;    display: inline-block;    text-align: center;    background:#ea0027;*/
    /*box-shadow: 0px 0px 8px 0px rgb(143 143 143 / 50%);    border-radius: 4px;}*/
    /*.item_blacklisted p {    margin: 0;    padding: 0;    font-size: 20px;*/
    /*line-height: 14px;    color: #ffffff;    display: block;    border: 0; font-weight: bold; }*/
    /*.item_blacklisted span {    margin: 0;    padding: 3px 0 0 0;    font-size: 13px;    line-height: 21px;*/
    /*color: #fff;    display: block;    font-weight: 600; }*/
    
    .item_blacklisted {    margin: 0 10px 0 150px;    padding: 11px 12px 5px 12px;    display: inline-block;    text-align: center;
    background: #fff;    box-shadow: 0px 0px 8px 0px rgb(143 143 143 / 50%);    border-radius: 4px;    margin-right: auto;
    position: relative;    top:-43px; }
    
    .item_blacklisted p { margin: 0;padding: 0;font-size: 20px;line-height: 14px;color: #ea0027;display: block;border: 0;font-weight: bold;}
    .item_blacklisted span {    margin: 0;    padding: 3px 0 0 0;    font-size: 13px;    line-height: 21px;    color: #f9526e;    display: block;
    font-weight: 600; }
    
     /*.allshow { display: none; }*/
     
    /**/ 
    
     /**/
    .secactivit_blacklist {margin: 21px 0 0 0;padding: 16px 10px !important;border-radius: 6px;/* background: #fff !important; */width: 100%;}
    /*.secactivit_blacklist h4 {margin:0;padding:0;font-size: 20px;line-height: 28px;color: #ffffff;font-weight: bold;}*/
    /*.secactivit_blacklist .date_time {margin:0;padding: 4px 0 6px 0;font-size: 15px;line-height: 21px;color: #ffffff !important;display: block !important;}*/
    /*.secactivit_blacklist .sec_reason {margin:0;padding:0;font-size: 15px;line-height: 19px;color: #fff !important;}*/
    /**/
    
    .e-activitywrapper .bg-circlesec {    width: 30px;    height: 30px;    border-radius: 100%;    display: inline-flex;
    align-items: center;    justify-content: center;    color: #fff;    font-size: 10px;
    font-weight: 600;    padding: 0 !important; }
    .blacklist_color .c_red {    color: #ea0027 !important; }
    
    .accordion-item .tag {
        padding: 2px 6px;
        border-radius: 20px;
        background-color: #e9f0ff;
        border: 1px solid #032671;
        display: inline-block;
        margin-bottom: 5px;
        font-size: 12px;
        padding: 2px 8px;
        line-height: 21px;
    }
    
    .destination-wrap{
        display: none;
    }
    .source-wrap{
        display: none;
    }
    .midpoint-wrap{
        display: none;
    }
    .LoadingChargeDiv{
        display: none;
    }
    .UnloadingChargeDiv{
        display: none;
    }
    .CappingAmountDiv{
        display: none;
    }
    
    

/*dropzone*/
.dropzone {
    border: 2px dashed #dbdee0;
    padding: 20px;
    background: #fff;
    min-height: 120px;
}
/*dropzone*/


</style>

@endsection

@section('content')

<div class="layout-wrapper">
    @include('includes.header')
    
    <form class="wrapper srlog-bdwrapper" action="{{ Route::has('contact.'.str($cotype->slug)->lower().'.update')? 
                    route('contact.'.str($cotype->slug)->lower().'.update', $contact->id): '#' }}" id="editContactForm">   
                    
        @csrf
        
        <input type="hidden" name="contactid" id="edit_contactid_input" value="{{ $contact->id }}">

        <div class="itemtop-secwrap">
            <div class="container-fluid">
                <div class="item1-cbdhed">
                    <h5>Edit Load Vendor</h5>
                    
                    <div class="item1-cbdhed">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-4">
                                <div class="gst-wrapper">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                                                        
                                    <div>
                                        <input type="text" name="company_name" value="{{ $contact->company_name ?? '' }}" class="gstinput form-control" />
                                        <small class="error text-danger" id="edit_company_name_error"></small>
                                    </div>     
                                </div>
                            </div>

                            <div class="col-12 col-md-8 item_016btn"> 
                            
                                @if($contact->status === 'Blacklisted' && $contact->blacklisted_at)
                                <div class="item_blacklisted">
                                    <p>Blacklisted</p>
                                    <span>
                                        Blacklisted on - {{ \Carbon\Carbon::parse($contact->blacklisted_at)->format('d/m/y') }}
                                    </span>
                                </div>
                                @endif
                                
                                
                                
                                @if( Route::has('contact.'.str($cotype->slug)->lower().'.update') )
                                <a href="javascript:void(0)" class="btn btn-dark me-2" id="editContactBtn">Save</a>
                                @endif
                            
                                <a href="{{ route('contact.'.str($cotype->slug)->lower().'.index') }}" class="btn btn-danger me-2">Close</a>

                            </div>

                        </div>
                    </div>
                    

                </div>
            </div>
        </div>

        <div class="item2-cbdwrap">
            <div class="container-fluid">  
                <div class="row">

                    <div class="col-12 col-md-4">
                        <div class="mt-4">

                            <div class="form-bg">

                                <div class="row">

                                    <div class="col-12 col-md-6">
                                        <h6>About</h6>
                                    </div>

                                    <div class="col-12 col-md-6 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse01" aria-expanded="true" aria-controls="collapse01" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapse01">
                                    <div class="contact-wrap">                                           

                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Load Vendor Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" name="contact_name" value="{{ $contact->contact_name ?? '' }}"  class="form-control"/>
                                              <small class="error text-danger" id="edit_contact_name_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Load Vendor Code <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" name="contact_code" value="{{ $contact->contact_code ?? '' }}" class="form-control"/>
                                              <small class="error text-danger" id="edit_contact_code_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Alias </label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" name="contact_alias" value="{{ $contact->alias ?? '' }}" class="form-control"/>
                                              <small class="error text-danger" id="edit_contact_alias_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <div class="col-9 pe-0">
                                                        <input type="text" name="email" value="{{ $contact->email ?? '' }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_email_error"></small>
                                                    </div>
                                                    <div class="col-3">
                                                        <span class="badge bg-secondary"><i class="uil uil-envelope-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Phone <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <input type="hidden" name="phone_code" value="{{ $contact->ph_prefix ?? '' }}" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="phone" value="{{ $contact->phone ?? '' }}" class="form-control telinput "/>
                                                        <small class="error text-danger" id="edit_phone_error"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>WhatsApp</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <input type="hidden" name="whatsapp_code" value="{{ $contact->whatsapp_prefix ?? '' }}" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="whatsapp" value="{{ $contact->whatsapp ?? '' }}" class="form-control telinput " name="whatsapp" />
                                                        <small class="error text-danger" id="edit_whatsapp_error"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Size</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex">

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios1" value="Large" {{ $contact->size == 'Large' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Large
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios2" value="Medium" {{ $contact->size == 'Medium' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        Medium
                                                    </label>
                                                </div>

                                                <div class="form-check m">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios3" value="Small" {{ $contact->size == 'Small' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        Small
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <small class="error text-danger" id="edit_size_error"></small>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Status</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex">

                                                <div class="form-check">
                                                    <input class="form-check-input loadvendor-status" type="radio" name="status" id="active" value="Active" {{ $contact->status == 'Active' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="active">
                                                        Active
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input loadvendor-status" type="radio" name="status" id="inactive" value="Inactive" {{ $contact->status == 'Inactive' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="inactive">
                                                        Inactive
                                                    </label>
                                                </div>

                                                <div class="form-check m">
                                                    <input class="form-check-input loadvendor-status" type="radio" name="status" id="blacklist" value="Blacklisted" {{ $contact->status == 'Blacklisted' ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="blacklist">
                                                        Blacklist
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <small class="error text-danger" id="edit_status_error"></small>
                                        </div>
                                        
                                        <!--///////////////////////////////-->
                                        <div class="status-content statusblacklist" style="display: {{ $contact->blacklist_reason != '' ? 'block' : 'none' }};">
                                            <div class="row form-group">
                                              <div class="col-12 col-md-5">
                                                  <label>Blacklist Reason <span class="text-danger">*</span></label>
                                              </div>
                                              <div class="col-12 col-md-7">
                                                  <textarea class="form-control" name="blacklist_reason" rows="3" placeholder="">{{ $contact->blacklist_reason ?? '' }}</textarea>
                                                  <small class="error text-danger" id="edit_blacklist_reason_error"></small>
                                              </div>
                                            </div>
                                        </div>
                                        <!--///////////////////////////////-->
                                        
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>RAG Status</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex rag-status-wrap">
                                                <div class="form-check red-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="red" value="Red" {{ $contact->rag_status == 'Red' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="red">
                                                       Red  
                                                    </label>
                                                </div>

                                                <div class="form-check mx-1 yellow-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="yellow" value="Yellow" {{ $contact->rag_status == 'Yellow' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="yellow">
                                                        Yellow 
                                                    </label>
                                                </div>

                                                <div class="form-check green-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="green" value="Green" {{ $contact->rag_status == 'Green' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="green">
                                                        Green
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Comment </label>
                                            </div>
                                            <div class="col-12 col-md-7"> 
                                                <textarea class="form-control" name="contact_comment" id="contactComment" rows="3" placeholder="">{{ $contact->comment ?? '' }}</textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <!---->                                    
                                </div>
                            </div>

                            <div class="form-bg">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <h6>Contact Persons</h6>
                                    </div>
                                    <div class="col-12 col-md-6 text-end">
                                        <i data-bs-toggle="collapse" href="#collapse02" aria-expanded="true" aria-controls="collapse02" class="uil uil-angle-down"></i>
                                    </div>
                                </div>

                                <div class="collapse show" id="collapse02">
                                    <div class="contact-wrap">
                                        <div id="contactPersonContainer">
                                            
                                            @foreach($contact->relcontacts as $index => $relcontact)
                                            <div class="contact-person border p-3 mb-3 position-relative">
                                                
                                                @if( $index > 0)
                                                  <a href="javascript:void(0)" class="text-end text-secondary d-block mb-0 close-sec"><i class="uil uil-times-circle"></i></a>
                                                @endif
                                                <input type="hidden" name="contact_person_id[{{ $index }}]" value="{{ $relcontact->id }}">
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="contact_person_name[{{ $index }}]" value="{{ $relcontact->name }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_contact_person_name_{{ $index }}_error"></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Designation <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <input type="text" name="contact_person_designation[{{ $index }}]" value="{{ $relcontact->name }}" class="form-control" />
                                                        <small class="error text-danger" id="edit_contact_person_designation_{{ $index }}_error"></small>
                                                    </div>
                                                </div>
        
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Phone <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <input type="hidden" name="contact_person_ph_code[{{ $index }}]" class="phone_code">
                                                            <div class="col-12 col-md-12">
                                                                <input type="text" class="form-control telinput" name="contact_person_phone[{{ $index }}]" value="{{ $relcontact->phone }}" />
                                                                <small class="error text-danger" id="edit_contact_person_phone_{{ $index }}_error"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>WhatsApp</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <input type="hidden" name="contact_person_whatsapp_code[{{ $index }}]" class="phone_code">
                                                            <div class="col-12 col-md-12">
                                                                <input type="text" class="form-control telinput" name="contact_person_whatsapp[{{ $index }}]" value="{{ $relcontact->whatsapp }}" />
                                                                <small class="error text-danger" id="edit_contact_person_whatsapp_{{ $index }}_error"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Email</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <div class="row">
                                                            <div class="col-9 pe-0">
                                                                <input type="text" class="form-control" name="contact_person_email[{{ $index }}]" value="{{ $relcontact->email }}" />
                                                                <small class="error text-danger" id="edit_contact_person_email_{{ $index }}_error"></small>
                                                            </div>
                                                            <div class="col-3">
                                                                <span class="badge bg-secondary"><i class="uil uil-envelope-alt"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                                
                                                <div class="row form-group">
                                                    <div class="col-12 col-md-5">
                                                        <label>Comment</label>
                                                    </div>
                                                    <div class="col-12 col-md-7">
                                                        <textarea name="contact_person_comment[{{ $index }}]" class="form-control" rows="3" placeholder="">{{ $relcontact->comment }}</textarea>
                                                        <small class="error text-danger" id="edit_contact_person_comment_{{ $index }}_error"></small>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            @endforeach
    
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <a href="javascript:void(0)" class="btn btn-theme add-person"><i class="uil uil-plus me-1"></i>Contact Person</a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-12 col-md-8 mt-4">
                        <div class="right-side-wrap">
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab">
                                        Customers 
                                    </button>
                                </li> 
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab">
                                        Document
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#locations" type="button" role="tab">
                                        Locations
                                    </button>
                                </li>
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                        Activity
                                    </button>
                                </li>
                                
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                
                                
                                <div class="tab-pane fade" id="customer" role="tabpanel">
                                    <div class="accordion" id="customerCollapse">
                                          <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div><span style="font-size: 15px;">Vijay Verma </span></div>
                                                </h6>
                                              </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#customerCollapse">
                                                <div class="accordion-body">
                                                    <h6><strong>Route: Delhi - Varanasi - Prayagraj (Allahabad) - Allahabad - West Bengal</strong></h6>
                                                    <div class="table-responsive mt-3 pb-5">
                                                        <table class="table table-hover invoice-table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 150px;">
                                                                        Loading Point
                                                                    </th>
                                                                    <th style="min-width: 150px;">Unloading Point</th>
                                                                    <th>Vehicle Size</th>
                                                                    <th>Previous Freight</th>
                                                                    <th>Labour Charge</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        Malviya Nagar <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="{{ asset('images/icons/pin.png') }}" alt="Map Location"></a>
                                                                    </td>
                                                                    <td>Indiranagar <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="{{ asset('images/icons/pin.png') }}" alt="Map Location"></a></td>
                                                                    <td>
                                                                        <span class="tag">16 FT 15M * 11M * XXM 16M</span>
                                                                        <a class="vehicle-detail-btn" data-id="2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#moreSize">More</a>
                                                                    </td>
                                                                    <td>
                                                                        ₹66.00
                                                                    </td>
                                                                    <td>₹1,471.00</td>
                                                                    <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#historyModal">History</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <h6><strong>Route: Faridabad - Nainital</strong></h6>
                                                    <div class="table-responsive mt-3 pb-5">
                                                        <table class="table table-hover invoice-table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th style="min-width: 150px;">
                                                                        Loading Point
                                                                    </th>
                                                                    <th style="min-width: 150px;">Unloading Point</th>
                                                                    <th>Vehicle Size</th>
                                                                    <th>Previous Freight</th>
                                                                    <th>Labour Charge</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        Malviya Nagar <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="{{ asset('images/icons/pin.png') }}" alt="Map Location"></a>
                                                                    </td>
                                                                    <td>Indiranagar <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="{{ asset('images/icons/pin.png') }}" alt="Map Location"></a></td>
                                                                    <td>
                                                                        <span class="tag">16 FT 15M * 11M * XXM 16M</span>
                                                                        <a class="vehicle-detail-btn" data-id="2" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#moreSize">More</a>
                                                                    </td>
                                                                    <td>
                                                                        ₹66.00
                                                                    </td>
                                                                    <td>₹1,471.00</td>
                                                                    <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#historyModal">History</a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                </div>
                                
                                
                                <div class="tab-pane fade show active" id="document" role="tabpanel">
                                    <div class="employee-dwrapper">
                                        <div class="form-section">
                                            <!-- First Item Row -->

                                            <div class="item-row">
                                                <div class="row form-group align-items-center">
                                                    <div class="col-12 col-md-2">
                                                        <label>Document Type: <!--<span class="text-danger">*</span>--></label>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <select class="form-select select2 atypin" name="coattachtypes[]" id="coattachtypes_0">
                                                            <option value="">Select ID</option>
                                                            @if( $coattachtypes->count())
                                                                @foreach( $coattachtypes as $type)
                                                                   <option value="{{$type->id}}">{{$type->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <small class="error text-danger atyperr" id="edit_coattachtype_0_error"></small>
                                                    </div>
                                                </div>

                                                <hr />
                                                
                                                <!--dropzone-->
                                                <div class="dropzone" id="dropzone0">
                                                    <div class="dz-message needsclick">
                                                        <i class="uil uil-upload me-2"></i>
                                                        Drop files here or click to upload (Max 2 files)
                                                    </div>
                                                </div>
                                                <small class="error text-danger atterr" id="edit_coattachments_0_error"></small>

                                                
                                                <div class="d-flex justify-content-between mt-2">
                                                    <button type="button" class="add-item btn btn-success btn-sm" id="add_attachment_btn"><i class="uil uil-plus"></i> Add New</button>
                                                </div>
                                                
                                                
                                            </div>
                                            <div id="uploadContainer"></div>
                                            
                                            @foreach($coattachtypes->whereIn('id',$contact->coattachments->pluck('coattachtype.id')->toArray()) as $coattachtype)
                                                <div class="row mt-4  attachment-container">
                                                      <div class="col-12">
                                                          <h6>{{$coattachtype->name}}</h6>
                                                      </div>
                                                      @foreach($contact->coattachments->where('coattachtype.id',$coattachtype->id) as $coattachment)

                                                            @php
                                                                $fileUrl = asset('media/contact/'.$coattachment->name);
                                                                $extension = strtolower(pathinfo($coattachment->name, PATHINFO_EXTENSION));

                                                                $imageExtensions = ['jpg','jpeg','png','gif','webp','bmp'];
                                                            @endphp
                                                           <div class="col-12 col-md-4 attachment-box">
                                                              <div class="preview-img d-block w-100">
                                                                  <div class="d-flex justify-content-between">
                                                                      <div>
                                                                            <a href="{{ $fileUrl }}" download="{{ $coattachment->original_name }}">
                                
                                                                                @if(in_array($extension, $imageExtensions))
                                                                                    <!-- Image Preview -->
                                                                                    <img src="{{ $fileUrl }}" class="me-3" width="60">

                                                                                @elseif($extension == 'pdf')
                                                                                    <i class="uil-file-alt me-3" style="font-size:40px;"></i>

                                                                                @elseif(in_array($extension, ['doc','docx']))
                                                                                    <i class="uil-file-word me-3" style="font-size:40px;"></i>

                                                                                @elseif(in_array($extension, ['xls','xlsx']))
                                                                                    <i class="uil-file-exclamation-alt me-3" style="font-size:40px;"></i>

                                                                                @elseif(in_array($extension, ['zip','rar']))
                                                                                    <i class="uil-file-archive me-3" style="font-size:40px;"></i>

                                                                                @else
                                                                                    <i class="uil-file me-3" style="font-size:40px;"></i>
                                                                                @endif

                                                                            </a>
                                                                          <div style="font-size: 14px;">
                                                                              <a href="{{ $fileUrl }}" download="{{ $coattachment->original_name }}">
                                                                                <p class="mb-0 file-name">{{ $coattachment->original_name }}</p>
                                                                              </a>
                                                                              <p class="mb-0">Size: <span class="text-secondary">{{round((float)$coattachment->file_size,2)}} MB</span></p>
                                                                          </div>
                                                                      </div>
                                                                      <div class="float-end">
                                                                        <i class="uil-pen text-success edit-attachment-btn" data-id="{{ $coattachment->id }}" style="cursor:pointer;"></i>
                                                                        <i class="uil-trash-alt text-danger delete-attachment-btn" data-url="{{ route('contact.deleteattachment', $coattachment->id) }}" style="cursor:pointer;"></i>
                                                                      </div>
                                                                  </div>
                                                                  <small class="text-secondary d-block mt-2">Attached by <span class="text-theme">{{$coattachment->createdby?->name}}</span> on {{$coattachment->created_at->format('d/m/y [h:i A]')}}</small>
                                                              </div>
                                                          </div>
                                                      @endforeach
                                                </div>
                                            @endforeach

                                            <!-- Add New -->
                                        </div>
                                        <!---->
                                    </div>
                                </div>
                                

                                <div class="tab-pane fade" id="locations" role="tabpanel">

                                    <div class="row mb-3 align-items-center">
                                        <div class="col-12 col-md-12">
                                            <!--<h5 class="d-inline-block">Location</h5>-->
                                            <a href="javascript:void(0)" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#addLocation"><i class="uil uil-plus me-1"></i>Location</a>
                                            <div class="form-group d-inline-block mb-0 ms-2" style="width: 250px;">
                                                <select name="loadvendor_location_type" id="loadvendor_location_type" class="form-select select2">
                                                    <option value="">Filter by Location Type</option>
                                                    <option value="Loading">Loading Points</option>
                                                    <option value="Unloading">Unloading Points</option>
                                                    <option value="Both">Loading & Unloading Points</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary reset-btn ms-2"><i class="uil uil-history me-1"></i>Reset</button>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion" id="locationCollapse">
                                        @include('contacts.loadvendor.locations', ['locations' => $contact->loadvendorlocations])
                                    </div>
                                    
                                </div>

                                
                                <div class="tab-pane fade" id="activity" role="tabpanel">

                                    <div class="e-activitywrapper">

                                        <div class="note-wrap">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea name="activity_notes" id="activity_notes" class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                                <small class="error text-danger" id="err_activity_notes"></small>
                                            </div>
                                            <div class="text-end">
                                                <button id="activityBtn" class="btn btn-primary">Submit <i class="uil uil-message ms-1"></i></button>
                                            </div>
                                        </div>

                                        <div class="cmnt-wrap mt-4">
                                            @forelse($contact->activities as $activity)
                                        
                                                <div class="d-flex {{ ($activity->is_blacklisted === 'Yes') ? 'blacklist_color' : '' }}">
                                                    <span class="avatar {{ ($activity->is_blacklisted === 'Yes') ? 'bg-circlesec btn-danger' : 'bg-avatar-primary' }} me-3">
                                                        {{ strtoupper(substr(optional($activity->createdBy)->name, 0, 1)) }}
                                                    </span>
                                        
                                                    <div class="w-90">
                                                        <h6 class="mb-0 {{ ($activity->is_blacklisted === 'Yes') ? 'c_red' : '' }}">
                                                            {{ optional($activity->createdBy)->name ?? 'User' }}
                                                        </h6>
                                        
                                                        <small class="d-block text-secondary {{ ($activity->is_blacklisted === 'Yes') ? 'c_red' : '' }}">
                                                            {{ $activity->created_at->format('d M | h:i A') }}
                                                        </small>
                                        
                                                        <p class="text-secondary mb-2 {{ ($activity->is_blacklisted === 'Yes') ? 'c_red' : '' }}">
                                                            {{ $activity->notes }}
                                                        </p>
                                                    </div>
                                                </div>
                                        
                                            @empty
                                                <p class="text-muted">No activities found.</p>
                                            @endforelse

                                        </div>
                                    </div>

                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </form>
            
</div>




<!-- Modal -->
<div class="modal fade" id="addLocation" tabindex="-1" aria-labelledby="addLocationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationLabel">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{route('contact.loadvendor.location.save')}}" id="addLoadvendorLocationForm">
                    @csrf
                    <input type="hidden" name="contact_id" value="{{ $contact->id ?? '' }}" />
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" />
                            <small class="error text-danger" id="add_company_name_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Company Role <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="company_role" id="company_role_consignor" value="Consignor">
                              <label class="form-check-label" for="company_role_consignor"><i class="uil uil-check-circle me-1"></i>Consignor</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="company_role" id="company_role_consignee" value="Consignee">
                              <label class="form-check-label" for="company_role_consignee"><i class="uil uil-check-circle me-1"></i>Consignee</label>
                            </div>    
                            <small class="error text-danger" id="add_company_role_error"></small>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Route Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="route_type" id="source" value="source">
                              <label class="form-check-label if-source" for="source"><i class="uil uil-check-circle me-1"></i>Source</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="route_type" id="destination" value="destination">
                              <label class="form-check-label if-destination" for="destination"><i class="uil uil-check-circle me-1"></i>Destination</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="route_type" id="midpoint" value="midpoint">
                              <label class="form-check-label if-midpoint" for="midpoint"><i class="uil uil-check-circle me-1"></i>Midpoint</label>
                            </div>
                            <small class="error text-danger" id="add_route_type_error"></small>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group source-wrap">
                            <label>Source</label>
                            <select name="source_city_id" id="source_city_id" class="form-select select2">
                                <option value="">Choose source city</option>
                                @foreach ($routeSourceCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_source_city_id_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group destination-wrap">
                            <label>Destination</label>
                            <select name="destination_city_id" id="destination_city_id" class="form-select select2">
                                <option value="">Choose destination city</option>
                                @foreach ($routeDestCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_destination_city_id_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group midpoint-wrap">
                            <label>Midpoint</label>
                            <select name="midpoint_city_id" id="midpoint_city_id" class="form-select select2">
                                <option value="">Choose midpoint</option>
                                @foreach ($routeMidpointCities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <small class="error text-danger" id="add_midpoint_city_id_error"></small>
                        </div>
                        
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Location Name <span class="text-danger">*</span></label>
                            <input type="text" name="location_name" class="form-control" />
                            <small class="error text-danger" id="add_location_name_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" />
                            <small class="error text-danger" id="add_address_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Postal Code <span class="text-danger">*</span></label>
                            <input type="text" name="post_code" class="form-control" />
                            <small class="error text-danger" id="add_post_code_error"></small>
                        </div>
                        
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Location Type <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="location_type" id="loading" value="Loading">
                              <label class="form-check-label" for="loading"><i class="uil uil-check-circle me-1"></i>Loading</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="location_type" id="unloading" value="Unloading">
                              <label class="form-check-label" for="unloading"><i class="uil uil-check-circle me-1"></i>Unloading</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip LocationTypeBoth">
                              <input class="form-check-input" type="radio" name="location_type" id="both" value="Both">
                              <label class="form-check-label" for="both"><i class="uil uil-check-circle me-1"></i>Loading & Unloading</label>
                            </div>
                            <small class="error text-danger" id="add_location_type_error"></small>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-6 form-group LoadingChargeDiv" style="display:none;">
                                <label>Loading Charge</label>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="loading_charge_type" id="loading_charge_fixed" value="Fixed">
                                  <label class="form-check-label" for="loading_charge_fixed"><i class="uil uil-check-circle me-1"></i>Fixed</label>
                                </div>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="loading_charge_type" id="loading_charge_variable" value="Variable">
                                  <label class="form-check-label" for="loading_charge_variable"><i class="uil uil-check-circle me-1"></i>Variable</label>
                                </div>
                                <small class="error text-danger" id="add_loading_charge_type_error"></small>
                                
                                <div class="input-group mb-3">
                                  <span class="input-group-text bg-light text-dark">₹</span>
                                  <input type="text" name="loading_charge" class="form-control locationLoadingCharge" style="min-height: 30px !important; height: 20px;"/>
                                </div>
                                <small class="error text-danger" id="add_loading_charge_error"></small>
                            </div>
                            <div class="col-12 col-md-6 form-group UnloadingChargeDiv" style="display:none;">
                                <label>Unloading Charge</label>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="unloading_charge_type" id="fixed" value="Fixed">
                                  <label class="form-check-label" for="fixed"><i class="uil uil-check-circle me-1"></i>Fixed</label>
                                </div>
                                <div class="form-check form-check-inline radio-chip">
                                  <input class="form-check-input" type="radio" name="unloading_charge_type" id="variable" value="Variable">
                                  <label class="form-check-label" for="variable"><i class="uil uil-check-circle me-1"></i>Variable</label>
                                </div>
                                <small class="error text-danger" id="add_unloading_charge_type_error"></small>
                                <small class="error text-danger" id="add_loading_charge_type_error"></small>
                                
                                <div class="input-group mb-3">
                                  <span class="input-group-text bg-light text-dark">₹</span>
                                  <input type="text" name="unloading_charge" class="form-control locationUnloadingCharge" style="min-height: 30px !important; height: 20px;"/>
                                </div>
                                <small class="error text-danger" id="add_unloading_charge_error"></small>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6 form-group">
                            <label>Charges Paid By</label>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="brone_by" id="brone_by_customer" value="loadvendor">
                              <label class="form-check-label" for="brone_by_customer"><i class="uil uil-check-circle me-1"></i>Load Vendor</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="brone_by" id="brone_by_srl" value="srl">
                              <label class="form-check-label" for="brone_by_srl"><i class="uil uil-check-circle me-1"></i>SRL</label>
                            </div>
                            <div class="form-check form-check-inline radio-chip">
                              <input class="form-check-input" type="radio" name="brone_by" id="brone_by_mixed" value="mixed">
                              <label class="form-check-label" for="brone_by_mixed"><i class="uil uil-check-circle me-1"></i>Mixed</label>
                            </div>
                            
                            <div class="mb-3 CappingAmountDiv" style="display:none;">
                              <label>Capping Amount</label>
                              <div class="input-group">
                                <span class="input-group-text bg-light text-dark">₹</span>
                                <input type="text" name="capping_amount" class="form-control locationCappingAmount" placeholder="Capping amount" style="min-height: 30px !important; height: 20px;"/>
                              </div>
                              <small class="error text-danger" id="add_capping_amount_error"></small>
                            </div>
                            <small class="error text-danger" id="add_brone_by_error"></small>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Onsite Contact Person</label>
                            <input type="text" name="onsite_contact_person" class="form-control"/>
                            <small class="error text-danger" id="add_onsite_contact_person_error"></small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label>Onsite Contact Number</label>
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="onsite_contact_person_phone_code" class="phone_code"> 
                                    <input type="text" name="onsite_contact_person_phone" class="form-control telinput"/>
                                    <small class="error text-danger" id="add_onsite_contact_person_phone_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label>Onsite Whatsapp Number</label>
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="onsite_contact_person_whatsapp_code" class="phone_code"> 
                                    <input type="text" name="onsite_contact_person_whatsapp" class="form-control telinput"/>
                                    <small class="error text-danger" id="add_onsite_contact_person_whatsapp_error"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 form-group">
                            <label>Map Location <span class="text-danger">*</span></label>
                            <textarea name="map_location" class="form-control" rows="2"></textarea>
                            <small class="error text-danger" id="add_map_location_error"></small>
                        </div>
                        <div class="col-12 form-group">                                
                            <label>Additional Info</label>
                            <textarea name="additional_info" class="form-control" rows="2"></textarea>
                            <small class="error text-danger" id="add_additional_Info_error"></small>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="button" id="addLoadvendorLocationBtn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 


<div class="modal fade" id="editAttachmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title">Edit Attachment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editAttachmentForm" action="{{ route('contact.updateattachment') }}">
                @csrf
                <div class="modal-body">

                    <input type="hidden" id="attachment_id" name="attachment_id">

                    <div class="mb-3">
                        <label class="form-label">Upload File <span class="text-danger">*</span></label>
                        <input type="file" name="attachment_file" class="form-control">
                        <small class="error text-danger atyperr" id="edit_attachment_file_error"></small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button id="editAttachmentBtn" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>






<!-- HTML Modal -->
<div class="modal fade" id="moreSize" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Vehicle Freight</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
          </div>
          <div class="modal-body">
              <div class="table-responsive">
                  <table class="table w-100">
                      <thead>
                          <tr>
                              <th>Vehicle Size</th>
                              <th class="text-end">Current Freight</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>6 FT 5M * 6M * M 16M</td>
                              <td class="text-end">₹166.00</td>
                          </tr>
                      </tbody>

                  </table>
              </div>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            
            <div id="pricingHistoryBody">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Customer
                        <span style="font-size: 14px;"><span class="textbold pe-4"><b>Vijay Verma</b></span></span>
                        <strong>Route: Delhi - Varanasi - Prayagraj (Allahabad) - Allahabad - West Bengal </strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-times"></i></button>
                </div>
    
                <div class="modal-body">
                
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="6">
                                        <span style="font-size: 14px;"><strong>Updated By:</strong> Parna </span>
                                        <span style="font-size: 14px;" class="ms-5"><strong>Updated On:</strong> 21/02/2026 05:16 </span>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Loading Point</th>
                                    <th>Unloading Point</th>
                                    <th>No. of Vehicle</th>
                                    <th>Vehicle Size</th>
                                    <th>Previous Freight (₹)</th>
                                    <th>Labour Charge</th>
                                </tr>
                            </thead>
                            <tbody>
                    
                            <tr>
                                <td>Malviya Nagar  <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="images/icons/pin.png" alt="Map Location"></a></td>
                                <td>Indiranagar <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="images/icons/pin.png" alt="Map Location"></a></td>
                                <td>4</td>
                                <td>
                                    <span class="tag">
                                        16 FT 
                                        15M *
                                        11M *
                                        XXM 16M
                                    </span>
                                </td>
                                <td>₹66.00</td>
                                <td>₹660.00</td>
                            </tr>
                        
                            <tr>
                                <td>Malviya Naga <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="images/icons/pin.png" alt="Map Location"></a>r</td>
                                <td>Indiranagar <a class="text-danger" href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank"><img src="images/icons/pin.png" alt="Map Location"></a></td>
                                <td>2</td>
                                <td>
                                    <span class="tag">
                                        20 FT 
                                        15M *
                                        12M *
                                        XXL 20
                                    </span>
                                </td>
                                <td>₹55.00</td>
                                <td>₹155.00</td>
                            </tr>
                        
                            </tbody>
                        </table>
                    </div>
            </div>
            </div>
        </div>
    </div>
</div>




@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var CONTACTPERSON_WRAPPER = "{{ route('contact.' . $cotype->slug . '.contactpersonwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    
    var ACTIVITY_NOTE_URL = "{{ route('contact.activitynotes.save') }}";
    
    var FETCH_MIDPOINTS_URL = "{{ route('contact.' . $cotype->slug . '.get.location.midpoints', ':id') }}";
    var DELETE_LOCATION_URL = "{{ route('contact.' . $cotype->slug . '.location.delete') }}";
    var FILTER_LOCATION_URL = "{{ route('contact.' . $cotype->slug . '.filter.locations', ':id') }}";
    
    
    window.UPLOAD_URL = "{{ route('contact.upload.images') }}";
    
    //console.log("UPLOAD_URL:", window.UPLOAD_URL); 
    
    $(document).ready(function(){
        
        $('.table .form-control').each(function(index, value) {
            if($(this).val().length){
                $(this).addClass('has-val');
            }
        });
        
        $('.select2').select2();
        
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

<script type="text/javascript" src="{{ asset('customjs/contact/' . $cotype->slug . '/edit.js') }}"></script>

<script type="text/javascript" src="{{ asset('customjs/contact/activity.js') }}"></script>

@endsection
