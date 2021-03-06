@extends('layout.default')

@section('title')
    <title>Polls - {{ config('other.title') }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('staff.dashboard.index') }}" class="breadcrumb__link">
            {{ __('staff.staff-dashboard') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('poll.polls') }}
    </li>
@endsection

@section('content')
    <div class="container box">
        <h2>{{ __('poll.poll') }}</h2>
        <a href="{{ route('staff.polls.create') }}" class="btn btn-primary">
            {{ __('common.add') }}
            {{ trans_choice('common.a-an-art',false) }}
            {{ __('poll.poll') }}
        </a>
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>{{ __('poll.title') }}</th>
                    <th>{{ __('common.date') }}</th>
                    <th>{{ __('common.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($polls as $poll)
                    <tr>
                        <td><a href="{{ route('staff.polls.show', ['id' => $poll->id]) }}">{{ $poll->title }}</a></td>
                        <td>{{ date('d M Y', $poll->created_at->getTimestamp()) }}</td>
                        <td>
                            <form action="{{ route('staff.polls.destroy', ['id' => $poll->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('staff.polls.edit', ['id' => $poll->id]) }}"
                                   class="btn btn-warning">{{ __('common.edit') }}</a>
                                <button type="submit" class="btn btn-danger">{{ __('common.delete') }}</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
