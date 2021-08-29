<li>
    <static-image-wrapper :car="{{ $car }}"></static-image-wrapper>
{{--    <div class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">--}}
{{--        <static-redeemed-amount :id="{{ $car->id }}"></static-redeemed-amount>--}}
{{--        <static-image :id="{{ $car->image ? $car->image->id : 0 }}"></static-image>--}}
{{--    </div>--}}
    <p class="mt-2 block text-sm font-medium text-gray-800 truncate pointer-events-none">{{ $car->title }}</p>
    <p class="block text-sm font-medium text-gray-500 truncate pointer-events-none">{{ $car->subtitle }}</p>
    <div class="flex justify-between mt-3">
        <div class="mr-1 sm:mr-2">
            <button-bookmark :id="{{ $car->id }}"></button-bookmark>
        </div>
        <div class="mr-1 sm:mr-2">
            <button-redeem :id="{{ $car->id }}" title="{{ $car->title }}"></button-redeem>
        </div>
{{--        <div class="flex-grow flex justify-end">--}}
{{--            <button-report :id="{{ $car->id }}"></button-report>--}}
{{--        </div>--}}
        <div class="flex-grow flex justify-end">
            <button-information :id="{{ $car->id }}"></button-information>
        </div>
    </div>
</li>
