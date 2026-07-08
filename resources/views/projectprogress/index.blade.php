@extends('layouts.app')

@section('css')
<link href="{{ asset('css/ProjectProgress/index.css?v=1.4') }}" rel="stylesheet">
@endsection

@section('content')
@php
    // Title Case ENUM value -> CSS slug (used by [data-s] colour rules).
    $slug = ['Not Started' => 'not_started', 'In Design' => 'in_design', 'Design Done' => 'design_done', 'Approved' => 'approved'];
@endphp
<div class="layout-wrapper">
    @include('includes.header')

    <div class="wrapper srlog-bdwrapper">
        <div class="pp-fullwrap" data-csrf="{{ csrf_token() }}">

            {{-- ── Page head ─────────────────────────────────────────────── --}}
            <div class="pp-pagehead">
                <div>
                    <h4 class="pp-title">Project Progress</h4>
                    <p class="pp-sub">Phase-wise design status &amp; client sign-off board</p>
                </div>

                {{-- Overall project progress --}}
                <div class="pp-overall">
                    <span class="pp-overall-label">Overall</span>
                    <span class="pp-overall-bar"><span id="ppOverallBar" style="width: {{ $overall }}%;"></span></span>
                    <span class="pp-overall-pct" id="ppOverallPct">{{ $overall }}%</span>
                </div>

                {{-- Legend --}}
                <div class="pp-legend">
                    <span class="pp-legend-item"><i class="pp-dot" data-s="not_started"></i>Not Started</span>
                    <span class="pp-legend-item"><i class="pp-dot" data-s="in_design"></i>In Design</span>
                    <span class="pp-legend-item"><i class="pp-dot" data-s="design_done"></i>Design Done</span>
                    <span class="pp-legend-item"><i class="pp-dot" data-s="approved"></i>Approved</span>
                    <span class="pp-legend-item"><i class="uil uil-lock pp-legend-lock"></i>Frozen (one-way)</span>
                </div>
            </div>

            {{-- ── Horizontal progress timeline ─────────────────────────── --}}
            <div class="pp-timeline">
                <div class="pp-tl-track">
                    @foreach ($phases as $phase)
                        @php $p = $phase->progress(); @endphp
                        <a href="#pp-phase-{{ $phase->phase_no }}" class="pp-tl-node"
                           style="--phase-color: {{ $phase->color }};">
                            <span class="pp-tl-dot">{{ $phase->phase_no }}</span>
                            <span class="pp-tl-name">Phase {{ $phase->phase_no }}</span>
                            <span class="pp-tl-title">{{ $phase->title }}</span>
                            <span class="pp-tl-bar"><span data-phase-bar="{{ $phase->id }}" style="width: {{ $p }}%;"></span></span>
                            <span class="pp-tl-pct" data-phase-pct="{{ $phase->id }}">{{ $p }}%</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- ── Phases grid ──────────────────────────────────────────── --}}
            <div class="pp-grid">
                @foreach ($phases as $phase)
                    @php $p = $phase->progress(); @endphp
                    <section class="pp-phase {{ $phase->is_frozen ? 'is-frozen' : '' }}"
                             id="pp-phase-{{ $phase->phase_no }}" data-phase="{{ $phase->id }}"
                             style="--phase-color: {{ $phase->color }};">

                        {{-- Phase header --}}
                        <header class="pp-phase-head">
                            <span class="pp-phase-no">{{ $phase->phase_no }}</span>
                            <div class="pp-phase-heading">
                                <span class="pp-phase-kicker">Phase {{ $phase->phase_no }}</span>
                                <h5 class="pp-phase-title">{{ $phase->title }}</h5>
                            </div>

                            <span class="pp-phase-progress" data-phase-done="{{ $phase->id }}">{{ $p }}% done</span>

                            <div class="pp-freeze pp-phase-freezewrap" title="Freeze entire phase">
                                <span class="pp-freeze-label">Freeze phase</span>
                                <label class="pp-switch">
                                    <input type="checkbox" class="pp-phase-freeze"
                                           aria-label="Freeze phase {{ $phase->phase_no }}"
                                           data-phase="{{ $phase->id }}"
                                           data-phase-title="{{ $phase->title }}"
                                           disabled {{ $phase->is_frozen ? 'checked' : '' }}>
                                    <span class="pp-slider"></span>
                                </label>
                            </div>
                        </header>

                        {{-- Modules (grouped when a phase defines module groups) --}}
                        @php
                            $groups = $phase->modules->groupBy(fn ($m) => $m->group_name ?? '');
                        @endphp
                        @foreach ($groups as $groupName => $groupModules)
                            <div class="pp-group">
                                @if ($groupName !== '')
                                    <div class="pp-group-head">
                                        <span>{{ $groupName }}</span>
                                        <span class="pp-group-count">{{ $groupModules->count() }} modules</span>
                                    </div>
                                @endif

                                <div class="pp-modules">
                                    @foreach ($groupModules as $module)
                                        <article class="pp-module {{ $module->is_frozen ? 'is-frozen' : '' }}"
                                                 data-phase="{{ $phase->id }}"
                                                 data-module="{{ $module->id }}"
                                                 data-status="{{ $slug[$module->status] ?? 'not_started' }}">

                                            <div class="pp-module-top">
                                                <span class="pp-status-dot" data-s="{{ $slug[$module->status] ?? 'not_started' }}"></span>
                                                <span class="pp-module-name">{{ $module->name }}</span>
                                                <span class="pp-lock-badge"><i class="uil uil-lock"></i>Frozen</span>
                                            </div>

                                            <span class="pp-status-tag" data-s="{{ $slug[$module->status] ?? 'not_started' }}">
                                                {{ $module->status }}
                                            </span>

                                            {{-- Uploaded files --}}
                                            <div class="pp-filelist">
                                                @foreach ($module->files as $file)
                                                    <span class="pp-file-item" data-file="{{ $file->id }}">
                                                        <a href="{{ route('projectprogress.file.download', $file->id) }}"><i class="uil uil-file-alt"></i>{{ $file->original_name }}</a>
                                                        @unless ($module->is_frozen)
                                                            <button type="button" class="pp-file-remove" title="Remove"><i class="uil uil-times"></i></button>
                                                        @endunless
                                                    </span>
                                                @endforeach
                                            </div>

                                            <div class="pp-uploadrow">
                                                <label class="pp-file-label {{ $module->is_frozen ? 'is-disabled' : '' }}">
                                                    <i class="uil uil-import"></i><span>Upload file</span>
                                                    <input type="file" class="pp-file" hidden {{ $module->is_frozen ? 'disabled' : '' }}>
                                                </label>
                                                <span class="pp-file-name">No file chosen</span>
                                            </div>

                                            <label class="pp-approval">
                                                <input type="checkbox" class="pp-approval-check"
                                                       aria-label="Client approval for {{ $module->name }}"
                                                       {{ $module->client_approved ? 'checked' : '' }}
                                                       {{ $module->is_frozen ? 'disabled' : '' }}>
                                                <span>Client Approval</span>
                                            </label>

                                            <div class="pp-freeze pp-module-freezewrap" title="Freeze this module">
                                                <span class="pp-freeze-label">Freeze</span>
                                                <label class="pp-switch pp-switch-sm">
                                                    <input type="checkbox" class="pp-module-freeze"
                                                           aria-label="Freeze module {{ $module->name }}"
                                                           data-module-name="{{ $module->name }}"
                                                           disabled {{ $module->is_frozen ? 'checked' : '' }}>
                                                    <span class="pp-slider"></span>
                                                </label>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </section>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/ProjectProgress/index.js?v=1.3') }}"></script>
@endsection
