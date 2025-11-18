<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            ユーザー情報変更
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            プロフィール画像、ユーザー名、メールアドレスを変更できます。
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- [2：登録済みプロフィール画像] --}}
        <div>
            <x-input-label for="profile_image" value="プロフィール画像" />
            <div class="mt-2 flex items-center gap-4">
                {{-- 現在の画像表示 --}}
                <div>
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="w-24 h-24 rounded-full object-cover">
                    @else
                        {{-- デフォルト画像 --}}
                        <div class="w-24 h-24 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- [3：画像選択ボタン] --}}
                <div class="flex-1">
                    <input 
                        type="file" 
                        name="profile_image" 
                        id="fileProfileImage" 
                        accept="image/*"
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:outline-none"
                    >
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (最大2MB)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
                </div>
            </div>
        </div>

        {{-- [4：ユーザー名] 必須項目 --}}
        <div>
            <x-input-label for="txtName" value="ユーザー名" />
            <span class="text-red-500 text-sm">*</span>
            <x-text-input 
                id="txtName" 
                name="name" 
                type="text" 
                class="mt-1 block w-full" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- [5：メールアドレス] 必須項目 --}}
        <div>
            <x-input-label for="txtEmail" value="メールアドレス" />
            <span class="text-red-500 text-sm">*</span>
            <x-text-input 
                id="txtEmail" 
                name="email" 
                type="email" 
                class="mt-1 block w-full" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- [6：登録ボタン] --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                キャンセル
            </a>
            <x-primary-button id="btnSubmit">保存</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >保存しました。</p>
            @endif
        </div>
    </form>
</section>