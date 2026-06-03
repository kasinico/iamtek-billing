
    {{-- HEADER --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h2 class="fw-bold">

                {{ $user->name }}

            </h2>

            <p class="text-muted mb-1">

                {{ $user->email }}

            </p>

            <p class="text-muted">

                {{ $user->phone ?? 'No phone' }}

            </p>

        </div>

    </div>