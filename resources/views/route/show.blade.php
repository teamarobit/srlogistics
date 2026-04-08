@extends('layouts.app')

@section('css')
<style>
    body{
        background-color: #fff;
    }
    .form-bg{
        padding: 20px 30px;
        background: #f1f1f1;
        margin-bottom: 20px;
    }
    .btn-theme.head-btn i{
        background-color: transparent;
        color: #000;
    }
    /*.btn{*/
    /*    padding: 8px 12px;*/
    /*    text-transform: inherit;*/
    /*}*/
    .form-check-input[type=checkbox]:checked {
        background-color: #1f75a8 !important;
        border-color: #1f75a8 !important;
    }
    p{
        font-size: 14px;
        margin-bottom: 0px;
    }
    .btn-theme i{
        font-size: 8px;
    }
    input[type=radio]{
        color: #000;
    }
    .form-control.has-val{
        border-color: transparent;
    }
    .form-control.has-val:focus{
        border: #d4d6db;
    }
    .head-btn:after{
        display: none;
    }
    .badge.bg-primary {
        background-color: #c8e5fc !important;
        padding: 10px 20px;
        color: #333;
        font-size: 16px;
    }
    .table thead tr th {
        padding: 8px 15px;
        vertical-align: middle;
    }
    .table tbody tr td {
        padding: 8px 15px;
    }
    .page-head p strong{
        font-weight: 600 !important;
    }
    .accordion-button{
        background: #ecf2f4 !important;
        padding: 10px 20px;
        color: #0b5871;
        font-weight: 600;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="wrapper mt-5">
        <div class="container-fluid page-head">
            <form action="{{route('bom.changestatus')}}" method="POST" id="changeStatusForm">
            @csrf
            <input type="hidden" name="bomid" value="{{ $bom->id }}">
            <input type="hidden" name="status" value="Inactive"> {{-- fallback if unchecked --}}
            <div class="row">  
                <div class="col-12 col-md-8">
                    <h6 class="text-theme">Bill of Materials</h6>
                    <div class="mt-2">
                      <div class="row">
                        <div class="col-12 col-md-3">
                            <p><strong>{{ $bom->bomno }}</strong></p>
                        </div>
                        <div class="col-12 col-md-2">
                            <p><strong>{{ $bom->name }}</strong></p>
                        </div>
                        <div class="col-12 col-md-3">
                            <p><strong>Latest Version</strong></p>
                        </div>
                        <div class="col-12 col-md-2">
                            <p>
                                @if($latestVersion) 
                                    {{ $latestVersion->version }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                      </div>
                      
                      <div class="row mt-2">
                        <div class="col-12 col-md-3">
                            <p><strong>Last Modified by</strong></p>
                        </div>
                        <div class="col-12 col-md-2">
                            <p>{{ $latestVersion->updatedby?->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 col-md-3">
                            <p><strong>Last Modified Date</strong></p>
                        </div>
                        <div class="col-12 col-md-2">
                            <p>{{ ($latestVersion && $latestVersion->updated_at) ? $latestVersion->updated_at->format('d-m-Y h:i A') : '-' }}</p>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-check form-switch ps-0">
                                <label class="form-check-label d-inline-block" for="statusSwitch">Status</label>
                                <input
                                    class="form-check-input float-end"
                                    style="border-radius: 20px !important;"
                                    type="checkbox"
                                    name="status"
                                    id="statusSwitch"
                                    value="Active"
                                    {{ $bom->status === 'Active' ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                      </div>
                      
                      <div class="row mt-2">
                        <div class="col-12 col-md-3">
                            <p><strong>Description</strong></p>
                        </div>
                        <div class="col-12 col-md-9">
                            <p>{{ $bom->description }}</p>
                        </div>
                      </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4 text-end">
                    <a href="{{ route('bom.add-new-version', $bom->id) }}" class="btn btn-theme me-2"><i class="uil uil-plus me-1"></i>Version</a>
                    <button type="button" class="btn btn-primary me-2" style="text-decoration: capitalise;" id="changeStatusBtn">Save</button>
                    <a href="{{route('bom.index')}}" class="btn btn-theme me-2">Close</a>
                </div>
            </div>
            </form>
        </div>
        
        <hr class="border-hr">
        
        <div class="container-fluid">  
            <div class="accordion mt-4" id="accordioncustomerArticlesExample">
                
                
              @if($latestVersion)    
              <div class="accordion-item position-relative">
                <h2 class="accordion-header" id="customerArticles-headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#customerArticles-collapseOne" aria-expanded="true" aria-controls="customerArticles-collapseOne">
                    Version: {{ $latestVersion->version }} <span class="badge bg-success ms-2">Latest Version</span> <span class="text-secondary ms-2 me-2">|</span> No. of CA tagged:  {{ $latestVersionCarticlesCount }}<span class="text-secondary ms-2 me-2">|</span> Creation Date: {{ $latestVersion->created_at->format('d-m-Y') }}
                  </button>
                </h2>
                <span style="position: absolute; right: 60px; top: 9px; z-index: 9;">
                    <span class="edit-bg"><a href="{{route('bom.edit',$bom->id)}}"><i class="uil uil-pen text-success"></i></a></span>
                    <span class="edit-bg"><a href="{{route('bom.copy-the-version',$latestVersion->id)}}"><i class="uil uil-copy text-primary"></i></a></span>
                    <!--<span class="edit-bg"><a href="javascript:void(0)"><i class="uil uil-copy text-primary copy-version" data-VersionId="{{ $latestVersion->id }}"></i></a></span>-->
                    <!--<span class="edit-bg me-0"><a href="javascript:void(0)"><i class="uil uil-trash text-danger delete-version" data-VersionId="{{ $latestVersion->id }}"></i></a></span>-->
                </span>
                <div id="customerArticles-collapseOne" class="accordion-collapse collapse show" aria-labelledby="customerArticles-headingOne">
                  <div class="accordion-body">
                        <div class="table-responsive">
                            <table class="table table-hover invoice-table mb-0">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th style="width: 300px;">Item Name</th>
                                        <th>Item Type</th>
                                        <th>Quantity</th>
                                        <th>UOM</th>
                                        <th>Last Buying Price per Unit (₹)</th>
                                        <th>Average Buying Price per Unit (₹)</th>
                                        <th style="width: 20px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestVersion->bomitems as $item)
                                    <tr>
                                        <td>{{ $item->product?->hsn ?? '-' }}</td>
                                        <td class="d-flex">
                                            <span class="me-2">
                                                
                                                @if ($item->product && $item->product->primary_image)
                                                    <img src="{{ asset('public/media/product/' . $item->product->primary_image) }}" alt="{{ $item->product->primary_image }}" width="50">
                                                @else
                                                    
                                                @endif
                                                
                                            </span>{{ $item->product?->name ?? '-' }}
                                        </td>
                                        <td>{{ $item->prodtype?->name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit->name ?? $item->unit->name ?? 'N/A' }}</td>
                                        <td>₹{{ $item->last_buying_price }}</td>
                                        <td>₹{{ $item->avg_buying_price }}</td>
                                    </tr>
                                    @endforeach
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                  </div>
                </div>
              </div>
              @endif
              
              <h6 class="text-theme mt-4">Version History</h6>
              
              @if($versionHistory->count())
                @foreach($versionHistory as $version)
                
                @php
                    $countData = $versionHistoryCounts->firstWhere('bomversion_id', $version->id);
                    $uniqueCarticlesCount = $countData['unique_carticles_count'] ?? 0;
                @endphp
                <div class="accordion-item mt-4 position-relative">
                <h2 class="accordion-header" id="customerArticles-headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#customerArticles-collapseTwo" aria-expanded="false" aria-controls="customerArticles-collapseTwo">
                    Version: {{ $version->version }} <span class="text-secondary ms-2 me-2">|</span> No. of CA tagged:  {{ $uniqueCarticlesCount }}  {{-- $bom->carticles_count --}} <span class="text-secondary ms-2 me-2">|</span> Creation Date: {{ $version->created_at->format('d-m-Y') }}
                  </button>
                </h2>
                <span style="position: absolute; right: 60px; top: 9px; z-index: 9;">
                    <span class="edit-bg"><a href="{{route('bom.edit',$bom->id)}}"><i class="uil uil-pen text-success"></i></a></span>
                    <span class="edit-bg"><a href="{{route('bom.copy-the-version',$version->id)}}"><i class="uil uil-copy text-primary"></i></a></span>
                    <!--<span class="edit-bg"><a href="javascript:void(0)"><i class="uil uil-copy text-primary copy-version" data-VersionId="{{ $version->id }}"></i></a></span>-->
                    <!--<span class="edit-bg me-0"><a href="javascript:void(0)"><i class="uil uil-trash text-danger delete-version" data-VersionId="{{ $version->id }}"></i></a></span>-->
                </span>
                <div id="customerArticles-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="customerArticles-headingTwo">
                  <div class="accordion-body">
                        <div class="table-responsive">
                            
                            <table class="table table-hover invoice-table mb-0">
                                <thead>
                                    <tr>
                                        <th>
                                            SKU
                                        </th>
                                        <th style="width: 300px;">Item Name</th>
                                        <th>Item Type</th>
                                        <th>Quantity</th>
                                        <th>UOM</th>
                                        <th>Last Buying Price per Unit (₹)</th>
                                        <th>Average Buying Price per Unit (₹)</th>
                                        <!--<th style="width: 20px;"></th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($version->bomitems as $item)
                                    <tr>
                                        <td>{{ $item->product?->hsn ?? '-' }}</td>
                                        <td>
                                            <span class="me-2">
                                                
                                                @if ($item->product && $item->product->primary_image)
                                                    <img src="{{ asset('public/media/product/' . $item->product->primary_image) }}" alt="{{ $item->product->primary_image }}" width="50">
                                                @else
                                                    N/A
                                                @endif
                                                
                                            </span>{{ $item->product?->name ?? '-' }}
                                        </td>
                                        <td>{{ $item->prodtype?->name ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->unit->name ?? $item->unit->name ?? 'N/A' }}</td>
                                        <td>₹{{ $item->last_buying_price }}</td>
                                        <td>₹{{ $item->avg_buying_price }}</td>
                                        <!--<td><span class="text-secondary"><i class="uil uil-times-circle"></i></span></td>-->
                                    </tr>
                                    @endforeach
                                    
                                    
                                    
                                </tbody>
                            </table>
                            
                        </div>
                  </div>
                </div>
              </div>
                @endforeach
              @else
                <p>No versions found.</p>
              @endif
              
              
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('js')
<script>
    var BOMS       = "{{route('bom.index')}}";
    var EDIT_BOM    = "{{ route('bom.edit', ['id' => $bom->id]) }}";
   
</script>
<script type="text/javascript" src="{{ asset('public/customjs/bom/show.js') }}?v={{ time() }}"></script>
@endsection