{{-- Employee V2 workspace header: profile banner + submodule page navigation.
     Each submodule is its OWN page (not a tab). Expects: $e, $active, $counts, $isExited --}}
@php
    $initials = collect(explode(' ', $e['name']))->map(fn($w)=>mb_substr($w,0,1))->take(2)->implode('');
    $statusClass = ['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$e['status']] ?? 'is-inactive';
    $nav = [
        ['key'=>'overview','label'=>'Overview','icon'=>'bi-grid','route'=>'contact.v2.employee.show','count'=>null],
        ['key'=>'joining','label'=>'Joining','icon'=>'bi-box-arrow-in-right','route'=>'contact.v2.employee.joining','count'=>$counts['joining']],
        ['key'=>'documents','label'=>'Documents','icon'=>'bi-paperclip','route'=>'contact.v2.employee.documents','count'=>$counts['documents']],
        ['key'=>'assets','label'=>'Assets','icon'=>'bi-pc-display','route'=>'contact.v2.employee.assets','count'=>$counts['assets']],
        ['key'=>'leave','label'=>'Leave Tracker','icon'=>'bi-calendar2-week','route'=>'contact.v2.employee.leave','count'=>$counts['leave']],
        ['key'=>'salary','label'=>'Salary','icon'=>'bi-cash-stack','route'=>'contact.v2.employee.salary','count'=>$counts['salary']],
        ['key'=>'exit','label'=>'Exit','icon'=>'bi-box-arrow-right','route'=>'contact.v2.employee.exit','count'=>$counts['exit']],
        ['key'=>'activity','label'=>'Activity','icon'=>'bi-clock-history','route'=>'contact.v2.employee.activity','count'=>$counts['activity']],
    ];
@endphp

<div class="cv2-profile">
    <div class="cv2-profile-top">
        <div class="cv2-avatar is-lg">{{ strtoupper($initials) }}</div>
        <div class="cv2-profile-id">
            <h2>{{ $e['name'] }}
                <span class="cv2-badge {{ $statusClass }}"><span class="cv2-badge-dot"></span>{{ $e['status'] }}</span>
                @if($isExited)<span class="cv2-badge is-black"><i class="bi bi-box-arrow-right"></i>Exited</span>@endif
            </h2>
            <div class="cv2-profile-meta">
                <span><i class="bi bi-hash"></i>{{ $e['contactno'] }}</span>
                <span><i class="bi bi-briefcase"></i>{{ $e['work_type'] }}</span>
                <span><i class="bi bi-diagram-3"></i>{{ $e['department'] }} · {{ $e['designation'] }}</span>
                <span><i class="bi bi-geo-alt"></i>{{ $e['branch'] }}</span>
                <span><i class="bi bi-telephone"></i>{{ $e['phone'] }}</span>
                <span><i class="bi bi-droplet"></i><span class="cv2-chip-bg">{{ $e['blood_group'] }}</span></span>
            </div>
        </div>
        <div class="cv2-profile-actions">
            <a href="{{ route('contact.v2.employee.edit', $e['id']) }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-pencil"></i>Edit Info</a>
            <a href="{{ route('contact.v2.employee.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-list-ul"></i>All Employees</a>
        </div>
    </div>
    <nav class="cv2-subnav">
        @foreach($nav as $item)
            <a href="{{ route($item['route'], $e['id']) }}" class="{{ $active === $item['key'] ? 'is-active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>{{ $item['label'] }}
                @if(!is_null($item['count']))<span class="cv2-count">{{ $item['count'] }}</span>@endif
            </a>
        @endforeach
    </nav>
</div>

@if($isExited)
<div class="cv2-exit-banner">
    <i class="bi bi-lock-fill"></i>
    <div>This employee has exited on 18 Apr 2026 — editing is locked.
        <small>Add actions on Assets, Salary, Work Experience &amp; Joining are disabled. The exit letter is available on the Exit page.</small>
    </div>
</div>
@endif
