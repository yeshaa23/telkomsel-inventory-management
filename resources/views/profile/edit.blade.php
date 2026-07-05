<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="gsm-eyebrow">
                {{ __('app.account') }}
            </p>

            <h2>
                {{ __('app.profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="gsm-dashboard">
        <section class="gsm-panel">
            <div class="gsm-panel-header">
                <div>
                    <p class="gsm-eyebrow">
                        {{ __('app.settings') }}
                    </p>

                    <h3>
                        {{ __('app.display_settings') }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ __('app.settings_desc') }}
                    </p>
                </div>
            </div>

            <div class="gsm-settings-grid">
                <div class="gsm-setting-card">
                    <h4>
                        {{ __('app.display_mode') }}
                    </h4>

                    <p>
                        {{ __('app.display_mode_desc') }}
                    </p>

                    <div class="gsm-setting-action">
                        <button
                            type="button"
                            id="theme-toggle"
                            class="gsm-setting-button"
                            aria-label="Switch theme"
                        >
                            <span id="theme-toggle-icon">
                                ☾
                            </span>

                            <span id="theme-toggle-label">
                                {{ __('app.dark_mode') }}
                            </span>
                        </button>
                    </div>
                </div>

                <div class="gsm-setting-card">
                    <h4>
                        {{ __('app.language') }}
                    </h4>

                    <p>
                        {{ __('app.language_desc') }}
                    </p>

                    <form
                        method="POST"
                        action="{{ route('language.update') }}"
                    >
                        @csrf

                        <select
                            name="locale"
                            id="language-select"
                            class="gsm-setting-select"
                            onchange="this.form.submit()"
                        >
                            <option
                                value="id"
                                {{ app()->getLocale() === 'id' ? 'selected' : '' }}
                            >
                                {{ __('app.indonesian') }}
                            </option>

                            <option
                                value="en"
                                {{ app()->getLocale() === 'en' ? 'selected' : '' }}
                            >
                                {{ __('app.english') }}
                            </option>
                        </select>
                    </form>
                </div>
            </div>
        </section>

        <section class="gsm-panel">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </section>

        <section class="gsm-panel">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </section>

        <section class="gsm-panel">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </section>
    </div>
</x-app-layout>
