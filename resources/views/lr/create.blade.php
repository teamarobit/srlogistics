@extends('layouts.app')

@section('css')
<link href="{{ asset('css/lr/create.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">

    @include('includes.header')

    <form class="wrapper mt-5">
        <div class="container-fluid page-head pt-4">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h5>Add LR</h5>
                </div>
                <div class="col-12 col-md-4 text-end">
                    <a href="{{ route('trip.lr.print') }}" class="btn btn-primary me-2" style="padding: 8px 30px;">Save</a>
                    <a href="trip-details.php" class="btn btn-theme me-2" style="padding: 8px 30px;">Close</a>
                </div>
            </div>
            
            
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="bg-light view-content p-3">
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="mb-2">
                                    <p class="text-secondary mb-1">Source</p>
                                    <p class="mb-0">Kolkata</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div>
                                    <p class="text-secondary mb-1">Destination</p>
                                    <p class="mb-0">Durgapur</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="mb-2">
                                    <p class="text-secondary mb-1">Vehicle Number</p>
                                    <p class="mb-0">WB-12-FV5667</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div>
                                    <p class="text-secondary mb-1">Vehicle Size</p>
                                    <p class="mb-0">32-FT SXL</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="row form-group mt-3 mb-0">
                <div class="col-12 col-md-1">
                    <label>LR #</label>
                </div>
                <div class="col-12 col-md-2">
                    <input type="text" class="form-control">
                </div>
                <div class="col-12 col-md-1">
                    <label>LR Party #</label>
                </div>
                <div class="col-12 col-md-2">
                    <input type="text" class="form-control">
                </div>
                <div class="col-12 col-md-1">
                    <label>LR Date</label>
                </div>
                <div class="col-12 col-md-2">
                    <input type="date" class="form-control">
                </div>
                </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="mt-3">
                        <div class="row form-group">
                        <div class="col-12 col-md-1">
                            <label>Gross Weight</label>
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-12 col-md-1">
                            <label>Seal Number</label>
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="text" class="form-control" value="" data-role="tagsinput">
                        </div>
                        <div class="col-12 col-md-1">
                            <label>Transport Mode</label>
                        </div>
                        <div class="col-12 col-md-2">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-12 col-md-1">
                            <label>Tarpaulin</label>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tarpulin" id="vl1" value="option1">
                                <label class="form-check-label" for="vl1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tarpulin" id="vl2" value="option2">
                                <label class="form-check-label" for="vl2">No</label>
                            </div>
                        </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row form-group">
                            <div class="col-12 col-md-1"></div>
                            <div class="col-12 col-md-3">
                                <p class="text-dark mb-1">Consigner Name & Address </p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Britania Kolkata</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                            </div>
                            <div class="col-12 col-md-3">
                                <p class="text-dark mb-1">Consignee Name & Address </p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Samsung Hydrabad</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                            </div>
                            <div class="col-12 col-md-3">
                                <p class="text-dark mb-1">Ship to Party Details </p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Samsung Hydrabad</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">13946 Desiree Burgs Suite 113</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Port Clintonborough</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Georgia 974-395</p>
                                <p class="mb-0 text-secondary" style="font-size: 13px;">Phone: (006)-336-077</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 mt-0">
                    <div class="right-side-wrap">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-item-tab" data-bs-toggle="pill" data-bs-target="#pills-item" type="button" role="tab" aria-controls="pills-item" aria-selected="true">Items</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-item" role="tabpanel" aria-labelledby="pills-item-tab">
                            <div class="table-responsive mt-0">
                                <table class="table table-hover invoice-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>
                                                S.N
                                            </th>
                                            <th>Invoice Number<br/><span class="text-secondary">Invoice Date</span></th>
                                            <th>Product Name<br/><span class="text-secondary">Description</span></th>
                                            <th>No. of Units</th>
                                            <!--<th>Total Amount</th>-->
                                            <th>Total CFT Volume<br/><span class="text-secondary">Weight (MT)</span></th>
                                            <th>Goods Value (₹)</th>
                                            <th>EWAY Bill No.<br/><span class="text-secondary">EWAY Bill Date</span></th>
                                            <th>Valid Till</th>
                                            <th class="text-end">Freight Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 120px;">
                                                <input type="date" class="form-control mt-1" style="width: 120px;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 120px;">
                                                <textarea type="textarea" class="form-control mt-1" style="width: 120px;" rows="1"></textarea>
                                            </td>
                                            <td><input type="text" class="form-control" style="width: 120px;"></td>
                                            <td><input type="text" class="form-control" style="width: 120px;"><input type="text" class="form-control mt-1" style="width: 120px;"></td>
                                            <td><input type="text" class="form-control" style="width: 120px;"></td>
                                            <td><input type="text" class="form-control" style="width: 120px;"><input type="date" class="form-control mt-1" style="width: 120px;"></td>
                                            <td><input type="date" class="form-control" style="width: 120px;"></td>
                                            <td class="text-end"></td>
                                        </tr>
                                        <tr class="new-table-row">
                                            <td>
                                                2
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 120px;">
                                                <input type="date" class="form-control mt-1" style="width: 120px;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" style="width: 120px;">
                                                <textarea type="textarea" class="form-control mt-1" style="width: 120px;" rows="1"></textarea>
                                            </td>
                                            <td><input type="text" class="form-control" style="width: 120px;"></td>
                                            <td><input type="text" class="form-control" style="width: 120px;"><input type="text" class="form-control mt-1" style="width: 120px;"></td>
                                            <td><input type="text" class="form-control" style="width: 120px;"></td>
                                            <td><input type="text" class="form-control" style="width: 120px;"><input type="date" class="form-control mt-1" style="width: 120px;"></td>
                                            <td><input type="date" class="form-control" style="width: 120px;"></td>
                                            <td class="text-end"><i class="uil uil-trash-alt delete-table-row text-danger ms-4"></i></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" class=" bg-light"><h6>Total:</h6></td>
                                            <td class="text-end bg-light"><h6>10,000.00</h6></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="javascript:void(0)" class="btn btn-success add-item"><i class="uil uil-plus me-1"></i> Add Item</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                        
                <div class="row mt-4">
                    <div class="col-12 col-md-4">
                        <label>Notice</label>
                        <textarea class="form-control" rows="3" placeholder=""></textarea>
                    </div>
                    <div class="col-12 col-md-4">
                        <label>Rules</label>
                        <textarea class="form-control" rows="3" placeholder=""></textarea>
                    </div>
                    <div class="col-12 col-md-4">
                        <label>Remarks</label>
                        <textarea class="form-control" rows="3" placeholder=""></textarea>
                    </div>
                </div>
            </div>
            
        </div>
    </form>

</div>{{-- /layout-wrapper --}}

@endsection

@section('js')
<script src="{{ asset('customjs/lr/create.js?v=1.0') }}"></script>
@endsection
