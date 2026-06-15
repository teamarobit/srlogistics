@extends('layouts.app')

@section('css')
<link href="{{ asset('css/V2/employee.css?v=2.0') }}" rel="stylesheet">
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
                    <div class="cv2-sub">{{ $employees->total() }} {{ \Illuminate\Support\Str::plural('employee', $employees->total()) }}</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.employee.dashboard') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-speedometer2"></i>Dashboard</a>
                    <a href="{{ route('contact.v2.employee.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Employee</a>
                </div>
            </div>

            <div class="cv2-card">
                <form method="GET" action="{{ route('contact.v2.employee.index') }}" class="cv2-filters">
                    <div class="cv2-search"><i class="bi bi-search"></i><input type="text" name="name" value="{{ $search_name ?? '' }}" placeholder="Search by name or contact no…"></div>
                    <select class="cv2-select" name="worktype" onchange="this.form.submit()">
                        <option value="">All Work Types</option>
                        <option value="Office Work" {{ ($search_worktype ?? '')=='Office Work'?'selected':'' }}>Office Work</option>
                        <option value="Service Center" {{ ($search_worktype ?? '')=='Service Center'?'selected':'' }}>Service Center</option>
                    </select>
                    <select class="cv2-select" name="branch" onchange="this.form.submit()">
                        <option value="">All Branches</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ (string)($search_branch ?? '')===(string)$b->id?'selected':'' }}>{{ $b->location }}</option>
                        @endforeach
                    </select>
                    <select class="cv2-select" name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="Active" {{ ($search_status ?? '')=='Active'?'selected':'' }}>Active</option>
                        <option value="Inactive" {{ ($search_status ?? '')=='Inactive'?'selected':'' }}>Inactive</option>
                        <option value="Blacklisted" {{ ($search_status ?? '')=='Blacklisted'?'selected':'' }}>Blacklisted</option>
                    </select>
                    <button type="submit" class="cv2-btn cv2-btn-primary cv2-btn-sm"><i class="bi bi-search"></i>Filter</button>
                    <a href="{{ route('contact.v2.employee.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-arrow-counterclockwise"></i>Reset</a>
                </form>

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
                            @forelse($employees as $e)
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
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="text-center cv2-empty" style="padding:24px;">No employees found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="cv2-pager">
                    <span>
                        @if($employees->total() > 0)
                            Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }} of {{ $employees->total() }}
                        @else
                            Showing 0 of 0
                        @endif
                    </span>
                    <div class="cv2-pages">{{ $employees->withQueryString()->links() }}</div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')<script src="{{ asset('js/V2/employee.js?v=2.0') }}"></script>@endsection
