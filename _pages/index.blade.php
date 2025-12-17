@extends('layouts.app')

@section('content')
@php
    $siteConfig = \App\GameJamData::getSiteConfig();
    $latestJam = $siteConfig['latest_jam'] ?? '2024';
    $votingActive = $siteConfig['voting_active'] ?? false;
    $votingUrl = $siteConfig['voting_url'] ?? '';
    $nextJam = $siteConfig['next_jam'] ?? null;
    $registrationActive = $siteConfig['registration_active'] ?? false;
    $registrationUrl = $siteConfig['registration_url'] ?? '';
@endphp

<!-- Hero Section with Slider -->
<section class="relative h-screen flex items-center justify-center overflow-hidden bg-gray-900" style="min-height: 100vh;">
    <div class="hero-slider glide w-full h-full absolute inset-0" style="display: block; position: relative;">
        <div class="glide__track" data-glide-el="track" style="overflow: hidden;">
            <ul class="glide__slides" style="list-style: none; margin: 0; padding: 0; display: flex; height: 100vh;">
                <li class="glide__slide" style="height: 100vh; min-width: 100%; position: relative; flex-shrink: 0;">
                    <div class="absolute inset-0" style="background-image: url('/media/gamejam_index_1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; width: 100%; height: 100%;">
                        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    </div>
                </li>
                <li class="glide__slide" style="height: 100vh; min-width: 100%; position: relative; flex-shrink: 0;">
                    <div class="absolute inset-0" style="background-image: url('/media/gamejam_index_2.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; width: 100%; height: 100%;">
                        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    </div>
                </li>
                <li class="glide__slide" style="height: 100vh; min-width: 100%; position: relative; flex-shrink: 0;">
                    <div class="absolute inset-0" style="background-image: url('/media/gamejam_index_3.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; width: 100%; height: 100%;">
                        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="absolute inset-0 flex items-center justify-center z-10">
            <div class="container mx-auto px-4 text-center text-white drop-shadow-lg">
                <span class="text-lg md:text-xl mb-4 block">Developing Games In No Time Since 2011</span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold mb-8">Hagenberg Game Jam</h1>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/{{ $latestJam }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        View the games of {{ $latestJam }}
                    </a>
                    @if($votingActive)
                    <a href="{{ $votingUrl }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Vote for the games of {{ $latestJam }}
                    </a>
                    @endif
                    @if($registrationActive && $nextJam)
                    <a href="{{ $registrationUrl }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Register for {{ $nextJam }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

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
                <img src="/media/gamejam_about.png" alt="Scenes from the Hagenberg Game Jam" class="rounded-lg shadow-lg w-full">
            </div>
            <div class="order-1 lg:order-2">
                <span class="inline-block w-3 h-3 bg-indigo-600 rounded-full mb-4"></span>
                <span class="text-indigo-600 dark:text-indigo-400 font-semibold uppercase tracking-wide ml-2">About</span>
                <h2 class="text-4xl font-bold mt-4 mb-6 dark:text-white">The Hagenberg Game Jam</h2>
                <h3 class="text-2xl font-semibold mb-6 dark:text-gray-200">Creating a game in just one weekend?</h3>
                <div class="prose dark:prose-invert max-w-none">
                    <p>Game jams have become incredibly popular in recent years. These events require participants to create a working computer game within a very limited time, usually just 48 hours. The topic is announced at the beginning of the event, and teams start brainstorming and implementing their games as quickly as possible to finish in time. At the end of the event, the games are often demonstrated in a public context before the participants catch some much-needed sleep.</p>
                    <p>In 2011, a first attempt was made to bring this kind of event to Hagenberg. The rules were slightly changed to be compatible with the curriculum of the students. The time was limited to 36 hours to better fit a weekend schedule. The topic is announced the evening before, and teams are set up beforehand. The weekend before the Christmas holidays was chosen to run the event, held in the university's computer labs and accompanied online on a <a href="https://discord.gg/kh2rXBj8nr" class="text-indigo-600 dark:text-indigo-400 hover:underline">Discord server</a>. Once finished, the games are put on this website, publicly available for download. Winners are determined through a voting process (jury and people's choice), and an award ceremony is held in January. After the success of the 2011 Game Jam, subsequent events have been held each year.</p>
                    <p>In 2017, the 7<sup>th</sup> edition took place with an even shorter duration: 24 hours. This was inspired by several game jams with shorter formats and was an attempt to avoid idle periods mostly during the night that occurred in the years before.</p>
                    <p>2018 returned to the well-established 36-hour format to give the teams more time to create their games. Feedback from the previous year had shown that 24 hours would limit the teams too much.</p>
                    <p>2020 was a special year in every aspect. A global pandemic, paired with lockdowns, made it impossible to conduct the game jam at the university. By switching to a virtual collaboration format with an extended time of 48 hours, the Hagenberg Game Jam nevertheless celebrated its 10th anniversary.</p>
                    <p>2021 saw yet another lockdown in December, and the organizers decided to skip this year's game jam. In 2022, a return to the established 36-hour format on Hagenberg Campus was possible, and 11 teams with over 40 people brought the Hagenberg Game Jam back to life.</p>
                    <p>2023 marked a new record: 82 people in 20 teams registered, making for the largest Hagenberg Game Jam since its start in 2011.</p>
                    <p>This website is an archive of all the games created during a Hagenberg Game Jam. You are free to download and play the games, but please give credit to the authors should you distribute them.</p>
                    <p>Hagenberg Game Jam is organized by people from the Playful Interactive Environments research group as well as the Department of Digital Media at the University of Applied Sciences Upper Austria, Hagenberg Campus.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Section -->
