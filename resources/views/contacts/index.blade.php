@extends('layouts.app')

@section('css')
<style>
    body{
        background-color: #fff;
    }
</style>
@endsection

@section('content')
    <div class="layout-wrapper">
        @include('includes.header')
        <div class="wrapper srlog-bdwrapper">
            <div class="side-wrap">
                @include('includes.leftbar')
                
                <div class="main-wrap">
                    <div class="container-fluid page-head">
                        <div class="row align-items-end">
                            <div class="col-12">
                                <h5 class="d-inline-block mb-0">Contract Master</h5>
                                <!--<a href="#" class="btn btn-theme mb-0 ms-2"><i class="uil uil-plus me-1"></i>Contract Master</a>-->
                                
                                @if($cotype)
                                  <input type="hidden" name="cotype" value="{{$cotype}}">
                                @endif
                                
                                <form class="d-inline-block" id="searchForm">
                                    @php $searched_contact = $contacts->firstWhere('id', $contactid ); @endphp
                                    <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                        <input type="text" class="form-control" placeholder="Search by Customer Name">
                                    </div>
                                    <div class="search-wrap d-inline-block ms-2" style="width: 230px;">
                                        <select class="form-select select2">
                                            <option>Filter by Contract No.</option>
                                            <option>987654</option>
                                            <option>765432</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary reset-btn"><i class="uil uil-history me-1"></i>Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Contract Type</th>
                                    <th>Contract Number</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Advance Payment</th>
                                    <th>Payment Base</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($contacts->count())
                                    @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->contact_name ?? '-' }}</td>
                                        <td>Trip Wise</td>
                                        <td>987654</td>
                                        <td>05-02-2025 16:00</td>
                                        <td>06-02-2025 11:00</td>
                                        <td>Rs. 150</td>
                                        <td>UPI</td>
                                        <td class="text-end">
                                            <div class="dropdown dot-dd">
                                              <span class="dropdown-toggle" id="moreTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-h"></i>
                                              </span>
                                              <ul class="dropdown-menu" aria-labelledby="moreTable" style="">
                                                <li><a class="dropdown-item" href="add-contract.php"><i class="uil uil-pen me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0)"><i class="uil uil-trash-alt me-2"></i>Delete</a></li>
                                              </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                <div class="no-datawrapper">
                                   <div class="container">
                                        <div class="no-data">
                                            <p class="text-dark mb-0">No Data Found</p>
                                        </div>
                                   </div>
                                </div>
                                @endif
                                
                                
                                
                                
                            </tbody>
                        </table>
                    </div>
                    
                    @if($contacts->count())
                    <nav aria-label="..." class="mt-4">
                      {{$contacts->appends(['cotype' => $cotype, 'contact' => $searched_contact?->id])->links('pagination::bootstrap-5')}}
                    </nav>
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    var DELETE_ITEM  = "{{ route('contact.delete') }}";
    var ALL_CONTACTS = "{{ route('contact.index') }}";
    
    @if( $cotype )
       var COTYPE                   = "{{ $cotype }}";
       var COTYPE_NAME              = "{{ str( $cotype )->plural()->replace('-',' ')->ucfirst() }}";
       var SEARCH_CONTACT           = "{{-- route('contact.'.str($cotype)->lower().'.search') --}}";
    @else
       var COTYPE                   =  null;
       var COTYPE_NAME              =  null;
       var SEARCH_CONTACT           = "{{-- route('contact.search') --}}";
    @endif
    
</script>
<script type="text/javascript" src="{{ asset('public/customjs/contact/index.js') }}?v={{ time() }}"></script>
@endsection