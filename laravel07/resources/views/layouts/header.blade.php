<header class="header">
    <div class="header__container">
        <nav class="header__nav">
            <ul class="header__menu">
                {{-- タスク一覧アイコン --}}
                <li class="header__menu-item">
                    <a href="{{ route('tasks.index') }}" class="header__link" title="タスク一覧">
                        <svg class="header__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="header__text">タスク一覧</span>
                    </a>
                </li>

                {{-- タスク新規登録アイコン --}}
                <li class="header__menu-item">
                    <a href="{{ route('tasks.create') }}" class="header__link" title="タスク新規登録">
                        <svg class="header__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="header__text">新規登録</span>
                    </a>
                </li>

                {{-- ユーザー情報変更アイコン --}}
                <li class="header__menu-item">
                    <a href="{{ route('profile.edit') }}" class="header__link" title="ユーザー情報変更">
                        <svg class="header__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="header__text">ユーザー情報</span>
                    </a>
                </li>

                {{-- ログアウトアイコン --}}
                <li class="header__menu-item">
                    <form method="POST" action="{{ route('logout') }}" class="header__form">
                        @csrf
                        <button type="submit" class="header__link header__link--button" title="ログアウト">
                            <svg class="header__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="header__text">ログアウト</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>