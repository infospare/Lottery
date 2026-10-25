@extends('layouts.app')

@section('title', 'Account Settings')

@section('content')
<div class="container mx-auto px-4 py-12" style="max-width: 36rem;">
    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 0.75rem; margin-bottom: 1rem; font-size: 0.875rem;">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Update own account --}}
    <div style="background: #ffffff; border-radius: 0.75rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 1.5rem;">
        <div style="background-color: #1a3d2e; padding: 1rem 1.5rem;">
            <h1 style="color: #ffffff; font-size: 1.25rem; font-weight: 700; text-align: center; margin: 0;">
                Account Settings
            </h1>
        </div>

        <form method="POST" action="{{ route('account.update') }}" style="padding: 1.5rem;">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                       style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Email (login username)</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                       style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1.25rem 0;">

            <div style="margin-bottom: 1rem;">
                <label for="current_password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Current Password</label>
                <div style="position: relative;">
                    <input type="password" id="current_password" name="current_password" required
                           placeholder="Required to save changes"
                           style="width: 100%; padding: 0.625rem 2.75rem 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                    <button type="button" class="toggle-password" data-target="current_password"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0.25rem; font-size: 0.8125rem; font-weight: 600;">
                        Show
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">New Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password"
                           placeholder="Leave blank to keep current"
                           style="width: 100%; padding: 0.625rem 2.75rem 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                    <button type="button" class="toggle-password" data-target="password"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0.25rem; font-size: 0.8125rem; font-weight: 600;">
                        Show
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Confirm New Password</label>
                <div style="position: relative;">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Confirm new password"
                           style="width: 100%; padding: 0.625rem 2.75rem 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                    <button type="button" class="toggle-password" data-target="password_confirmation"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0.25rem; font-size: 0.8125rem; font-weight: 600;">
                        Show
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Save Changes
            </button>
        </form>
    </div>

    {{-- Add new user --}}
    <div style="background: #ffffff; border-radius: 0.75rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; overflow: hidden; margin-bottom: 1.5rem;">
        <div style="background-color: #1a3d2e; padding: 1rem 1.5rem;">
            <h2 style="color: #ffffff; font-size: 1.25rem; font-weight: 700; text-align: center; margin: 0;">
                Add User
            </h2>
        </div>

        <form method="POST" action="{{ route('account.users.create') }}" style="padding: 1.5rem;">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label for="new_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Name</label>
                <input type="text" id="new_name" name="new_name" value="{{ old('new_name') }}" required
                       style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="new_email" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Email (login username)</label>
                <input type="email" id="new_email" name="new_email" value="{{ old('new_email') }}" required
                       style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="new_password" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Password</label>
                <div style="position: relative;">
                    <input type="password" id="new_password" name="new_password" required minlength="6"
                           placeholder="Minimum 6 characters"
                           style="width: 100%; padding: 0.625rem 2.75rem 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                    <button type="button" class="toggle-password" data-target="new_password"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0.25rem; font-size: 0.8125rem; font-weight: 600;">
                        Show
                    </button>
                </div>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="new_password_confirmation" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.25rem;">Confirm Password</label>
                <div style="position: relative;">
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required minlength="6"
                           placeholder="Confirm password"
                           style="width: 100%; padding: 0.625rem 2.75rem 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box;">
                    <button type="button" class="toggle-password" data-target="new_password_confirmation"
                            style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; padding: 0.25rem; font-size: 0.8125rem; font-weight: 600;">
                        Show
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                Add User
            </button>
        </form>
    </div>

    {{-- Existing users list --}}
    <div style="background: #ffffff; border-radius: 0.75rem; box-shadow: 0 4px 16px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; overflow: hidden;">
        <div style="background-color: #2d5a3d; padding: 0.75rem 1.5rem;">
            <h2 style="color: #ffffff; font-size: 1rem; font-weight: 700; text-align: center; margin: 0;">
                Existing Users
            </h2>
        </div>
        <div style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                <thead>
                    <tr style="background-color: #f3f4f6;">
                        <th style="padding: 0.625rem 1rem; text-align: left; border-bottom: 1px solid #e5e7eb;">Name</th>
                        <th style="padding: 0.625rem 1rem; text-align: left; border-bottom: 1px solid #e5e7eb;">Email</th>
                        <th style="padding: 0.625rem 1rem; text-align: center; border-bottom: 1px solid #e5e7eb; width: 6rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $existingUser)
                    <tr>
                        <td style="padding: 0.625rem 1rem; border-bottom: 1px solid #e5e7eb; color: #1a3d2e;">
                            {{ $existingUser->name }}
                            @if($existingUser->id === $user->id)
                                <span style="color: #6b7280; font-size: 0.75rem;">(you)</span>
                            @endif
                        </td>
                        <td style="padding: 0.625rem 1rem; border-bottom: 1px solid #e5e7eb; color: #1a3d2e;">
                            {{ $existingUser->email }}
                        </td>
                        <td style="padding: 0.625rem 1rem; border-bottom: 1px solid #e5e7eb; text-align: center;">
                            @if($existingUser->id !== $user->id)
                            <form method="POST" action="{{ route('account.users.delete', $existingUser->id) }}" style="display: inline; margin: 0;"
                                  onsubmit="return confirm('Remove user {{ $existingUser->name }}?');">
                                @csrf
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                            @else
                            <span style="color: #9ca3af; font-size: 0.75rem;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 1rem; text-align: center; color: #6b7280;">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-password').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const input = document.getElementById(btn.dataset.target);
        const showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.textContent = showing ? 'Show' : 'Hide';
    });
});
</script>
@endsection
