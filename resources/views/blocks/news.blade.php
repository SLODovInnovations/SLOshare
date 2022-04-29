<div class="col-md-3 col-sm-3-slo col-md-bl-1 col-slo">
@foreach ($articles as $article)
            <div class="panel panel-danger">
                <div class="nav nav-tabs-user">
                    <h4 class="text-center">
                        <a href="{{ route('articles.show', ['id' => $article->id]) }}">
                            @joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($article->title), 21))
                        </a>
                    </h4>
                </div>
                <div aria-expanded="{{ ($article->newNews ? 'true' : 'false') }}" id="collapse4"
                    class="panel-collapse collapse {{ ($article->newNews ? 'in' : '') }}"
                    style="{{ ($article->newNews ? '' : 'height: 0;') }}">
                    <div class="panel-body no-padding">
                        <p class="text-muted">
                            <em>{{ __('articles.published-at') }}
                                {{ date('d.m.Y', $article->created_at->getTimestamp()) }} | {{ date('H:m:s', $article->created_at->getTimestamp()) }}
                            </em>
                        </p>
                        <div class="news-blocks">
                            <a href="{{ route('articles.show', ['id' => $article->id]) }}"
                                style=" float: right; margin-right: 10px;">
                                @if ( ! is_null($article->image))
                                    <img src="{{ url('files/img/' . $article->image) }}"
                                        alt="{{ $article->title }}">
                                @else
                                    <img src="{{ url('img/missing-image.png') }}" alt="{{ $article->title }}">
                                @endif
                            </a>

                            <p style="margin-top: 20px;">
                                @joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($article->content), 150))
                            </p>

                            <a href="{{ route('articles.show', ['id' => $article->id]) }}" class="btn btn-success">
                                {{ __('articles.read-more') }}
                            </a>
<!-- SLOshare -->
@if (auth()->user()->group->is_admin)
                                    <div class="pull-right">
                                        <a href="{{ route('articles.index') }}" class="btn btn-primary">
                                            {{ __('common.view-all') }}
                                        </a>
                                    </div>
@endif
<!-- SLOshare -->
                                </div>
                            </div>
                        </div>
                    </div>
@endforeach
