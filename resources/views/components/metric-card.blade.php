<div class="col-md-6 col-xl-3">

    <div class="metric-card {{ $class ?? 'metric-primary' }} h-100">

        <div class="metric-icon">

            <i class="bi {{ $icon }}"></i>

        </div>

        <div class="metric-content">

            <small class="metric-label">

                {{ $title }}

            </small>

            <h3 class="metric-value">

                {{ $value }}

            </h3>

            @if(isset($subtitle))

                <small class="text-muted">

                    {{ $subtitle }}

                </small>

            @endif

        </div>

    </div>

</div>