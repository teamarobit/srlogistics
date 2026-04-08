@extends('layouts.app')

@section('css')
<style>
    body{
        background-color: #fff;
    }
    .dropdown-item{
        padding: 5px 15px;
    }
</style>
@endsection

@section('content')
<div class="layout-wrapper">
    
    @include('includes.header')
    
    <div class="wrapper">
        <div class="side-wrap">
            
            @include('includes.leftbar')
            
            <div class="main-wrap">
                    <div class="container-fluid page-head">
                        <div class="row align-items-end">
                            <div class="col-12">
                                <h5 class="d-inline-block mb-0">Admin Console</h5>
                                
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection