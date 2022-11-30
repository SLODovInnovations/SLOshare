@extends('layout.default')

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('staff.dashboard.index') }}" class="breadcrumb__link">
            {{ __('staff.staff-dashboard') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('staff.homevideos.index') }}" class="breadcrumb__link">
            Home Video
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.edit') }}
    </li>
@endsection

@section('main')
    <section class="panelV2">
        <h2 class="panel__heading">
            {{ __('common.edit') }}
        </h2>
        <div class="panel__body">
            <form
                    name="upload"
                    class="upload-form form"
                    id="upload-form"
                    method="POST"
                    action="{{ route('staff.homevideos.update', ['id' => $client->id]) }}"
            >
                @csrf
                @method('patch')
                <p class="form__group">
                    <input
                            type="text"
                            name="name"
                            id="name"
                            class="form__text"
                            value="{{ $client->name }}"
                            required
                    >
                    <label class="form__label form__label--floating" for="name">{{ __('common.name') }}</label>
                </p>
                <p class="form__group">
                    <input
                            type="text"
                            name="link"
                            id="link"
                            class="form__text"
                            value="{{ $client->link }}"
                    >
                    <label class="form__label form__label--floating" for="link">
                        {{ __('common.link') }}
                    </label>
                </p>
                <p class="form__group">
                    <button class="form__button form__button--filled">
                        {{ __('common.submit') }}
                    </button>
                </p>
            </form>
        </div>
    </section>
@endsection