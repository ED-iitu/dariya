<div class="form-group mt--20">
    @foreach($socialProviders as $provider)
        <a
                href="{{ route('social.auth', [$provider->slug]) }}"
                class="btn btn-light {{ $provider->slug }}">
            <i class="fa fa-{{$provider->slug }}"></i> {{ $provider->label }}
        </a>
    @endforeach
</div>

