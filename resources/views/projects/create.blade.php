@extends('layouts.app')

@section('content')

    <h1>Create a Project</h1>

    <form action="/projects" method="post">
        @csrf

        <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input class="form-control" type="text" name="title" id="title">
        </div>

        <div class="form-group pt-4">
            <label for="exampleInputEmail1">Description</label>
            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
        </div>

        <div class="form-group pb-4">
            <small id="emailHelp" class="form-text text-muted">Title and Description are required.</small>
        </div>

        <button class="btn btn-primary" type="submit">Submit</button>
        <a href="/projects" class="btn btn-secondary">Cancel</a>
    </form>

@endsection
