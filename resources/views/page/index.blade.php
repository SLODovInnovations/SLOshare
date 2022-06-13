@extends('layout.default')

@section('breadcrumbs')
    <li class="breadcrumb--active">
        Pages
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="block">
            <h1 class="title">
                Pages
            </h1>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('common.name') }}</th>
                        <th>{{ __('common.create') }}</th>
                        <th>Updated</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                <a href="{{ route('pages.show', ['id' => $page->id]) }}">
                                    {{ $page->name }}
                                </a>
                            </td>
                            <td>
                                {{ $page->created_at }}
                            </td>
                            <td>
                                {{ $page->updated_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection