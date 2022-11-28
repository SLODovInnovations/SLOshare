        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="text-center">
                    <div class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" style="color:#ffffff;">
                        <i class="{{ config('other.font-awesome') }} fa-chart-pie"></i> {{ __('poll.poll') }}
                    </div>
                </h4>
            </div>
            <div class="panel-body">
            <h2 class="panel__heading">{{ $poll->title }}</h2>
            @php($total = $poll->options->sum('votes'))
            @foreach ($poll->options as $option)
                <p class="form__group">
                    <label class="form__label" for="option{{ $loop->iteration }}">
                        {{ $option->name }} ({{ \number_format($total === 0 ? 0 : 100 * $option->votes / $total, 2) }}%)
                    </label>
                    <meter
                        id="option{{ $loop->iteration }}"
                        class="form__meter"
                        min="0"
                        max="{{ $total }}"
                        value="{{ $option->votes }}"
						style="color: var(--color-magenta)!important;"
                    >
                        {{ $option->votes }} {{ $option->votes === 1 ? __('poll.vote') : __('poll.votes') }}
                    </meter>
                </p>
            @endforeach
            </div>
        </div>