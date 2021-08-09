<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $fullMake }} Used Prices</title>
        <meta name="description" content="{{ $fullMake }} used car prices based on recently sold cars">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">


        <!-- Scripts -->
        <script src="{{ mix('js/public.js') }}" defer></script>
        <script src="https://js.stripe.com/v3/"></script>
    </head>
    <body>
        <div id="public">
            <div class="min-h-screen bg-gray-100">

                <static-header></static-header>

                <main class="-mt-24 pb-8">
                    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <!-- Main 3 column grid -->
                        <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                            <!-- Left column -->
                            <div class="grid grid-cols-1 gap-4 lg:col-span-2">

                                <modal-side-filter :makes="{{ $makes }}" folder="{{ $folder }}"></modal-side-filter>

                                <div class="p-4 bg-white rounded-lg shadow mb-4">
                                    <div class="flex justify-between mb-1">
                                        <div>
                                            <h2 class="text-2xl font-bold text-yellow-800 pt-3">{{ $fullMake }}</h2>
                                            <h3 class="mt-0 pt-0"><i class="text-cyan-700 font-bold">Used Prices</i></h3>
                                        </div>
                                        <button-show-side-filter></button-show-side-filter>
                                    </div>
                                    <ul role="list" class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-3 truncate">
                                        @foreach($cars as $car)
                                            @include('templates.partials.car')
                                        @endforeach
                                        <component-load-more></component-load-more>
                                        @if($lastPage != 1)
                                            <button-load-more :ids="{{ json_encode($cars->pluck('id')) }}" :makes-and-descendants="{{ json_encode($makesAndDescendants) }}" :complete="true"></button-load-more>
                                        @endif
                                    </ul>
                                </div>

                            </div>

                            <!-- Right column -->
                            <div class="grid grid-cols-1 gap-4">
                                @include('templates.partials.news')
                            </div>
                        </div>
                    </div>
                </main>

            </div>

            <div ref="ids" data-ids="{{ $cars->pluck('id') }}"></div>

            <modal-login></modal-login>
            <modal-guest></modal-guest>
            <modal-stripe></modal-stripe>
            <modal-redeem></modal-redeem>
            <modal-information></modal-information>

            @include('templates.partials.footer')

        </div>

    </body>
</html>
