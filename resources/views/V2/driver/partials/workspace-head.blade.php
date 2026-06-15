{{-- Driver V2 workspace header: profile banner + submodule page navigation.
     Each submodule is its OWN page (not a tab). Expects: $d, $active, $counts, $isExited --}}
@php
    $initials = collect(explode(' ', $d['name']))->map(fn($w)=>mb_substr($w,0,1))->take(2)->implode('');
    $statusClass = ['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$d['status']] ?? 'is-inactive';
    $ragClass = ['Red'=>'is-red','Yellow'=>'is-yellow','Green'=>'is-green'][$d['rag']] ?? 'is-green';
    $nav = [
        ['key'=>'overview','label'=>'Overview','icon'=>'bi-grid','route'=>'contact.v2.driver.show','count'=>null],
        ['key'=>'joining','label'=>'Joining','icon'=>'bi-box-arrow-in-right','route'=>'contact.v2.driver.joining','count'=>$counts['joining']],
        ['key'=>'documents','label'=>'Documents','icon'=>'bi-paperclip','route'=>'contact.v2.driver.documents','count'=>$counts['documents']],
        ['key'=>'assets','label'=>'Assets','icon'=>'bi-box-seam','route'=>'contact.v2.driver.assets','count'=>$counts['assets']],
        ['key'=>'bhatta','label'=>'Driver Bhatta','icon'=>'bi-cash-coin','route'=>'contact.v2.driver.bhatta','count'=>$counts['bhatta']],
        ['key'=>'exit','label'=>'Exit','icon'=>'bi-box-arrow-right','route'=>'contact.v2.driver.exit','count'=>$counts['exit']],
        ['key'=>'activity','label'=>'Activity','icon'=>'bi-clock-history','route'=>'contact.v2.driver.activity','count'=>$counts['activity']],
    ];
@endphp

<div class="cv2-profile">
    <div class="cv2-profile-top">
        <div class="cv2-avatar is-lg">{{ strtoupper($initials) }}</div>
        <div class="cv2-profile-id">
            <h2>{{ $d['name'] }}
                <span class="cv2-badge {{ $statusClass }}"><span class="cv2-badge-dot"></span>{{ $d['status'] }}</span>
                <span class="cv2-rag {{ $ragClass }}"><span class="dot"></span>{{ $d['rag'] }} RAG</span>
            </h2>
            <div class="cv2-profile-meta">
                <span><i class="bi bi-hash"></i>{{ $d['contactno'] }} · {{ $d['driver_code'] }}</span>
                <span><i class="bi bi-tag"></i>{{ $d['category'] }}</span>
                <span><i class="bi bi-telephone"></i>{{ $d['phone'] }}</span>
                <span><i class="bi bi-credit-card-2-front"></i>DL {{ $d['licence_no'] }}</span>
                <span><i class="bi bi-truck"></i>{{ $d['vehicle'] }}</span>
            </div>
        </div>
        <div class="cv2-profile-actions">
            <a href="{{ route('contact.v2.driver.edit', $d['id']) }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-pencil"></i>Edit Info</a>
            <a href="{{ route('contact.v2.driver.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-list-ul"></i>All Drivers</a>
        </div>
    </div>
    <nav class="cv2-subnav">
        @foreach($nav as $item)
            <a href="{{ route($item['route'], $d['id']) }}" class="{{ $active === $item['key'] ? 'is-active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>{{ $item['label'] }}
                @if(!is_null($item['count']))<span class="cv2-count">{{ $item['count'] }}</span>@endif
            </a>
        @endforeach
    </nav>
</div>

@if(!empty($isExited))
<div class="cv2-exit-banner">
    <i class="bi bi-lock-fill"></i>
    <div>This driver <b>exited on {{ $d['exit_date'] }}</b> — the record is locked. Add / edit actions on Joining, Assets and Driver Bhatta are disabled. Generate the relieving letter from the Exit page.</div>
</div>
@endif
