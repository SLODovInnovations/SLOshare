@extends('layout.default')

@section('title')
    <title>Audits Log - {{ __('staff.staff-dashboard') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Audits Log - {{ __('staff.staff-dashboard') }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('staff.dashboard.index') }}" class="breadcrumb__link">
            {{ __('staff.staff-dashboard') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('staff.audit-log') }}
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="block">
            <h2><i class="{{ config('other.font-awesome') }} fa-list"></i> {{ __('staff.audit-log') }}</h2>
            <hr>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{ __('common.no') }}</th>
                        <th>{{ __('common.action') }}</th>
                        <th>Model</th>
                        <th>Model ID</th>
                        <th>By</th>
                        <th>Changes</th>
                        <th>{{ __('user.created-on') }}</th>
                        <th>{{ __('common.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($audits->count())
                        @foreach ($audits as $audit)
                            @php $values = json_decode($audit->record, true, 512, JSON_THROW_ON_ERROR) @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strtoupper($audit->action) }}</td>
                                <td>{{ $audit->model_name }}</td>
                                <td>{{ $audit->model_entry_id }}</td>
                                <td>
                                    <a href="{{ route('users.show', ['username' => $audit->user->username]) }}">
                                        {{ $audit->user->username }}
                                    </a>
                                </td>
                                <td>
                                    @foreach ($values as $key => $value)
                                        <span class="badge badge-extra">{{ $key }}:</span> {{ $value['old'] }} &rarr;
                                        {{ $value['new'] }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $audit->created_at->toDayDateTimeString() }}
                                    ({{ $audit->created_at->diffForHumans() }})
                                </td>
                                <td>
                                    <form action="{{ route('staff.audits.destroy', ['id' => $audit->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger">
                                            <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
