@extends('layouts.app')

@php
    $latestJam = config('gamejam.latest_jam', '2024');
    $votingActive = (bool) config('gamejam.voting.active', false);
    $votingUrl = config('gamejam.voting.url', '');
    $nextJam = config('gamejam.registration.next_jam');
    $registrationActive = (bool) config('gamejam.registration.active', false);
    $registrationUrl = config('gamejam.registration.url', '');

    $homepage = \App\GameJamData::getHomepage();
    $about = $homepage['about'] ?? [];
    $video = $homepage['video'] ?? [];
    $sponsors = $homepage['sponsors'] ?? [];
@endphp

<!-- Hero Section with Slider -->
@section('header')
<section class="relative h-full flex items-center justify-center overflow-hidden">
    <div class="hero-slider-container absolute inset-0 w-full h-full z-0">
        <div class="hero-slider-track relative w-full h-full">
            <div class="hero-slide active" data-slide="0" style="background-image: url('/media/gamejam_index_1.jpg');"></div>
            <div class="hero-slide" data-slide="1" style="background-image: url('/media/gamejam_index_2.jpg');"></div>
            <div class="hero-slide" data-slide="2" style="background-image: url('/media/gamejam_index_3.jpg');"></div>
        </div>
        <div class="absolute inset-0 flex items-center justify-center z-20 pointer-events-none">
            <div class="container mx-auto px-4 text-center text-white drop-shadow-lg">
                <span class="text-lg md:text-xl mb-4 block">Developing Games In No Time Since 2011</span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-8">Hagenberg Game Jam</h1>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/{{ $latestJam }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors pointer-events-auto">
                        View the games of {{ $latestJam }}
                    </a>
                    @if($votingActive)
                    <a href="{{ $votingUrl }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors pointer-events-auto">
                        Vote for the games of {{ $latestJam }}
                    </a>
                    @endif
                    @if($registrationActive && $nextJam)
                    <a href="{{ $registrationUrl }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors pointer-events-auto">
                        Register for {{ $nextJam }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')

<!-- Categories Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Category 1 -->
            <div class="bg-white dark:bg-gray-700 p-8 rounded-lg shadow-lg text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="w-3 h-3 mx-auto mb-4 bg-indigo-600 rounded-full"></div>
                <h3 class="text-2xl font-bold mb-4 dark:text-white">1 Topic</h3>
                <p class="text-gray-600 dark:text-gray-300">Each Hagenberg Game Jam follows a single topic, often related to current events.</p>
            </div>

            <!-- Category 2 -->
            <div class="bg-white dark:bg-gray-700 p-8 rounded-lg shadow-lg text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="w-3 h-3 mx-auto mb-4 bg-indigo-600 rounded-full"></div>
                <h3 class="text-2xl font-bold mb-4 dark:text-white">36 Hours</h3>
                <p class="text-gray-600 dark:text-gray-300">From Saturday, 9 am to Sunday, 9 pm: there are only 36 hours available to create a game.</p>
            </div>

            <!-- Category 3 -->
            <div class="bg-white dark:bg-gray-700 p-8 rounded-lg shadow-lg text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="w-3 h-3 mx-auto mb-4 bg-indigo-600 rounded-full"></div>
                <h3 class="text-2xl font-bold mb-4 dark:text-white">&infin; Ideas</h3>
                <p class="text-gray-600 dark:text-gray-300">Perfection isn't usually the essential quality in a game jam. Great ideas are.</p>
            </div>
        </div>
    </div>
                </section>

<!-- About Section -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                @php
                    $aboutImage = (string) ($about['image'] ?? 'gamejam_about.png');
                    $aboutImageSrc = ($aboutImage !== '' && str_starts_with($aboutImage, '/')) ? $aboutImage : '/media/' . ltrim($aboutImage, '/');
                @endphp
                <img src="{{ $aboutImageSrc }}" alt="Scenes from the Hagenberg Game Jam" class="rounded-lg shadow-lg w-full">
            </div>
            <div class="order-1 lg:order-2">
                <span class="inline-block w-3 h-3 bg-indigo-600 rounded-full mb-4"></span>
                <span class="text-indigo-600 dark:text-indigo-400 font-semibold uppercase tracking-wide ml-2">{{ $about['eyebrow'] ?? 'About' }}</span>
                <h2 class="text-4xl font-bold mt-4 mb-6 dark:text-white">{{ $about['title'] ?? 'The Hagenberg Game Jam' }}</h2>
                <h3 class="text-2xl font-semibold mb-6 dark:text-gray-200">{{ $about['subtitle'] ?? 'Creating a game in just one weekend?' }}</h3>
                <div class="prose dark:prose-invert max-w-none">
                    {!! \Illuminate\Support\Str::markdown((string) ($about['markdown'] ?? '')) !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Section -->
<section class="relative py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-end mb-12">
            <div class="text-right">
                <span class="text-indigo-400 uppercase tracking-wide text-sm">{{ $video['eyebrow'] ?? 'intro video' }}</span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mt-2">{!! nl2br(e($video['title'] ?? "Hagenberg Game Jam\nin a Nutshell")) !!}</h2>
            </div>
            <div>
                <p class="text-gray-200 text-lg">{{ $video['description'] ?? 'Experience the feeling of a Hagenberg Game Jam in this short clip from 2019.' }}</p>
            </div>
        </div>
        <div class="max-w-4xl mx-auto">
            <div class="relative rounded-lg overflow-hidden shadow-2xl" style="padding-bottom: 56.25%; height: 0; position: relative;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full" 
                    src="https://www.youtube.com/embed/{{ $video['youtube_id'] ?? 'S4UBw5cPjfY' }}" 
                    title="Hagenberg Game Jam Intro Video" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
                </section>

<!-- Sponsors Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8 dark:text-white">{{ $sponsors['title'] ?? 'Our Sponsors' }}</h2>
        <div class="sponsors-slider glide max-w-6xl mx-auto" style="display: block;">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides" style="list-style: none; margin: 0; padding: 0; display: flex;">
                    @foreach(($sponsors['items'] ?? []) as $sponsor)
                        @php
                            $logo = (string) ($sponsor['logo'] ?? '');
                            $logoSrc = ($logo !== '' && str_starts_with($logo, '/')) ? $logo : '/media/' . ltrim($logo, '/');
                        @endphp
                        <li class="glide__slide">
                            <div class="flex justify-center items-center h-32">
                                <a href="{{ $sponsor['url'] ?? '#' }}" target="_blank"
                                   class="opacity-100 hover:opacity-70 transition-opacity">
                                    <img src="{{ $logoSrc }}" alt="{{ $sponsor['name'] ?? 'Sponsor' }}"
                                         class="h-16 object-contain">
                                </a>
                            </div>
                        </li>
                    @endforeach
                    </ul>
            </div>
        </div>
    </div>
</section>
@endsection
