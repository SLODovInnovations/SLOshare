<aside id="hoe-left-panel" hoe-position-type="fixed">
    <ul class="nav panel-list">


        <li class="nav-level">{{ __('common.navigation') }}</li>

        <li>
            <a href="{{ route('home.index') }}">
                <i class="{{ config('other.font-awesome') }} fa-home" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('common.home') }}</span>
                <span class="selected"></span>
            </a>
        </li>


        <li>
            <a href="{{ route('torrents') }}">
                <i class="{{ config('other.font-awesome') }} fa-search" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('torrent.torrents') }}</span>
                <span class="selected"></span>
            </a>
        </li>
        <li>
            <a href="{{ route('requests.index') }}">
                <i class="{{ config('other.font-awesome') }} fa-praying-hands" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('request.requests') }}</span>
                <span class="selected"></span>
            </a>
        </li>
        <li>
            <a href="{{ route('mediahub.index') }}">
                <i class="{{ config('other.font-awesome') }} fa-photo-video" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">MediaHub</span>
                <span class="selected"></span>
            </a>
        </li>
        <li>
            <a href="{{ route('subtitles.index') }}">
                <i class="{{ config('other.font-awesome') }} fa-closed-captioning" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('common.subtitles') }}</span>
                <span class="selected"></span>
            </a>
        </li>
@if (auth()->user()->group->is_admin)
        <li>
            <a href="{{ route('graveyard.index') }}">
                <i class="{{ config('other.font-awesome') }} fa-upload" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('graveyard.graveyard') }}</span>
                <span class="selected"></span>
            </a>
        </li>
@endif


@if (auth()->user()->group->can_upload)
        <li class="hoe-has-menu">
            <a>
                <i class="{{ config('other.font-awesome') }} fa-upload" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('common.publish') }}</span>
                <span class="selected"></span>
            </a>
            <ul class="hoe-sub-menu">
                @php $categories = App\Models\Category::all() @endphp
                @foreach($categories as $category)
                    <li>
                        <a href="{{ route('upload_form', ['category_id' => $category->id]) }}">
                            <span class="menu-text">{{ $category->name }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
@endif


        <li class="hoe-has-menu">
            <a>
                <i class="{{ config('other.font-awesome') }} fa-user" style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('common.other') }}</span>
                <span class="selected"></span>
            </a>
            <ul class="hoe-sub-menu">

@if (auth()->user()->group->is_admin)
                <li>
                    <a href="{{ route('playlists.index') }}">
                        <span class="menu-text">Playlists</span>
                        <span class="selected"></span>
                    </a>
                </li>
@endif

@if (auth()->user()->group->is_admin)
                <li>
                    <a href="{{ route('albums.index') }}">
                        <span class="menu-text">{{ __('common.gallery') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
@endif

@if (auth()->user()->group->is_admin)
                <li>
                    <a href="{{ route('stats') }}">
                        <span class="menu-text">{{ __('common.extra-stats') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
@endif

                <li>
                    <a href="{{ route('polls') }}">
                        <span class="menu-text">{{ __('poll.polls') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>

@if (auth()->user()->group->is_admin)
                <li>
                    <a href="{{ route('bonus_store') }}">
                        <span class="menu-text">{{ __('bon.bon') }} {{ __('bon.store') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
@endif

                <li>
                    <a href="{{ route('forums.index') }}">
                        <span class="menu-text">{{ __('forum.forums') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>

@if (auth()->user()->group->is_admin)
                <li>
                    <a href="{{ route('rss.index') }}">
                        <span class="menu-text">{{ __('rss.rss') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
@endif

            </ul>
        </li>


        <li>
            <a href="{{ route('policys') }}">
                <i class="{{ config('other.font-awesome') }} fa-info-square"
                   style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('common.rules') }}</span>
                <span class="selected"></span>
            </a>
        </li>
        <li>
            <a href="{{ route('faqs') }}">
                <i class="{{ config('other.font-awesome') }} fa-question-square"
                   style=" font-size: 18px; color: #ffffff;"></i>
                <span class="menu-text">{{ __('common.faq') }}</span>
                <span class="selected"></span>
            </a>
        </li>
        @if (auth()->user()->group->is_admin)
            <li>
                <a href="{{ route('staff.dashboard.index') }}">
                    <i class="{{ config('other.font-awesome') }} fa-cogs" style=" font-size: 18px; color: #ffffff;"></i>
                    <span class="menu-text">{{ __('staff.staff-dashboard') }}</span>
                    <span class="selected"></span>
                </a>
            </li>
        @endif
    </ul>
</aside>
