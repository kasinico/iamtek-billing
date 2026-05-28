<div class="card border-0 shadow-sm h-100">

    <div class="card-body">

        <div class="mb-4">

            <h5 class="fw-bold mb-1">

                {{ $title }}

            </h5>

            @if(isset($description))

                <p class="text-muted mb-0">

                    {{ $description }}

                </p>

            @endif

        </div>

        <div class="chart-container">

            {{ $slot }}

        </div>

    </div>

</div>