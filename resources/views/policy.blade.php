<x-app-layout title="Policy" backgroundImage="background-image">
    <div class="pt-4 bg-transparent w-full">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 mt-32">
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-app-layout>
