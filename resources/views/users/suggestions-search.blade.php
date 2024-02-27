@extends('layouts.app')

@section('title', 'Explore People')

@section('content')
    <div class="d-flex justify-content-center mb-3">
        <form action="{{ route('suggestions') }}" style="width: 300px">
            @csrf
            <input type="search" name="search" class="form-control form-control-sm bg-white" Value="{{ $search }}" autofocus>
        </form>
    </div>
    <div class="row justify-content-center">
        <div class="col-5">
            <p class="h5 fw-bold">Suggested</p>
            
            @forelse ($suggested_users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                        @if ($user->isFollowingMe())
                            <p class="xsmall text-muted">Follows you</p>
                        @else
                            @if ($user->followers->count() == 0)
                                <p class="xsmall text-muted">Not Followers yet</p>
                            @else
                                <p class="xsmall text-muted">{{ $user->followers->count() }} {{$user->followers->count() == 1 ? 'follower' : 'followers'}}</p>
                            @endif
                        @endif
                    </div>
                    <div class="col-auto">
                        @if ($user->id !== Auth::user()->id)
                            @if ($user->isFollowed())
                                <form action="{{ route('follow.destroy', $user->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-secondary fw-bold btn-sm">Following</button>
                                </form>
                            @else
                                <form action="{{ route('follow.store', $user->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <p class="lead text-muted text-center">No users found.</p>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            {{ $suggested_users->appends(['search' => $search])->links() }}
        </div>
    </div>
@endsection