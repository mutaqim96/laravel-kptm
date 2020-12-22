@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Training') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('training:store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Trainer</label>
                            <input type="text" name="trainer" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Trainer</label>
                            <input type="file" name="attachment" class="form-control" enctype="multipart/form-data">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Store My Training</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
