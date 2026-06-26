{{-- Trip show-v2 — vehStatus tab content (extracted partial) --}}
<div class="td2-pane-header">
    <h5 class="td2-pane-title">Vehicle Status</h5>
</div>
<div class="td2-pane-body">

    {{-- SECTION 0 - Status Overview (at-a-glance KPIs) --}}
    <div class="td2-vs-overview">
        <div class="td2-vs-stat td2-vs-stat-status">
            <span class="td2-vs-stat-icon td2-vs-icon-navy"><i class="uil uil-truck"></i></span>
            <div class="td2-vs-stat-body">
                <span class="td2-vs-stat-label">Current Status</span>
                <span class="td2-vs-stat-value">Unloading at Mumbai</span>
            </div>
        </div>
        <div class="td2-vs-stat">
            <span class="td2-vs-stat-icon td2-vs-icon-blue"><i class="uil uil-map-marker"></i></span>
            <div class="td2-vs-stat-body">
                <span class="td2-vs-stat-label">Last GPS Update</span>
                <span class="td2-vs-stat-value">22/12/2025 · 09:00 AM</span>
            </div>
        </div>
        <div class="td2-vs-stat">
            <span class="td2-vs-stat-icon td2-vs-icon-green"><i class="uil uil-location-arrow"></i></span>
            <div class="td2-vs-stat-body">
                <span class="td2-vs-stat-label">Route Distance</span>
                <span class="td2-vs-stat-value">2,465 KM</span>
            </div>
        </div>
        <div class="td2-vs-stat">
            <span class="td2-vs-stat-icon td2-vs-icon-amber"><i class="uil uil-clock"></i></span>
            <div class="td2-vs-stat-body">
                <span class="td2-vs-stat-label">Total Halting</span>
                <span class="td2-vs-stat-value">1 Day <small class="td2-vs-stat-note">&gt; 24 hrs chargeable</small></span>
            </div>
        </div>
    </div>

    {{-- SECTION 1 - Current Status (moved above Route Summary) --}}
    <div class="td2-docs-section">
        <div class="td2-docs-header">
            <p class="td2-docs-title"><i class="uil uil-info-circle td2-docs-ico"></i> Current Status</p>
        </div>
        <div class="td2-vstatus-current">
            <span class="td2-vstatus-cur-dot"></span>
            <span class="td2-vstatus-cur-label">Current Status</span>
            <span class="td2-vstatus-cur-badge">Unloading at Mumbai</span>
            {{-- Paused badge — visible only while the trip is paused (body.td2-trip-paused) --}}
            <span class="td2-vstatus-paused-badge"><i class="uil uil-pause-circle"></i> Paused</span>
            <span class="td2-vstatus-cur-meta"><i class="uil uil-clock"></i> Updated 22/12/2025 · 09:00 AM</span>
            {{-- Resume Trip — visible only while paused; opens the Resume page --}}
            <a href="{{ route('trip.resume', $trip) }}" class="td2-vstatus-resume-btn">
                <i class="uil uil-play-circle"></i> Resume Trip
            </a>
            <a class="td2-vstage-change" id="td2UpdateStatusLink"
                data-bs-toggle="modal"
                data-bs-target="#changeStatus">Update Status</a>
            {{-- Lock note — shown only while paused (Update Status is disabled) --}}
            <span class="td2-vstatus-lock-note"><i class="uil uil-lock"></i> Locked while paused</span>
        </div>
    </div>

    {{-- SECTION 2 - Route Summary --}}
    <div class="td2-docs-section">
        <div class="td2-docs-header">
            <p class="td2-docs-title"><i class="uil uil-location-point td2-docs-ico"></i> Route Summary</p>
        </div>
        <div class="td2-route-summary">

            {{-- Source --}}
            <div class="td2-route-point">
                <span class="td2-route-dot td2-route-dot-source"></span>
                <span class="td2-route-loc">Kolkata</span>
                <span class="td2-route-type td2-route-type-load">Source &middot; Loading Point</span>
            </div>
            <i class="uil uil-angle-right-b td2-route-arrow"></i>

            {{-- Mid Point 1 - Loading and Unloading both --}}
            <div class="td2-route-point">
                <span class="td2-route-dot td2-route-dot-mid"></span>
                <span class="td2-route-loc">Kolaghat</span>
                <span class="td2-route-type td2-route-type-both">Midpoint &middot; Load &amp; Unload</span>
            </div>
            <i class="uil uil-angle-right-b td2-route-arrow"></i>

            {{-- Mid Point 2 - Loading --}}
            <div class="td2-route-point">
                <span class="td2-route-dot td2-route-dot-mid"></span>
                <span class="td2-route-loc">Patna</span>
                <span class="td2-route-type td2-route-type-load">Midpoint &middot; Loading</span>
            </div>
            <i class="uil uil-angle-right-b td2-route-arrow"></i>

            {{-- Destination --}}
            <div class="td2-route-point td2-route-point-active">
                <span class="td2-route-dot td2-route-dot-dest"></span>
                <span class="td2-route-loc">Mumbai</span>
                <span class="td2-route-type td2-route-type-unload">Destination &middot; Unloading Point</span>
                <span class="td2-route-here">You are here</span>
            </div>

        </div>
    </div>

    {{-- SECTION 3 - Map View (route path + all points) --}}
    <div class="td2-docs-section">
        <div class="td2-docs-header">
            <p class="td2-docs-title"><i class="uil uil-map td2-docs-ico"></i> Route Map</p>
        </div>
        <div class="td2-map-embed">
            <div class="td2-map-proto-badge">
                <i class="fa fa-map-marker"></i> Route &mdash; Kolkata &rarr; Kolaghat &rarr; Patna &rarr; Mumbai
                <span class="td2-map-proto-tag">Live Tracking</span>
            </div>
            <iframe
                src="https://maps.google.com/maps?saddr=Kolkata,West+Bengal&daddr=Kolaghat,West+Bengal+to:Patna,Bihar+to:Mumbai,Maharashtra&output=embed"
                width="100%" height="320" frameborder="0"
                style="border:0;" allowfullscreen="" loading="lazy"
                title="Trip Route Map"></iframe>
            <div class="td2-route-legend">
                <span class="td2-route-legend-item"><span class="td2-route-legend-dot td2-route-dot-source"></span> Source &mdash; Kolkata</span>
                <span class="td2-route-legend-item"><span class="td2-route-legend-dot td2-route-dot-mid"></span> Midpoint &mdash; Kolaghat</span>
                <span class="td2-route-legend-item"><span class="td2-route-legend-dot td2-route-dot-mid"></span> Midpoint &mdash; Patna</span>
                <span class="td2-route-legend-item"><span class="td2-route-legend-dot td2-route-dot-halt"></span> Halt &mdash; Dhanbad (en route)</span>
                <span class="td2-route-legend-item"><span class="td2-route-legend-dot td2-route-dot-dest"></span> Destination &mdash; Mumbai</span>
            </div>
        </div>
    </div>

    {{-- SECTION 4 - Status Timeline --}}
    <div class="td2-docs-section">
        <div class="td2-docs-header">
            <p class="td2-docs-title"><i class="uil uil-history td2-docs-ico"></i> Status Timeline</p>
        </div>
        <div class="td2-tl" id="td2StatusTimeline">

            {{-- Loading at Source --}}
            <div class="td2-tl-item td2-tl-done">
                <span class="td2-tl-marker td2-tl-marker-load"><i class="uil uil-import"></i></span>
                <div class="td2-tl-body">
                    <div class="td2-tl-head">
                        <span class="td2-tl-title">Loading at <span class="td2-tl-loc">Kolkata</span></span>
                        <span class="td2-tl-time">20/12/2025 &middot; 10:00 AM</span>
                    </div>
                    <p class="td2-tl-note">Consignment loaded at the source loading point. Timestamp captured automatically via GPS.</p>
                </div>
            </div>

            {{-- Unloading at Mid (Kolaghat) --}}
            <div class="td2-tl-item td2-tl-done">
                <span class="td2-tl-marker td2-tl-marker-unload"><i class="uil uil-export"></i></span>
                <div class="td2-tl-body">
                    <div class="td2-tl-head">
                        <span class="td2-tl-title">Unloading at <span class="td2-tl-loc">Kolaghat</span></span>
                        <span class="td2-tl-time">20/12/2025 &middot; 02:30 PM</span>
                    </div>
                    <p class="td2-tl-note">Consignment partially unloaded at the midpoint. Timestamp captured automatically via GPS.</p>
                </div>
            </div>

            {{-- Loading at Mid (Kolaghat) --}}
            <div class="td2-tl-item td2-tl-done">
                <span class="td2-tl-marker td2-tl-marker-load"><i class="uil uil-import"></i></span>
                <div class="td2-tl-body">
                    <div class="td2-tl-head">
                        <span class="td2-tl-title">Loading at <span class="td2-tl-loc">Kolaghat</span></span>
                        <span class="td2-tl-time">20/12/2025 &middot; 04:00 PM</span>
                    </div>
                    <p class="td2-tl-note">Consignment loaded at the midpoint. Timestamp captured automatically via GPS.</p>
                </div>
            </div>

            {{-- Halt - can occur at ANY location between source and destination --}}
            <div class="td2-tl-item td2-tl-done">
                <span class="td2-tl-marker td2-tl-marker-halt"><i class="uil uil-clock"></i></span>
                <div class="td2-tl-body">
                    <div class="td2-tl-head">
                        <span class="td2-tl-title">Halt at <span class="td2-tl-loc">Dhanbad</span> <small class="fw-normal text-muted">(en route)</small> <span class="td2-tl-badge">1 Day</span></span>
                        <span class="td2-tl-time">20/12/2025 &middot; 11:00 PM</span>
                    </div>
                    <p class="td2-tl-note">Vehicle halted en route. A halt may occur at any location between the source and destination. Halting charges apply when the halt exceeds 24 hours.</p>
                </div>
            </div>

            {{-- Loading at Mid (Patna) --}}
            <div class="td2-tl-item td2-tl-done">
                <span class="td2-tl-marker td2-tl-marker-load"><i class="uil uil-import"></i></span>
                <div class="td2-tl-body">
                    <div class="td2-tl-head">
                        <span class="td2-tl-title">Loading at <span class="td2-tl-loc">Patna</span></span>
                        <span class="td2-tl-time">22/12/2025 &middot; 09:00 AM</span>
                    </div>
                    <p class="td2-tl-note">Consignment loaded at the midpoint. Timestamp captured automatically via GPS.</p>
                </div>
            </div>

            {{-- Unloading at Destination (Mumbai) --}}
            <div class="td2-tl-item td2-tl-done">
                <span class="td2-tl-marker td2-tl-marker-unload"><i class="uil uil-export"></i></span>
                <div class="td2-tl-body">
                    <div class="td2-tl-head">
                        <span class="td2-tl-title">Unloading at <span class="td2-tl-loc">Mumbai</span></span>
                        <span class="td2-tl-time">23/12/2025 &middot; 10:00 AM</span>
                    </div>
                    <p class="td2-tl-note">Consignment unloaded at the destination. Timestamp captured automatically via GPS.</p>
                </div>
            </div>

        </div>{{-- /.td2-tl --}}
    </div>

    {{-- SECTION 5 - Halting Summary --}}
    <div class="td2-docs-section">
        <div class="td2-halting-summary">
            <span class="td2-halting-icon"><i class="uil uil-clock"></i></span>
            <div class="td2-halting-text">
                <span class="td2-halting-label">Total Halting</span>
                <span class="td2-halting-val">1 Day</span>
            </div>
            <span class="td2-halting-note">Auto-calculated from halt events along the route. Halting charges apply when the total halt exceeds 24 hours.</span>
        </div>
    </div>

</div>{{-- /.td2-pane-body --}}
