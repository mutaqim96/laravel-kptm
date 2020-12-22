@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Training Index') }}</div>

                <div class="card-body">
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Creator</th>
                                <th>Created At</th>
                                <th>Created DateTime</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trainings as $training)
                                <tr>
                                    <td>{{ $training->id }}</td>
                                    <td>{{ $training->title }}</td>
                                    <td>{{ $training->description }}</td>
                                    <td>
                                        {{ $training->user ? $training->user->name : 'no user' }}
                                        <strong>
                                            ({{$training->user ? $training->user->email : 'no email' }})
                                        </strong>
                                    </td>
                                    <td>{{ $training->created_at ? $training->created_at->diffForHumans() : 'NO DATA' }}</td>
                                    <td>{{ $training->created_at ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('training:show', $training) }}" class="btn btn-primary">View</a>
                                        <a href="{{ route('training:edit', $training) }}" class="btn btn-success">Edit</a>
                                        <a onclick="return confirm('Are you sure?')" href="{{ route('training:delete', $training) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $trainings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
