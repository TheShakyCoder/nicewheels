<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $fullMake }} Used Prices</title>

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
                        <h1 class="sr-only">Profile</h1>
                        <!-- Main 3 column grid -->
                        <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                            <!-- Left column -->
                            <div class="grid grid-cols-1 gap-4 lg:col-span-2">

                                <modal-side-filter :makes="{{ $makes }}"></modal-side-filter>

                                <div class="p-4 bg-white rounded-lg shadow mb-4">
                                    <div class="flex justify-between">
                                        <h2 class="text-2xl font-bold mb-1 text-yellow-800 pt-3">{{ $fullMake }}</h2>
                                        <button-show-side-filter></button-show-side-filter>
                                    </div>
                                    <ul role="list" class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-3 truncate">
                                        @foreach($cars as $car)
                                            @include('templates.partials.car')
                                        @endforeach
                                        <component-load-more></component-load-more>
                                        @if($lastPage != 1)
                                            <button-load-more :ids="{{ json_encode($cars->pluck('id')) }}" :makes="{{ json_encode($makesAndDescendants) }}" :complete="true"></button-load-more>
                                        @endif
                                    </ul>
                                </div>

                            </div>

                            <!-- Right column -->
                            <div class="grid grid-cols-1 gap-4">
                                RIGHT
                            </div>
                        </div>
                    </div>
                </main>
                <footer>
                    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
                        <div class="border-t border-gray-200 py-8 text-sm text-gray-500 text-center sm:text-left"><span class="block sm:inline">&copy; 2021 Fig Limited.</span> <span class="block sm:inline">All rights reserved.</span></div>
                    </div>
                </footer>
            </div>

            <div ref="ids" data-ids="{{ $cars->pluck('id') }}"></div>

            <modal-login></modal-login>
            <modal-guest></modal-guest>
            <modal-stripe></modal-stripe>
            <modal-redeem></modal-redeem>
            <modal-information></modal-information>

        </div>

    </body>
</html>
