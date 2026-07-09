{{-- Document Dashboard — shared "View Details" modal (static; history of a document category for one vehicle) --}}
{{-- Params: modalId, docLabel, vehicle, owner, agent, curStart (d-m-Y), curEnd (d-m-Y) --}}
@php
    $fmt = 'd-m-Y';
    $s0 = \DateTime::createFromFormat($fmt, $curStart);
    $e0 = \DateTime::createFromFormat($fmt, $curEnd);
    $span = ($s0 && $e0) ? max(1, (int) $s0->diff($e0)->y) : 1;
    $modes = ['UPI', 'NEFT', 'Cheque', 'Cash'];
    $records = [];
    for ($k = 0; $k < 4; $k++) {
        $s = clone $s0; $s->modify('-' . ($span * $k) . ' years');
        $e = clone $e0; $e->modify('-' . ($span * $k) . ' years');
        $records[] = [
            'start'       => $s->format($fmt),
            'end'         => $e->format($fmt),
            'current'     => $k === 0,
            'rto_fees'    => 6000 - $k * 300,
            'agent_fees'  => 1500 - $k * 100,
            'agent'       => $agent,
            'mode'        => $modes[$k % count($modes)],
            'pay_date'    => $s->format($fmt),
            'pr'          => 'PR-' . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $docLabel), 0, 3)) . '-' . (50120 - $k * 137),
            'attachments' => [$docLabel . ' Certificate.pdf', 'Payment Receipt.pdf'],
        ];
    }
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content docd-dtl-modal">

      <div class="modal-header">
        <div>
          <h6 class="modal-title">{{ $docLabel }} History — <span class="docd-dtl-reg">{{ $vehicle }}</span></h6>
          <div class="docd-dtl-sub"><i class="uil uil-user"></i> {{ $owner }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <div class="docd-dtl-current">
          <i class="uil uil-shield-check"></i>
          <span>Current {{ $docLabel }}: <strong>{{ $curStart }} to {{ $curEnd }}</strong></span>
        </div>

        <div class="docd-dtl-history-label"><i class="uil uil-history"></i> Document History</div>

        <div class="accordion docd-dtl-accordion" id="{{ $modalId }}Acc">
          @foreach($records as $k => $rec)
          <div class="accordion-item">
            <h2 class="accordion-header" id="{{ $modalId }}H{{ $k }}">
              <button class="accordion-button {{ $k === 0 ? '' : 'collapsed' }}" type="button"
                      data-bs-toggle="collapse" data-bs-target="#{{ $modalId }}C{{ $k }}"
                      aria-expanded="{{ $k === 0 ? 'true' : 'false' }}" aria-controls="{{ $modalId }}C{{ $k }}">
                <span class="docd-dtl-period">{{ $rec['start'] }} &ndash; {{ $rec['end'] }}</span>
                @if($rec['current'])
                  <span class="docd-dtl-badge docd-dtl-badge-current">Current</span>
                @else
                  <span class="docd-dtl-badge docd-dtl-badge-expired">Expired</span>
                @endif
              </button>
            </h2>
            <div id="{{ $modalId }}C{{ $k }}" class="accordion-collapse collapse {{ $k === 0 ? 'show' : '' }}"
                 aria-labelledby="{{ $modalId }}H{{ $k }}" data-bs-parent="#{{ $modalId }}Acc">
              <div class="accordion-body">
                <div class="docd-dtl-grid">
                  <div class="docd-dtl-cell"><span class="docd-dtl-k">RTO Fees</span><span class="docd-dtl-v">&#8377;{{ number_format($rec['rto_fees']) }}</span></div>
                  <div class="docd-dtl-cell"><span class="docd-dtl-k">Agent Fees</span><span class="docd-dtl-v">&#8377;{{ number_format($rec['agent_fees']) }}</span></div>
                  <div class="docd-dtl-cell"><span class="docd-dtl-k">Agent Name</span><span class="docd-dtl-v">{{ $rec['agent'] }}</span></div>
                  <div class="docd-dtl-cell"><span class="docd-dtl-k">Payment Mode</span><span class="docd-dtl-v">{{ $rec['mode'] }}</span></div>
                  <div class="docd-dtl-cell"><span class="docd-dtl-k">Payment Date</span><span class="docd-dtl-v">{{ $rec['pay_date'] }}</span></div>
                  <div class="docd-dtl-cell"><span class="docd-dtl-k">PR Number</span><span class="docd-dtl-v">{{ $rec['pr'] }}</span></div>
                </div>
                <div class="docd-dtl-attachments">
                  <span class="docd-dtl-k">Attached Documents</span>
                  <div class="docd-dtl-files">
                    @foreach($rec['attachments'] as $file)
                    <a href="javascript:void(0)" class="docd-dtl-file"><i class="uil uil-paperclip"></i> {{ $file }}</a>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>

      </div>
    </div>
  </div>
</div>
