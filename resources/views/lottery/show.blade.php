@extends('layouts.app')

@section('title', $draw->display_label . ' - Lottery Result')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('lottery.results') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
            &larr; Back to Results
        </a>
    </div>

    <div class="rounded-lg overflow-hidden shadow-lg border border-green-800">
        <div class="bg-[#1a3d2e] px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-white">{{ $draw->display_label }}</h1>
                <p class="text-green-200 mt-1">Draw Date: {{ $draw->formatted_draw_date }}</p>
            </div>
            @if($draw->file_path)
            <a href="{{ route('lottery.results.download', $draw->id) }}" class="btn btn-primary">
                Download
            </a>
            @endif
        </div>

        <div class="bg-[#d4e8c4] p-6">
            @php
                $filePath = $draw->resolveFilePath();
                $extension = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : null;
            @endphp

            @if($filePath && in_array($extension, ['jpg', 'jpeg', 'png']))
                <div class="flex justify-center">
                    <img src="{{ asset('storage/' . $draw->file_path) }}" alt="{{ $draw->display_label }}" class="max-w-full rounded shadow-md">
                </div>
            @elseif($filePath && $extension === 'pdf')
                <iframe src="{{ asset('storage/' . $draw->file_path) }}" class="w-full h-[80vh] rounded shadow-md bg-white" title="{{ $draw->display_label }}"></iframe>
            @elseif($filePath && $extension === 'txt')
                <pre style="background: #fff; padding: 1.25rem; border-radius: 0.5rem; overflow: auto; max-height: 80vh; white-space: pre-wrap; word-break: break-word; color: #1a3d2e; font-size: 0.9rem; line-height: 1.5;">{{ file_get_contents($filePath) }}</pre>
            @elseif($filePath && in_array($extension, ['htm', 'html']))
                <iframe src="{{ asset('storage/' . $draw->file_path) }}" class="w-full h-[80vh] rounded shadow-md bg-white" title="{{ $draw->display_label }}"></iframe>
            @elseif($draw->results)
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse bg-white rounded shadow">
                        <thead>
                            <tr class="bg-[#2d5a3d] text-white">
                                @if(isset($draw->results[0]) && is_array($draw->results[0]))
                                    @foreach(array_keys($draw->results[0]) as $header)
                                    <th class="px-4 py-2 text-left border border-green-700">{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
                                    @endforeach
                                @else
                                    <th class="px-4 py-2 text-left border border-green-700">Prize</th>
                                    <th class="px-4 py-2 text-left border border-green-700">Ticket Number</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($draw->results as $row)
                            <tr class="hover:bg-green-50">
                                @if(is_array($row))
                                    @foreach($row as $cell)
                                    <td class="px-4 py-2 border border-green-200 text-[#1a3d2e]">{{ $cell }}</td>
                                    @endforeach
                                @else
                                    <td class="px-4 py-2 border border-green-200 text-[#1a3d2e]" colspan="2">{{ $row }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-[#1a3d2e] py-8">No result file or data available for this draw.</p>
            @endif
        </div>
    </div>
</div>
@endsection
