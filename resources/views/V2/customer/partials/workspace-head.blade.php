{{-- Customer V2 workspace header: profile banner + submodule page navigation.
     Each submodule is its OWN page (not a tab). Expects: $c, $active, $counts --}}
@php
    $initials = collect(explode(' ', $c['name']))->map(fn($w)=>mb_substr($w,0,1))->take(2)->implode('');
    $statusClass = ['Active'=>'is-active','Inactive'=>'is-inactive','Blacklisted'=>'is-black'][$c['status']] ?? 'is-inactive';
    $nav = [
        ['key'=>'overview','label'=>'Overview','icon'=>'bi-grid','route'=>'contact.v2.customer.show','count'=>null],
        ['key'=>'contracts','label'=>'Contract','icon'=>'bi-file-earmark-text','route'=>'contact.v2.customer.contracts','count'=>$counts['contracts']],
        ['key'=>'locations','label'=>'Location','icon'=>'bi-geo-alt','route'=>'contact.v2.customer.locations','count'=>$counts['locations']],
        ['key'=>'ratechart','label'=>'Rate Chart','icon'=>'bi-cash-stack','route'=>'contact.v2.customer.ratechart','count'=>$counts['ratecharts']],
        ['key'=>'vehicles','label'=>'Vehicle Allocation','icon'=>'bi-truck','route'=>'contact.v2.customer.vehicles','count'=>$counts['vehicles']],
        ['key'=>'documents','label'=>'Documents','icon'=>'bi-paperclip','route'=>'contact.v2.customer.documents','count'=>$counts['documents']],
        ['key'=>'activity','label'=>'Activity','icon'=>'bi-clock-history','route'=>'contact.v2.customer.activity','count'=>$counts['activity']],
    ];
@endphp

<div class="cv2-profile">
    <div class="cv2-profile-top">
        <div class="cv2-avatar is-lg">{{ strtoupper($initials) }}</div>
        <div class="cv2-profile-id">
            <h2>{{ $c['name'] }}
                <span class="cv2-badge {{ $statusClass }}"><span class="cv2-badge-dot"></span>{{ $c['status'] }}</span>
            </h2>
            <div class="cv2-profile-meta">
                <span><i class="bi bi-hash"></i>{{ $c['contactno'] }}</span>
                <span><i class="bi bi-tag"></i>{{ $c['type'] }}</span>
                <span><i class="bi bi-bounding-box"></i>{{ $c['size'] }}</span>
                <span><i class="bi bi-telephone"></i>{{ $c['phone'] }}</span>
                <span><i class="bi bi-envelope"></i>{{ $c['email'] }}</span>
                <span><i class="bi bi-geo-alt"></i>{{ $c['city'] }}</span>
            </div>
        </div>
        <div class="cv2-profile-actions">
            <a href="{{ route('contact.v2.customer.edit', $c['id']) }}" class="cv2-btn cv2-btn-ghost"><i class="bi bi-pencil"></i>Edit Info</a>
            <a href="{{ route('contact.v2.customer.index') }}" class="cv2-btn cv2-btn-soft"><i class="bi bi-list-ul"></i>All Customers</a>
        </div>
    </div>
    <nav class="cv2-subnav">
        @foreach($nav as $item)
            <a href="{{ route($item['route'], $c['id']) }}" class="{{ $active === $item['key'] ? 'is-active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>{{ $item['label'] }}
                @if(!is_null($item['count']))<span class="cv2-count">{{ $item['count'] }}</span>@endif
            </a>
        @endforeach
    </nav>
</div>
