@extends('layouts.app')

@section('title', 'Downloads')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- Page Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4 text-gray-900 dark:text-white">
            Downloads
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
            Browse and download our latest resources, documents, and files.
        </p>
    </div>

    <!-- Downloads List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($softwareDownloads as $software)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-34 h-34 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center overflow-hidden">
                    @php
                        // Get image path from database and construct URL
                        $imagePath = $software->image_path ?? null;
                        $imageUrl = $imagePath ? asset('images/' . $imagePath) : null;
                    @endphp
                    @if($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $software->display_name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.parentElement.innerHTML='<svg class=\'w-16 h-16 text-blue-600 dark:text-blue-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z\'></path></svg>';">
                    @else
                        <svg class="w-16 h-16 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
            </div>
            <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ $software->display_name }}</h3>
            <!-- Star Rating -->
            @php
                // Get average rating from database
                $averageRating = $software->average_rating ?? 0;
                $ratingCount = $software->rating_count ?? 0;
                $userRating = $userRatings[$software->id] ?? null;
                $fullStars = floor($averageRating);
                $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
            @endphp
            <div class="mb-3">
                <div class="flex items-center gap-2 rating-container" data-software-id="{{ $software->id }}" data-user-rating="{{ $userRating ?? 0 }}" data-average-rating="{{ $averageRating }}">
                    <!-- Rating Number with Star Icon -->
                    <div class="flex items-center gap-1 rating-display-{{ $software->id }}">
                        @if($averageRating > 0)
                            <span class="text-base font-medium text-gray-700 dark:text-gray-300">{{ number_format($averageRating, 1) }}</span>
                            <svg class="w-4 h-4 text-gray-700 dark:text-gray-300 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @else
                            <span class="text-base font-medium text-gray-400 dark:text-gray-500">0.0</span>
                            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endif
                    </div>
                    <!-- Interactive Stars -->
                    <div class="flex items-center gap-0.5 stars-wrapper">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                    class="star-btn p-0.5 hover:scale-110 transition-transform focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded"
                                    data-rating="{{ $i }}"
                                    aria-label="Rate {{ $i }} star{{ $i > 1 ? 's' : '' }}">
                                @if($i <= $fullStars)
                                    <!-- Filled Star -->
                                    <svg class="w-5 h-5 star-icon text-yellow-400 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <!-- Empty Star (Outline) -->
                                    <svg class="w-5 h-5 star-icon text-gray-300 dark:text-gray-600 fill-none stroke-2 stroke-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            </button>
                        @endfor
                    </div>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                {{ $software->description }}
            </p>
            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                <span>Size: {{ $software->size }}</span>
                <span>Updated: {{ $software->last_updated->format('M d, Y') }}</span>
            </div>
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <span class="text-xs text-gray-500 dark:text-gray-400 download-count-{{ $software->id }}">{{ $software->download_count }} downloads</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('downloads.file', [$software->id, 'exe']) }}" class="btn btn-primary" onclick="handleDownload(event, {{ $software->id }}, 'exe')">
                        setup.exe
                    </a>
                    <a href="{{ route('downloads.file', [$software->id, 'zip']) }}" class="btn btn-primary" onclick="handleDownload(event, {{ $software->id }}, 'zip')">
                        setup.zip
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-600 dark:text-gray-400 text-lg">No software downloads available at the moment.</p>
        </div>
        @endforelse
    </div>

    <!-- Info Section -->
    <div class="mt-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 text-center">
        <p class="text-gray-700 dark:text-gray-300">
            Need help finding what you're looking for? <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">Contact our support team</a>.
        </p>
    </div>
</div>

<script>
function updateDownloadCount(id) {
    fetch('/downloads/' + id + '/count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.download_count !== undefined) {
            const countElement = document.querySelector('.download-count-' + id);
            if (countElement) {
                countElement.textContent = data.download_count + ' downloads';
            }
        }
    })
    .catch(error => {
        console.error('Error fetching download count for ID ' + id + ':', error);
    });
}

function handleDownload(event, id, type) {
    event.preventDefault();
    type = type || 'exe';
    const fileUrl = '/downloads/' + id + '/file/' + type;

    fetch('/downloads/' + id + '/increment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const countElement = document.querySelector('.download-count-' + id);
            if (countElement && data.download_count !== undefined) {
                countElement.textContent = data.download_count + ' downloads';
            }
        }
        window.location.href = fileUrl;
    })
    .catch(error => {
        console.error('Error incrementing download count:', error);
        window.location.href = fileUrl;
    });
}

