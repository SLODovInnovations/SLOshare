@extends('layout.default')

@section('title')
    <title>Dodajte Forum - {{ __('staff.staff-dashboard') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Dodajte Forum - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('staff.dashboard.index') }}" class="breadcrumb__link">
            {{ __('staff.staff-dashboard') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('staff.forums.index') }}" class="breadcrumb__link">
            {{ __('staff.forums') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.new-adj') }}
    </li>
@endsection

@section('page', 'page__forums-admin--create')

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">Dodajte nov Forum</h2>
        <div class="panel__body">
            <form class="form" method="POST" action="{{ route('staff.forums.store') }}">
                @csrf
                <p class="form__group">
                    <select id ="forum_type" class="form__select" name="forum_type" required>
                        <option class="form__option" value="category">Kategorija</option>
                        <option class="form__option" value="forum">Forum</option>
                    </select>
                    <label class="form__label form__label--floating" for="forum_type">Vrsta Foruma</label>
                </p>
                <p class="form__group">
                    <input id="title" class="form__text" type="text" name="title" required>
                    <label class="form__label form__label--floating" for="title">Naslov</label>
                </p>
                <p class="form__group">
                    <textarea id="description" class="form__textarea" name="description" placeholder=""></textarea>
                    <label class="form__label form__label--floating" for="description">Opis</label>
                </p>
                <p class="form__group">
                    <select id="parent_id" class="form__select" name="parent_id" required>
                        <option value="0">Nova kategorija</option>
                        @foreach ($categories as $category)
                            <option class="form__option" value="{{ $category->id }}">
                                Nov Forum {{ $category->name }} Kategorija
                            </option>
                        @endforeach
                    </select>
                    <label class="form__label form__label--floating" for="parent_id">Forum za starše</label>
                </p>
                <p class="form__group">
                    <input
                        id="position"
                        class="form__text"
                        inputmode="numeric"
                        name="position"
                        pattern="[0-9]*"
                        placeholder=""
                        type="text"
                    >
                    <label class="form__label form__label--floating" for="position">{{ __('common.position') }}</label>
                </p>
                <p class="form__group">
                    <h3>Permissions</h3>
                    <div class="data-table-wrapper">
                        <table class="data-table">
                            <thead>
                            <tr>
                                <th>Skupine</th>
                                <th>Oglejte si forum</th>
                                <th>Preberite teme</th>
                                <th>Začni novo temo</th>
                                <th>Odgovorite na teme</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <th>{{ $group->name }}</th>
                                    <td><label>
                                            <input type="checkbox" name="permissions[{{ $group->id }}][show_forum]" value="1" checked>
                                        </label></td>
                                    <td><label>
                                            <input type="checkbox" name="permissions[{{ $group->id }}][read_topic]" value="1" checked>
                                        </label></td>
                                    <td><label>
                                            <input type="checkbox" name="permissions[{{ $group->id }}][start_topic]" value="1" checked>
                                        </label></td>
                                    <td><label>
                                            <input type="checkbox" name="permissions[{{ $group->id }}][reply_topic]" value="1" checked>
                                        </label></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </p>
                <p class="form__group">
                    <button class="form__button form__button--filled">Shrani Forum</button>
                </p>
            </form>
        </div>
    </section>
@endsection
