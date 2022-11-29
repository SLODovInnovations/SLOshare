            @php($total = $poll->options->sum('votes') ?? 'aa')
            @foreach ($poll->options as $option)
                <h2 class="panel__heading">{{ $poll->title }}</h2>
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