<section class="relative py-16 bg-cover bg-center" style="background-image: url('/media/gamejam_video_bg.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-end mb-12">
            <div class="text-right">
                <span class="text-indigo-400 uppercase tracking-wide text-sm">intro video</span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mt-2">Hagenberg Game Jam<br>in a Nutshell</h2>
            </div>
            <div>
                <p class="text-gray-200 text-lg">Experience the feeling of a Hagenberg Game Jam in this short clip from 2019.</p>
            </div>
        </div>
        <div class="max-w-4xl mx-auto">
            <div class="relative rounded-lg overflow-hidden shadow-2xl" style="padding-bottom: 56.25%; height: 0; position: relative;">
                <iframe 
                    class="absolute top-0 left-0 w-full h-full" 
                    src="https://www.youtube.com/embed/S4UBw5cPjfY" 
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
        <h2 class="text-3xl font-bold text-center mb-8 dark:text-white">Our Sponsors</h2>
        <div class="sponsors-slider glide max-w-6xl mx-auto" style="display: block;">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides" style="list-style: none; margin: 0; padding: 0; display: flex;">
                    <li class="glide__slide">
                        <div class="flex justify-center items-center h-32">
                            <a href="https://fh-ooe.at/campus-hagenberg/personen-kontakt/departments" target="_blank" class="opacity-100 hover:opacity-70 transition-opacity">
                                <img src="/media/gamejam_logo_digital-media.svg" alt="Digital Media Campus Hagenberg" class="h-24 object-contain">
                            </a>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="flex justify-center items-center h-32">
                            <a href="https://www.fh-ooe.at/campus-hagenberg/" target="_blank" class="opacity-70 hover:opacity-100 transition-opacity">
                                <img src="/media/gamejam_logo_fhooe.svg" alt="University of Applied Sciences Logo" class="h-24 object-contain">
                            </a>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="flex justify-center items-center h-32">
                            <a href="https://www.freistaedter-bier.at/" target="_blank" class="opacity-70 hover:opacity-100 transition-opacity">
                                <img src="/media/sponsor_freistaedter.png" alt="Freistädter Bier Logo" class="h-24 object-contain">
                            </a>
                        </div>
                    </li>
                    <li class="glide__slide">
                        <div class="flex justify-center items-center h-32">
                            <a href="https://www.keba.com/" target="_blank" class="opacity-70 hover:opacity-100 transition-opacity">
                                <img src="/media/sponsor_keba.svg" alt="KEBA Logo" class="h-24 object-contain">
                            </a>
                        </div>
                        </li>
                    <li class="glide__slide">
                        <div class="flex justify-center items-center h-32">
                            <a href="https://www.liwest.at/" target="_blank" class="opacity-70 hover:opacity-100 transition-opacity">
                                <img src="/media/sponsor_liwest.svg" alt="LIWEST Logo" class="h-24 object-contain">
                            </a>
                        </div>
                        </li>
                    <li class="glide__slide">
                        <div class="flex justify-center items-center h-32">
                            <a href="https://www.risc-software.at/" target="_blank" class="opacity-70 hover:opacity-100 transition-opacity">
                                <img src="/media/sponsor_risc-software.svg" alt="RISC Software Logo" class="h-24 object-contain">
                            </a>
                        </div>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</section>

<!-- Scroll to Top Button -->
<button id="scroll-top" class="fixed bottom-8 right-8 bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-full shadow-lg hidden transition-all z-50">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</button>
@endsection
