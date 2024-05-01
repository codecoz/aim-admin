@php
    $notificationData = new stdClass();
    // Ensure $notificationData has 'notifications' as an array to avoid errors in the @forelse directive
    $notificationData->notifications = $notificationData->notifications ?? [];
@endphp

    <!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell {{isset($notificationData->count) && $notificationData->count > 0 ? 'fa-shake' : ''}}"></i>
        <span class="badge badge-warning navbar-badge">{{ $notificationData->count ?? 0 }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">{{ $notificationData->count ?? 0 }} Notifications</span>
        @forelse($notificationData->notifications as $notification)
            <div class="dropdown-divider"></div>
            @if(!empty($notification->data['redirect']))
                <a href="{{ route('view.notification', ['notification' => $notification, 'type' => 'redirect']) }}"
                   class="dropdown-item">
                    <p class="text-sm">
                        <i class="fas fa-bell fa-shake"></i>
                        {{ $notification->data['message'] }}
                        <span class="float-right text-sm">
                            {{ $notification->created_at->format('d/m/Y h:i A') }}
                        </span>
                    </p>
                </a>
            @else
                <a href="#" class="dropdown-item">
                    <p class="text-sm">
                        <i class="fas fa-bell fa-shake"></i> {{ $notification->data['message'] }}
                    </p>
                    <span class="float-right text-sm">{{ $notification->created_at->format('d/m/Y h:i A') }}</span>
                </a>
            @endif
        @empty
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-item-center">No Notifications</a>
        @endforelse
        <a href="{{ route('list.notification') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
