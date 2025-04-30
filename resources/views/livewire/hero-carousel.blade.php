<div class="relative w-full overflow-hidden rounded-lg shadow-lg" x-data="{
    currentSlide: 0,
    slides: @js($slides),
    interval: null,
    init() {
        this.startAutoPlay();
    },
    startAutoPlay() {
        this.interval = setInterval(() => {
            this.nextSlide();
        }, 5000);
    },
    stopAutoPlay() {
        clearInterval(this.interval);
    },
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    },
    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
    },
    goToSlide(index) {
        this.currentSlide = index;
    }
}" @mouseenter="stopAutoPlay()" @mouseleave="startAutoPlay()">
    <!-- Slides -->
    <div class="relative h-96 overflow-hidden">
        @foreach($slides as $index => $slide)
            <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0">
                <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center">
                    <div class="container mx-auto px-4">
                        <div class="max-w-lg text-white">
                            <span class="text-lg font-semibold">{{ $slide['subtitle'] }}</span>
                            <h2 class="text-4xl font-bold mt-2 mb-4">{{ $slide['title'] }}</h2>
                            <a href="{{ $slide['link'] }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-medium px-6 py-3 rounded-lg transition duration-300">
                                {{ $slide['button_text'] }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Controls -->
    <button @click="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-gray-800 p-2 rounded-full shadow-md">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    <button @click="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-gray-800 p-2 rounded-full shadow-md">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
        @foreach($slides as $index => $slide)
            <button @click="goToSlide({{ $index }})" class="w-3 h-3 rounded-full transition duration-300"
                :class="{ 'bg-white': currentSlide === {{ $index }}, 'bg-white bg-opacity-50': currentSlide !== {{ $index }} }">
            </button>
        @endforeach
    </div>
</div>