{{-- Vehicle Vendor V2 workspace header: profile banner + submodule page navigation.
     Each submodule is its OWN page (not a tab). Expects: $v, $active, $counts --}}
@php
    $initials = collect(explode(' ', $v['company']))->map(fn($w)=>mb_substr($w,0,1))->take(2)->implode('');
    $statusClass = ['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$v['status']] ?? 'is-inactive';
    $ragClass = ['Green'=>'is-green','Yellow'=>'is-yellow','Red'=>'is-red'][$v['rag']] ?? 'is-green';
    $nav = [
        ['key'=>'overview','label'=>'Overview','icon'=>'bi-grid','route'=>'contact.v2.vehiclevendor.show','count'=>null],
        ['key'=>'vehicle','label'=>'Vehicle','icon'=>'bi-truck','route'=>'contact.v2.vehiclevendor.vehicle','count'=>$counts['vehicles']],
        ['key'=>'route','label'=>'Route','icon'=>'bi-signpost-split','route'=>'contact.v2.vehiclevendor.route','count'=>$counts['routes']],
        ['key'=>'documents','label'=>'Documents','icon'=>'bi-paperclip','route'=>'contact.v2.vehiclevendor.documents','count'=>$counts['documents']],
        ['key'=>'activity','label'=>'Activity','icon'=>'bi-clock-history','route'=>'contact.v2.vehiclevendor.activity','count'=>$counts['activity']],
    ];
@endphp

<div class="cv2-profile">
    <div class="cv2-profile-top">
        <div class="cv2-avatar is-lg">{{ strtoupper($initials) }}</div>
        <div class="cv2-profile-id">
            <h2>{{ $v['company'] }}
                <span class="cv2-badge {{ $statusClass }}"><span class="cv2-badge-dot"></span>{{ $v['status'] }}</span>
            </h2>
            <div class="cv2-profile-meta">
                <span><i class="bi bi-hash"></i>{{ $v['contactno'] }}</span>
                <span><i class="bi bi-person"></i>{{ $v['name'] }}</span>
                <span><i class="bi bi-upc-scan"></i>{{ $v['code'] }}</span>
                <span><i class="bi bi-truck"></i>{{ $v['vehicles'] }} vehicles</span>
                <span><i class="bi bi-telephone"></i>{{ $v['phone'] }}</span>
                <span><i class="bi bi-geo-alt"></i>{{ $v['city'] }}</span>
                <span class="cv2-rag {{ $ragClass }}">RAG: {{ $v['rag'] }}</span>
            </div>
        </div>
        <div class="cv2-profile-actions">
            <a href="{{ route('contact.v2.vehiclevendor.edit', $v['id']) }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-pencil"></i>Edit Info</a>
            <a href="{{ route('contact.v2.vehiclevendor.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-list-ul"></i>All Vendors</a>
        </div>
    </div>
    <nav class="cv2-subnav">
        @foreach($nav as $item)
            <a href="{{ route($item['route'], $v['id']) }}" class="{{ $active === $item['key'] ? 'is-active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>{{ $item['label'] }}
                @if(!is_null($item['count']))<span class="cv2-count">{{ $item['count'] }}</span>@endif
            </a>
        @endforeach
    </nav>
</div>
