@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('public/css/employee-management.css') }}">
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
    
    <form class="wrapper srlog-bdwrapper" action="{{route('contact.'.str($cotype->slug)->lower().'.save')}}" id="addContactForm">   
        @csrf

        <div class="itemtop-secwrap">
            <div class="container-fluid">
                <div class="item1-cbdhed">
                    <h5>Add Load Vendor</h5>
                    
                    <div class="item1-cbdhed">
                        <div class="row align-items-end">
                            <div class="col-12 col-md-4">
                                <div class="gst-wrapper">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                                                        
                                    <div>
                                        <input type="text" name="company_name" placeholder="" class="gstinput form-control" />
                                        <small class="error text-danger" id="add_company_name_error"></small>
                                    </div>     
                                </div>
                            </div>

                            <div class="col-12 col-md-8 item_016btn">
                                
                                <!--<div class="item_blacklisted">
                                    <p>Blacklisted</p>
                                    <span>Blacklisted on - 12/03/25</span>
                                </div>-->
                                
                                
                                <a href="javascript:void(0)" class="btn btn-dark me-2" id="addContactBtn">Save</a>
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
                                              <input type="text" name="contact_name" class="form-control"/>
                                              <small class="error text-danger" id="add_contact_name_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Load Vendor Code <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" name="contact_code" class="form-control"/>
                                              <small class="error text-danger" id="add_contact_code_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group mb-3">
                                            <div class="col-12 col-md-5">
                                              <label>Alias </label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                              <input type="text" name="contact_alias" class="form-control"/>
                                              <small class="error text-danger" id="add_contact_alias_error"></small>
                                            </div>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <div class="row">
                                                    <div class="col-9 pe-0">
                                                        <input type="text" name="email" class="form-control" />
                                                        <small class="error text-danger" id="add_email_error"></small>
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
                                                    <input type="hidden" name="phone_code" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="phone" class="form-control telinput "/>
                                                        <small class="error text-danger" id="add_phone_error"></small>
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
                                                    <input type="hidden" name="whatsapp_code" class="phone_code"> 
                                                    <div class="col-12 col-md-12">
                                                        <input type="text" name="whatsapp" class="form-control telinput " name="whatsapp" />
                                                        <small class="error text-danger" id="add_whatsapp_error"></small>
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
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios1" value="Large" />
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Large
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios2" value="Medium" />
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        Medium
                                                    </label>
                                                </div>

                                                <div class="form-check m">
                                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios3" value="Small" />
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        Small
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            <small class="error text-danger" id="add_size_error"></small>
                                        </div>
                                        
                                        <div class="row form-group">
                                            <div class="col-12 col-md-5">
                                                <label>Status</label>
                                            </div>

                                            <div class="col-12 col-md-7 d-flex">

                                                <div class="form-check">
                                                    <input class="form-check-input loadvendor-status" type="radio" name="status" id="active" value="Active" />
                                                    <label class="form-check-label" for="active">
                                                        Active
                                                    </label>
                                                </div>

                                                <div class="form-check mx-2">
                                                    <input class="form-check-input loadvendor-status" type="radio" name="status" id="inactive" value="Inactive" />
                                                    <label class="form-check-label" for="inactive">
                                                        Inactive
                                                    </label>
                                                </div>

                                                <!--<div class="form-check m">
                                                    <input class="form-check-input loadvendor-status" type="radio" name="status" id="blacklist" value="Blacklisted" />
                                                    <label class="form-check-label" for="blacklist">
                                                        Blacklist
                                                    </label>
                                                </div>-->
                                                
                                            </div>
                                            <small class="error text-danger" id="add_status_error"></small>
                                        </div>
                                        
                                        <!--///////////////////////////////-->
                                        <div class="status-content statusblacklist" style="display:none;">
                                            <div class="row form-group">
                                              <div class="col-12 col-md-5">
                                                  <label>Blacklist Reason <span class="text-danger">*</span></label>
                                              </div>
                                              <div class="col-12 col-md-7">
                                                  <textarea class="form-control" name="blacklist_reason" rows="3" placeholder=""></textarea>
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
                                                    <input class="form-check-input" type="radio" name="rag_status" id="red" value="Red">
                                                    <label class="form-check-label" for="red">
                                                       Red  
                                                    </label>
                                                </div>

                                                <div class="form-check mx-1 yellow-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="yellow" value="Yellow">
                                                    <label class="form-check-label" for="yellow">
                                                        Yellow 
                                                    </label>
                                                </div>

                                                <div class="form-check green-wrap">
                                                    <input class="form-check-input" type="radio" name="rag_status" id="green" value="Green">
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
                                                <textarea class="form-control" name="contact_comment" id="contactComment" rows="3" placeholder=""></textarea>
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
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="contact_person_name[]" class="form-control" />
                                                    <small class="error text-danger" id="add_contact_person_name_0_error"></small>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Designation <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" name="contact_person_designation[]" class="form-control" />
                                                    <small class="error text-danger" id="add_contact_person_designation_0_error"></small>
                                                </div>
                                            </div>
    
                                            <div class="row form-group">
                                                <div class="col-12 col-md-5">
                                                    <label>Phone <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <div class="row">
                                                        <input type="hidden" name="contact_person_ph_code[]" class="phone_code">
                                                        <div class="col-12 col-md-12">
                                                            <input type="text" class="form-control telinput" name="contact_person_phone[]" />
                                                            <small class="error text-danger" id="add_contact_person_phone_0_error"></small>
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
                                                        <input type="hidden" name="contact_person_whatsapp_code[]" class="phone_code">
                                                        <div class="col-12 col-md-12">
                                                            <input type="text" class="form-control telinput" name="contact_person_whatsapp[]" />
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
                                                            <input type="text" class="form-control" name="contact_person_email[]" />
                                                            <small class="error text-danger" id="add_contact_person_email_0_error"></small>
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
                                                    <textarea name="contact_person_comment[]" class="form-control" rows="3" placeholder=""></textarea>
                                                </div>
                                            </div>
    
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
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#customer" type="button" role="tab">
                                        Customers 
                                    </button>
                                </li> 
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#document" type="button" role="tab">
                                        Document
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#locations" type="button" role="tab">
                                        Locations
                                    </button>
                                </li>
                                
                                
                                
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                        Activity
                                    </button>
                                </li>
                                
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                
                                
                                <div class="tab-pane fade" id="customer" role="tabpanel">
                                    <div class="table-responsive mt-3 pb-5">
                                        <table class="table table-hover invoice-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 150px;">
                                                        Customer Name
                                                    </th>
                                                    <th>Source</th>
                                                    <th>Loading Location</th>
                                                    <th>Destination</th>
                                                    <th>Unloading Location </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        DFM Foods LTD
                                                    </td>
                                                    <td>Delhi</td>
                                                    <td>
                                                        <a href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank">https://maps.app.goo.gl/JfwW6FKYwvC33CZC6</a>
                                                    </td>
                                                    <td>
                                                        Pune
                                                    </td>
                                                    <td><a href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank">https://maps.app.goo.gl/JfwW6FKYwvC33CZC6</a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        IP Integrated Services PVT LTD
                                                    </td>
                                                    <td>Hyderabad</td>
                                                    <td>
                                                        <a href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank">https://maps.app.goo.gl/JfwW6FKYwvC33CZC6</a>
                                                    </td>
                                                    <td>
                                                        Bangalore
                                                    </td>
                                                    <td><a href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank">https://maps.app.goo.gl/JfwW6FKYwvC33CZC6</a></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>
                                                        Samsung
                                                    </td>
                                                    <td>Kolkata</td>
                                                    <td>
                                                        <a href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank">https://maps.app.goo.gl/JfwW6FKYwvC33CZC6</a>
                                                    </td>
                                                    <td>
                                                        Durgapur
                                                    </td>
                                                    <td><a href="https://maps.app.goo.gl/JfwW6FKYwvC33CZC6" target="_blank">https://maps.app.goo.gl/JfwW6FKYwvC33CZC6</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                                                        <small class="error text-danger atyperr" id="add_coattachtype_0_error"></small>
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
                                                <small class="error text-danger atterr" id="add_coattachments_0_error"></small>

                                                
                                                <div class="d-flex justify-content-between mt-2">
                                                    <button type="button" class="add-item btn btn-success btn-sm" id="add_attachment_btn"><i class="uil uil-plus"></i> Add New</button>
                                                </div>
                                                
                                                
                                            </div>
                                            <div id="uploadContainer"></div>

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
                                                <select class="form-select select2">
                                                    <option>Filter by Location Type</option>
                                                    <option>Loading Points</option>
                                                    <option>Unloading Points</option>
                                                    <option>Loading & Unloading Points</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary reset-btn ms-2"><i class="uil uil-history me-1"></i>Reset</button>
                                        </div>
                                    </div>
                                    
                                    <div class="accordion" id="locationCollapse">
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div><span style="font-size: 15px;">Location Name: Webel Gate</span> <span class="badge badge-success ms-2">Loading Point</span></div>
                                            <div class="d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="btn btn-success me-3"><i class="uil uil-whatsapp me-2"></i>Share</a>
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt me-2"></i></a>
                                            </div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#locationCollapse">
                                          <div class="accordion-body">
                                                <div class="item-rowsec">
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Address:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>13th Floor, Arch Square X2,</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">

                                                            <div class="row form-group ">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>City:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>Kolkata</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-lg-5">

                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>State:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>West Bengal</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Postal Code:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>700025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Brone By:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>SRL</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Average Loading Time:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>2  Hrs 30 Mins</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-5">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Loading Charge:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>₹ 500.00</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Person:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>Nikhil Sharma</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9876543210</p>
                                                        </div>
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite WhatsApp Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9879087210</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Additional Info:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Embeded Map:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <a href="#" style="font-size: 12px; line-height: 20px;">
                                                                https://www.google.com/maps?client=firefox-b-d&sca_esv=7550878c098e0420&output=search&q=...
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div>Location Name:  DLF 1 <span class="badge badge-success ms-2">Unloading Point</span></div>
                                            <div class="d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="btn btn-success me-3"><i class="uil uil-whatsapp me-2"></i>Share</a>
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt me-2"></i></a>
                                            </div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#locationCollapse">
                                          <div class="accordion-body">
                                                <div class="item-rowsec">
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Address:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>13th Floor, Arch Square X2,</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group ">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>City:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>Kolkata</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>State:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>West Bengal</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Postal Code:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>700025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Brone By:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>SRL</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <label>Average Unloading Time:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>2  Hrs 30 Mins</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>Unloading Charge:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>₹ 500.00</label>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Person:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>Nikhil Sharma</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9876543210</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite WhatsApp Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9879087210</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Additional Info:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Embeded Map:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <a href="#" style="font-size: 12px; line-height: 20px;">
                                                                https://www.google.com/maps?client=firefox-b-d&sca_esv=7550878c098e0420&output=search&q=...
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                              <h6 class="text-dark mb-0 d-flex align-items-center justify-content-between w-100"><div>Location Name: SDF <span class="badge badge-success ms-2">Loading & Unloading Point</span></div>
                                              <div class="d-flex align-items-center me-3">
                                                <a href="javascript:void(0)" class="btn btn-success me-3"><i class="uil uil-whatsapp me-2"></i>Share</a>
                                                <a href="javascript:void(0)" class="text-danger"><i class="uil uil-trash-alt me-2"></i></a>
                                              </div>
                                            </h6>
                                          </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#locationCollapse">
                                          <div class="accordion-body">
                                                 <div class="item-rowsec">
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Address:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>13th Floor, Arch Square X2,</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group ">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>City:</label>
                                                                </div>

                                                               <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>Kolkata</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-lg-6">

                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>State:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>West Bengal</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group mb-0">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Postal Code:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>700025</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12 col-lg-6">
                                                            <div class="row form-group">
                                                                <div class="col-12 col-lg-5 col-md-3">
                                                                    <label>Brone By:</label>
                                                                </div>

                                                                <div class="col-12 col-lg-7 col-md-9">
                                                                    <p>SRL</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <label>Average Loading Time:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>2  Hrs 30 Mins</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>Loading Charge:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>₹ 500.00</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3">
                                                            <label>Average Unloading Time:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>2  Hrs 30 Mins</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>Unloading Charge:</label>
                                                        </div>
                                                        <div class="col-12 col-md-3">
                                                            <label>₹ 500.00</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Person:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>Nikhil Sharma</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite Contact Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9876543210</p>
                                                        </div>
                                                        
                                                        <div class="col-12 col-md-2">
                                                            <label>Onsite WhatsApp Number:</label>
                                                        </div>

                                                        <div class="col-12 col-md-2">
                                                            <p>+91 9879087210</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Additional Info:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.</p>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="row form-group">
                                                        <div class="col-12 col-lg-2 col-md-3">
                                                            <label>Embeded Map:</label>
                                                        </div>

                                                        <div class="col-12 col-lg-10 col-md-9">
                                                            <a href="#" style="font-size: 12px; line-height: 20px;">
                                                                https://www.google.com/maps?client=firefox-b-d&sca_esv=7550878c098e0420&output=search&q=...
                                                            </a>
                                                        </div>
                                                    </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
                                </div>

                                
                                <div class="tab-pane fade" id="activity" role="tabpanel">

                                    <div class="e-activitywrapper">

                                        <div class="note-wrap">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea class="form-control" rows="4" placeholder="Write your message here"></textarea>
                                            </div>
                                        </div>

                                        <div class="cmnt-wrap mt-4">
                                            <div class="d-flex mb-4">
                                                <span class="avatar bg-avatar-primary me-3">JD</span>
                                                <div>
                                                    <h6 class="mb-0">John Doe</h6>
                                                    <small class="d-block text-secondary">12th Jan | 12:00 PM</small>
                                                    <p class="text-secondary">Lorem ipsum doller sit amet.</p>
                                                </div>
                                            </div>

                                            <div class="d-flex">
                                                <span class="avatar bg-avatar-primary me-3">AJ</span>
                                                <div>
                                                    <h6 class="mb-0">Andrew Jackson</h6>
                                                    <small class="d-block text-secondary">12th Jan | 12:00 PM</small>
                                                    <p class="text-secondary">Lorem ipsum doller sit amet.</p>
                                                </div>
                                            </div>
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

@endsection

@section('js')

<script>

    var CONTACTS = "{{ route('contact.' . $cotype->slug . '.index') }}";
    var CONTACTPERSON_WRAPPER = "{{ route('contact.' . $cotype->slug . '.contactpersonwrapper') }}";
    var ATTACHMENT_WRAPPER    = "{{ route('contact.attachmentwrapper') }}";
    
    window.UPLOAD_URL = "{{ route('contact.upload.images') }}";
    
    console.log("UPLOAD_URL:", window.UPLOAD_URL); 
    
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

<script type="text/javascript" src="{{ asset('public/customjs/contact/' . $cotype->slug . '/create.js') }}"></script>

@endsection





