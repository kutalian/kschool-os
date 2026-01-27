@extends('themes.talentupgrade.layout')

@section('title', $page->title . ' - ' . ($settings->school_name ?? 'School'))
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)

@section('content')
    <!-- Page Header -->
    <div class="container-fluid bg-primary mb-5 py-5">
        <div class="container py-5 text-center">
            <h1 class="display-3 text-white font-handlee mb-3 animate__animated animate__fadeInDown">{{ $page->title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 flex justify-center">
                    <li class="breadcrumb-item"><a class="text-white" href="/">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container mx-auto px-6 py-12 min-vh-50">
        <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12 prose max-w-none">
            {!! $page->content !!}
        </div>
    </div>
@endsection