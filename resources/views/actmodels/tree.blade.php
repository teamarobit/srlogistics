@extends('layouts.app')

@section('css')
<style>
    body{
        background-color: #fff;
    }
    
    .sidemenu .accordion-button{
        background: #f7f7fe !important;
    }
    .collapse-right{
        position: absolute;
        right: 60px;
        top: 3px;
        z-index: 9;
    }
    
    /* Make node labels bold */
    #tree .node field_0 {
        font-weight: bold !important;
    }
    
    /* Alternative (works on most templates) */
    .orgchart .boc .field_0 {
        font-weight: bold !important;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />

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
                                <h5 class="d-inline-block mb-0">Actmodels Tree</h5>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="container">
                            <div id="jstree"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('js')

{{-- OrgChart JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
<script>
$(function () {
    $.get("{{ route('actmodels.tree') }}", function (data) {

        // Transform pid=null into parent:"#"
        let formatted = data.map(function (node) {
            return {
                id: node.id,
                parent: node.pid === null ? "#" : node.pid,
                text: node.name
            };
        });

        $('#jstree').jstree({
            'core': {
                'data': formatted
            }
        });

        // When tree is ready
        $('#jstree').on('ready.jstree', function () {
            let tree = $('#jstree').jstree(true);
            // Get all root nodes (parent = #)
            let roots = tree.get_node('#').children;
            // Open each root node (first level only)
            roots.forEach(function (rootId) {
                tree.open_node(rootId);
            });
        });
    });
});

</script>

@endsection







