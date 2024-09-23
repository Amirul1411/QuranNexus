<div x-data x-init="if (!window.recitationTimerInitialized) {
    window.addEventListener('beforeunload', () => {
        @this.trackTimeSpent();
    });
    window.recitationTimerInitialized = true;
}">
</div>
