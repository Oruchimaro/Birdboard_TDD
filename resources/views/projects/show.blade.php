@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-gray-600 text-sm font-normal ">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects </a> / {{ $project->title }}
            </p>

            <a class="text-gray-600 button" href="/projects/create">New Project</a>
        </div>
    </header>



    <main>
        <div class="lg:flex -mx-3">


            <div class="w-3/4 px-3">

                <div class="mb-8">
                    <h2 class="text-grey-500 font-normal text-lg mb-3">Tasks</h2>
                    {{-- Tasks --}}
                    <div class="card mb-3">Task 1</div>
                    <div class="card mb-3">Task 2</div>
                    <div class="card mb-3">Task 3</div>
                    <div class="card ">Task 4</div>
                </div>

                <div>
                    <h2 class="text-grey-500 font-normal mb-3">General Notes</h2>

                    {{-- General Notes --}}
                    <textarea class="card w-full" style="min-height: 200px;"> Lorem Ipsum </textarea>
                </div>

            </div>




            <div class="w-1/4 px-3">

                @include('projects.card')

            </div>



        </div>
    </main>



@endsection