// Refresh all download counts when the page becomes visible (user returns to tab)
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        // Get all download count elements and update them
        const countElements = document.querySelectorAll('[class*="download-count-"]');
        countElements.forEach(function(element) {
            const id = element.className.match(/download-count-(\d+)/);
            if (id && id[1]) {
                updateDownloadCount(id[1]);
            }
        });
    }
});

function trackUserGuideDownload(event) {
    // Track the download
    fetch('{{ route("downloads.user-guide.track") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).catch(error => {
        console.error('Error tracking download:', error);
    });
    
    // Allow the download to proceed normally
    // The download will happen automatically via the href attribute
}

// Rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const ratingContainers = document.querySelectorAll('.rating-container');
    
    ratingContainers.forEach(container => {
        const softwareId = container.dataset.softwareId;
        const starButtons = container.querySelectorAll('.star-btn');
        const averageRating = parseFloat(container.dataset.averageRating) || 0;
        
        // Initialize stars based on average rating
        highlightStars(container, averageRating);
        
        // Handle star hover
        starButtons.forEach((button, index) => {
            button.addEventListener('mouseenter', function() {
                const rating = parseInt(button.dataset.rating);
                highlightStars(container, rating);
            });
        });
        
        container.addEventListener('mouseleave', function() {
            const userRating = parseInt(container.dataset.userRating) || 0;
            const currentAvg = parseFloat(container.dataset.averageRating) || 0;
            // Show user's rating if they've rated, otherwise show average
            highlightStars(container, userRating > 0 ? userRating : currentAvg);
        });
        
        // Handle star click
        starButtons.forEach(button => {
            button.addEventListener('click', function() {
                const rating = parseInt(button.dataset.rating);
                submitRating(softwareId, rating, container);
            });
        });
    });
});

function highlightStars(container, rating) {
    const starButtons = container.querySelectorAll('.star-btn');
    const fullStars = Math.floor(rating);
    
    starButtons.forEach((button, index) => {
        const starNum = index + 1;
        const svg = button.querySelector('svg');
        const path = svg.querySelector('path');
        
        // Remove all relevant classes
        svg.classList.remove('text-yellow-400', 'text-gray-300', 'dark:text-gray-600', 'fill-current', 'fill-none', 'stroke-2', 'stroke-current');
        
        if (starNum <= fullStars) {
            // Fill the star
            svg.classList.add('text-yellow-400', 'fill-current');
            path.setAttribute('fill', 'currentColor');
            path.removeAttribute('stroke');
        } else {
            // Empty star (outline)
            svg.classList.add('text-gray-300', 'dark:text-gray-600', 'fill-none', 'stroke-2', 'stroke-current');
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke', 'currentColor');
            path.setAttribute('stroke-width', '2');
        }
    });
}

function getCurrentAverageRating(container) {
    return parseFloat(container.dataset.averageRating) || 0;
}

function submitRating(softwareId, rating, container) {
    // Show loading state
    const ratingDisplay = container.querySelector('[class*="rating-display-"]');
    const originalHTML = ratingDisplay.innerHTML;
    ratingDisplay.innerHTML = '<span class="text-base font-medium text-gray-400">...</span><svg class="w-4 h-4 text-gray-400 fill-current animate-pulse" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>';
    
    fetch('/downloads/' + softwareId + '/rate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ rating: rating })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the container with new rating
            container.dataset.userRating = rating;
            container.dataset.averageRating = data.average_rating || 0;
            
            // Update display with new format: "4.5 ★"
            const ratingDisplay = container.querySelector('[class*="rating-display-"]');
            const averageRating = data.average_rating || 0;
            
            ratingDisplay.innerHTML = `
                <span class="text-base font-medium text-gray-700 dark:text-gray-300">${averageRating.toFixed(1)}</span>
                <svg class="w-4 h-4 text-gray-700 dark:text-gray-300 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                </svg>
            `;
            
            // Update star display - show average rating
            highlightStars(container, averageRating);
        } else {
            throw new Error(data.message || 'Failed to submit rating');
        }
    })
    .catch(error => {
        console.error('Error submitting rating:', error);
        const ratingDisplay = container.querySelector('[class*="rating-display-"]');
        ratingDisplay.innerHTML = originalHTML;
        
        // Show error message
        const errorMsg = document.createElement('span');
        errorMsg.className = 'text-xs text-red-600 dark:text-red-400 ml-2';
        errorMsg.textContent = 'Error. Try again.';
        ratingDisplay.appendChild(errorMsg);
        setTimeout(() => {
            errorMsg.remove();
        }, 3000);
    });
}
</script>
@endsection

