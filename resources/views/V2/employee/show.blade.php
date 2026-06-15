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
                <div class="cv2-crumb"><a href="{{ route('contact.v2.employee.index') }}">Employees</a> · {{ $e['name'] }} · Overview</div>
            </div>

            @include('V2.employee.partials.workspace-head')

            {{-- Overview count cards --}}
            <div class="cv2-kpis cv2-mt" style="grid-template-columns:repeat(6,1fr);">
                <a class="cv2-kpi" href="{{ route('contact.v2.employee.joining', $e['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-box-arrow-in-right"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['joining'] }}</div><div class="cv2-kpi-lbl">Work Experience</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.employee.assets', $e['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-pc-display"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['assets'] }}</div><div class="cv2-kpi-lbl">Assets Issued</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.employee.leave', $e['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-calendar2-week"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['leave'] }}</div><div class="cv2-kpi-lbl">Leaves Taken</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.employee.salary', $e['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic"><i class="bi bi-cash-stack"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['salary'] }}</div><div class="cv2-kpi-lbl">Salary Revisions</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.employee.documents', $e['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-paperclip"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['documents'] }}</div><div class="cv2-kpi-lbl">Documents</div>
                </a>
                <a class="cv2-kpi" href="{{ route('contact.v2.employee.activity', $e['id']) }}" style="text-decoration:none;color:inherit;">
                    <div class="cv2-kpi-top"><span class="cv2-kpi-ic is-slate"><i class="bi bi-clock-history"></i></span></div>
                    <div class="cv2-kpi-val">{{ $counts['activity'] }}</div><div class="cv2-kpi-lbl">Activities</div>
                </a>
            </div>

            <div class="cv2-grid cv2-grid-2 cv2-mt">
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Employment Summary</h3><a class="cv2-link" href="{{ route('contact.v2.employee.edit', $e['id']) }}">Edit →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-briefcase"></i></span><div class="cv2-mini-body"><b>{{ $e['work_type'] }}</b><span>{{ $e['department'] }} · {{ $e['designation'] }}</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-geo-alt"></i></span><div class="cv2-mini-body"><b>{{ $e['branch'] }}</b><span>Posting branch</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-calendar-check"></i></span><div class="cv2-mini-body"><b>Joined {{ \Carbon\Carbon::parse($e['doj'])->format('d M Y') }}</b><span>Date of joining</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-droplet"></i></span><div class="cv2-mini-body"><b>{{ $e['gender'] }} · {{ $e['blood_group'] }}</b><span>Gender · Blood group</span></div></li>
                        </ul>
                    </div>
                </div>
                <div class="cv2-card">
                    <div class="cv2-card-h"><h3>Recent Activity</h3><a class="cv2-link" href="{{ route('contact.v2.employee.activity', $e['id']) }}">View all →</a></div>
                    <div class="cv2-card-b">
                        <ul class="cv2-mini">
                            <li><span class="cv2-mini-ic"><i class="bi bi-cash-stack"></i></span><div class="cv2-mini-body"><b>Salary revised to ₹38,000</b><span>by Superadmin · 2 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-pc-display"></i></span><div class="cv2-mini-body"><b>Laptop DELL-4471 issued</b><span>by HR · 6 days ago</span></div></li>
                            <li><span class="cv2-mini-ic"><i class="bi bi-calendar2-week"></i></span><div class="cv2-mini-body"><b>2 days casual leave approved</b><span>by Operations · 2 weeks ago</span></div></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
