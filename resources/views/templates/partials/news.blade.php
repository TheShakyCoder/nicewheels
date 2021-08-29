<section aria-labelledby="announcements-title">
    <div class="rounded-lg bg-white overflow-hidden shadow">
        <div class="p-6">
            <h2 class="text-base font-medium text-gray-900" id="announcements-title">News</h2>
            <small>courtesy of AutoExpress</small>
            <div class="flow-root mt-6">
                <ul class="-my-5 divide-y divide-gray-200">
                    @foreach($news as $article)
                    <li class="py-5">
                        <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                            <h3 class="text-base font-semibold text-gray-800">
                                <a href="{{ $article['link'] }}" target="_blank" class="hover:underline focus:outline-none">
                                    <!-- Extend touch target to entire panel -->
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    {{ $article['title'] }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $article['description'] }}</p>
                            <p class="text-xs text-gray-800 text-right mt-2 font-bold">{{ $article['pubDate'] }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-6">
                <a target="_blank" href="https://www.autoexpress.co.uk/car-news" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">View all</a>
            </div>
        </div>
    </div>
</section>
