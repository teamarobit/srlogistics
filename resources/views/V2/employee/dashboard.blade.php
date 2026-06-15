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
                    <div class="cv2-crumb"><a href="{{ route('home') }}">Master Data</a> · Contacts · Employee</div>
                    <h1>Employee Dashboard</h1>
                    <div class="cv2-sub">Overview of your workforce — office &amp; service-center staff, assets and exits.</div>
                </div>
                <div class="cv2-phead-actions">
                    <a href="{{ route('contact.v2.employee.index') }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-list-ul"></i>View All</a>
                    <a href="{{ route('contact.v2.employee.create') }}" class="cv2-btn cv2-btn-primary"><i class="bi bi-plus-lg"></i>Add Employee</a>
                </div>
            </div>

            {{-- KPI row --}}
            <div class="cv2-kpis">
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-people"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['total'] ?? 0 }}</div><div class="cv2-kpi-lbl">Total Employees</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-ok"><i class="bi bi-check2-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['active'] ?? 0 }}</div><div class="cv2-kpi-lbl">Active</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-pause-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['inactive'] ?? 0 }}</div><div class="cv2-kpi-lbl">Inactive</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-bad"><i class="bi bi-slash-circle"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['blacklisted'] ?? 0 }}</div><div class="cv2-kpi-lbl">Blacklisted</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-building"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['office'] ?? 0 }}</div><div class="cv2-kpi-lbl">Office Work</div>
                </div>
                <div class="cv2-kpi">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-tools"></i></span></div>
                    <div class="cv2-kpi-val">{{ $kpi['serviceCtr'] ?? 0 }}</div><div class="cv2-kpi-lbl">Service Center</div>
                </div>
            </div>

            {{-- Recent + side --}}
            <div class="cv2-grid cv2-grid-2-1 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Employees</h3><a class="cv2-link" href="{{ route('contact.v2.employee.index') }}">View all →</a></div>
                    <div class="cv2-card-b is-flush">
                        <table class="cv2-table">
                            <thead><tr><th>Employee</th><th>Work Type</th><th>Department</th><th>Branch</th><th>Status</th><th></th></tr></thead>
                            <tbody>
                                @forelse($employees as $e)
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:11px;">
                                            <span class="cv2-avatar" style="width:36px;height:36px;font-size:13px;border-radius:10px;">{{ strtoupper(mb_substr($e['name'],0,1)) }}</span>
                                            <div><span class="cv2-t-name">{{ $e['name'] }}</span><div class="cv2-t-sub">{{ $e['contactno'] }} · {{ $e['designation'] }}</div></div>
                                        </div>
                                    </td>
                                    <td><span class="cv2-pill">{{ $e['work_type'] }}</span></td>
                                    <td>{{ $e['department'] }}</td>
                                    <td>{{ $e['branch'] }}</td>
                                    <td>
                                        @php $sc=['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$e['status']]??'is-inactive'; @endphp
                                        <span class="cv2-badge {{ $sc }}"><span class="cv2-badge-dot"></span>{{ $e['status'] }}</span>
                                    </td>
                                    <td class="cv2-actions"><a href="{{ route('contact.v2.employee.show', $e['id']) }}" class="cv2-ic-btn" title="Open"><i class="bi bi-arrow-right"></i></a></td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center cv2-empty" style="padding:20px;">No employees yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="cv2-card">
                        <div class="cv2-card-h"><h3>Quick Actions</h3></div>
                        <div class="cv2-card-b" style="display:flex;flex-direction:column;gap:10px;">
                            <a href="{{ route('contact.v2.employee.create') }}" class="cv2-btn cv2-btn-primary" style="justify-content:flex-start;"><i class="bi bi-person-plus"></i>New Employee</a>
                            <a href="{{ route('contact.v2.employee.index') }}" class="cv2-btn cv2-btn-ghost" style="justify-content:flex-start;"><i class="bi bi-search"></i>Find an Employee</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
