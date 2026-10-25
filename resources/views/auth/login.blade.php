@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mx-auto px-4 py-12" style="max-width: 28rem;">
    <div style="background: #ffffff; border-radius: 0.75rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; overflow: hidden;">
        <div style="background-color: #1a3d2e; padding: 1rem 1.5rem;">
            <h1 style="color: #ffffff; font-size: 1.25rem; font-weight: 700; text-align: center; margin: 0;">
                Admin Login
            </h1>
        </div>

        <form method="POST" action="{{ route('login') }}" style="padding: 1.5rem;">
            @csrf

            @if ($errors->any())
                <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 1rem; font-size: 0.875rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="admin@infospare.com"
                       style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" required
                           placeholder="Enter password"
                           style="width: 100%; padding: 0.625rem 2.75rem 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                    <button type="button" id="toggle-password"
                            aria-label="Show password"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0.25rem; font-size: 0.8125rem; font-weight: 600;">
                        Show
                    </button>
                </div>
            </div>

            <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem; font-size: 0.875rem; color: #4b5563;">
                <input type="checkbox" name="remember" value="1">
                Remember me
            </label>

            <button type="submit" class="btn btn-primary btn-block">
                Login
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('toggle-password')?.addEventListener('click', function () {
    const input = document.getElementById('password');
    const showing = input.type === 'text';
    input.type = showing ? 'password' : 'text';
    this.textContent = showing ? 'Show' : 'Hide';
    this.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
});
</script>
@endsection
