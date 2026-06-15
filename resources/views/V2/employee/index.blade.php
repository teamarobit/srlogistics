@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/employee.css?v=1.0') }}" rel="stylesheet">
@endsection

@section('content')
<div class="layout-wrapper">
    @include('includes.header')
    <div class="cv2-wrap">
        <div class="cv2-container">

            <div class="cv2-phead">
                <div>
                    <div class="cv2-crumb"><a href="{{ route('contact.v2.employee.dashboard') }}">Employee Dashboard</a> · All Employees</div>
                    <h1>Employees</h1>
                    <div class="cv2-sub">86 employees · 78 active</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.employee.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.employee.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Employee</a>
                </div>
            </div>

            <div class="cv2-card">
                <div class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" placeholder="Search by name or contact no…"></div>
                    <select class="cv2-select"><option>All Work Types</option><option>Office Work</option><option>Service Center</option></select>
                    <select class="cv2-select"><option>All Branches</option><option>Guwahati HO</option><option>Dibrugarh SC</option><option>Silchar SC</option><option>Tinsukia Branch</option></select>
                    <select class="cv2-select"><option>All Departments</option><option>Operations</option><option>Maintenance</option><option>Accounts</option><option>HR</option></select>
                    <select class="cv2-select"><option>All Status</option><option>Active</option><option>Inactive</option><option>Blacklisted</option></select>
                    <button class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</button>
                </div>

                <div class="cv2-card-b is-flush">
                    <table class="cv2-table">
                        <thead>
                            <tr>
                                <th style="width:34px;"><input type="checkbox"></th>
                                <th>Contact No</th><th>Name</th><th>Work Type</th><th>Branch</th>
                                <th>Department</th><th>Designation</th><th>Phone</th><th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $e)
                            <tr>
                                <td><input type="checkbox"></td>
                                <td class="cv2-t-mono">{{ $e['contactno'] }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:11px;">
                                        <span class="cv2-avatar" style="width:34px;height:34px;font-size:12px;border-radius:9px;">{{ strtoupper(mb_substr($e['name'],0,1)) }}</span>
                                        <div><span class="cv2-t-name">{{ $e['name'] }}</span><div class="cv2-t-sub">{{ $e['email'] }}</div></div>
                                    </div>
                                </td>
                                <td><span class="cv2-pill">{{ $e['work_type'] }}</span></td>
                                <td>{{ $e['branch'] }}</td>
                                <td>{{ $e['department'] }}</td>
                                <td>{{ $e['designation'] }}</td>
                                <td class="cv2-t-mono">{{ $e['phone'] }}</td>
                                <td>
                                    @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$e['status']]??'is-inactive'; @endphp
                                    <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $e['status'] }}</span>
                                </td>
                                <td class="cv2-actions">
                                    <a href="{{ route('contact.v2.employee.show', $e['id']) }}" class="cv2-ic-btn" title="View"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('contact.v2.employee.edit', $e['id']) }}" class="cv2-ic-btn" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <a href="javascript:void(0)" class="cv2-ic-btn is-danger cv2-del" title="Delete"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>Showing 1–5 of 86</span>
                    <div class="cv2-pages">
                        <a href="javascript:void(0)"><i class="bi bi-chevron-left"></i></a>
                        <a href="javascript:void(0)" class="is-active">1</a>
                        <a href="javascript:void(0)">2</a>
                        <a href="javascript:void(0)">3</a>
                        <a href="javascript:void(0)"><i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=1.0') }}"></script>@endsection
