<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="/">
                <img src="/images/idea_logo.png" width="100" alt="Idea logo">
            </a>
        </div>
        

        <div class="flex gap-x-3 items-center">
            @auth
                <a href="/profile/edit">Edit Profile</a>

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn" data-test="logout-btn">Log out</button>
                </form>
            @endauth

            @guest
                <a href="/register" class="btn btn-secondary">Register</a>
                <a href="/login" class="btn">Sign In</a>
            @endguest
        </div>
    </div>
</nav>