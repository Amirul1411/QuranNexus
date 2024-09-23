<div x-data="{ hasFired: false, timer: null }" x-init="
    if (!hasFired) {
        timer = setTimeout(() => {
            @this.checkRecentlyRead(); // Call Livewire method once after 5 seconds
            hasFired = true; // Mark as fired
        }, 5000);
    }
">
</div>
