@extends('layouts.app')

@section('content')
    @livewire('course-show', ['slug' => $course->slug])
@endsection